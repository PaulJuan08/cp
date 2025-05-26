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
    public function print($encryptedUser, $encryptedCourse)
    {
        try {
            $userId = Crypt::decrypt($encryptedUser);
            $courseId = Crypt::decrypt($encryptedCourse);
            
            $user = User::findOrFail($userId);
            $course = Course::with('topics')->findOrFail($courseId);
            
            $progress = $this->calculateCourseProgress($user, $course);
            
            return $this->generateCertificate($user, $course, $progress);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 404);
        }
    }
    
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
    
    protected function getCertificateCount($year, $month)
    {
        $cacheKey = "certificate_count_{$year}_{$month}";
        
        return Cache::remember($cacheKey, now()->addDays(32), function() {
            return 1;
        }) + 1;
    }
    
    protected function generateCertificate(User $user, Course $course, $progress)
    {
        if ($progress < 100) {
            return response()->json([
                'success' => false,
                'message' => 'Course not completed. Current progress: ' . $progress . '%'
            ], 403);
        }
        
        $year = date('Y');
        $month = date('m');
        $certificateCount = $this->getCertificateCount($year, $month);
        $certificateId = $year . '-' . $month . '-' . str_pad($certificateCount, 4, '0', STR_PAD_LEFT);
        
        $certificateData = [
            'userName' => $user->name,
            'courseName' => $course->course_name,
            'courseDescription' => $course->description,
            'completionDate' => now()->format('F j, Y'),
            'certificateId' => $certificateId
        ];
        
        $pdf = Pdf::loadView('certificates.template', $certificateData);
        $pdf->setPaper('a4', 'landscape');
        
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        return $pdf->download("certificate-{$course->slug}-{$user->id}.pdf");
    }
}