<?php

namespace App\Http\Controllers;

use App\Models\Course; 
use App\Models\User; 
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;

class CertificateController extends Controller 
{
    // For admin printing certificates
    public function print($encryptedUser, $encryptedCourse)
    {
        try {
            $userId = Crypt::decrypt($encryptedUser);
            $courseId = Crypt::decrypt($encryptedCourse);
            
            $user = User::findOrFail($userId);
            $course = Course::with('topics')->findOrFail($courseId);
            
            // Calculate the progress instead of trying to access it from pivot
            $progress = $this->calculateCourseProgress($user, $course);
            
            // Pass true for adminGenerated since this is called from admin controller
            return $this->generateCertificate($user, $course, $progress, true);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 404);
        }
    }
    
    // Calculation of course progress
    protected function calculateCourseProgress(User $user, Course $course)
    {
        $totalTopics = $course->topics->count();
        
        if ($totalTopics === 0) {
            return 0;
        }
        
        $completedTopics = $user->completedTopics()
            ->whereHas('courses', function($query) use ($course) {
                $query->where('courses.id', $course->id);
            })
            ->count();
        
        return min(round(($completedTopics / $totalTopics) * 100), 100);
    }
    
    // Alternative approach without a dedicated certificates table
    protected function getCertificateCount($year, $month)
    {
        $cacheKey = "certificate_count_{$year}_{$month}";
        
        if (Cache::has($cacheKey)) {
            $count = Cache::get($cacheKey) + 1;
        } else {
            $count = 1;
        }
        
        Cache::put($cacheKey, $count, now()->addDays(32)); // Store for more than a month
        
        return $count;
    }
    
    // Shared certificate generation logic
    protected function generateCertificate(User $user, Course $course, $progress, $adminGenerated = false)
    {
        // Check if course is completed
        if ($progress < 100) {
            return response()->json([
                'success' => false,
                'message' => 'Course not completed. Current progress: ' . $progress . '%'
            ], 403);
        }
        
        // Get the current year and month
        $year = date('Y');
        $month = date('m');
        
        // Get certificate number for this month using the helper method
        $certificateCount = $this->getCertificateCount($year, $month);
        
        // Format the certificate ID: YYYY-MM-XXXX (where XXXX is padded with zeros)
        $certificateId = $year . '-' . $month . '-' . str_pad($certificateCount, 4, '0', STR_PAD_LEFT);
        
        $certificateData = [
            'userName' => $user->name,
            'courseName' => $course->course_name,
            'completionDate' => now()->format('F j, Y'),
            'certificateId' => $certificateId,
            'adminGenerated' => $adminGenerated
        ];
        
        // Load PDF view and set orientation to landscape and paper size to A4
        $pdf = Pdf::loadView('certificates.template', $certificateData);
        $pdf->setPaper('a4', 'landscape');
        
        // Optional: Set additional options if needed
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        return $pdf->download("certificate-{$user->id}-{$course->slug}.pdf");
    }
}