<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CertificateController extends Controller
{
    // For admin printing certificates
    public function print($encryptedUser, $encryptedCourse)
    {
        try {
            $userId = Crypt::decrypt($encryptedUser);
            $courseId = Crypt::decrypt($encryptedCourse);
            
            $user = User::findOrFail($userId);
            $course = $user->courses()->findOrFail($courseId);
            
            return $this->generateCertificate($user, $course);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user or course specified'
            ], 404);
        }
    }

    // Shared certificate generation logic
    protected function generateCertificate(User $user, Course $course)
    {
        // Check if course is completed (using pivot progress)
        if ($course->pivot->progress < 100) {
            return response()->json([
                'success' => false,
                'message' => 'Course not completed. Current progress: '.$course->pivot->progress.'%'
            ], 403);
        }

        $certificateData = [
            'userName' => $user->name,
            'courseName' => $course->course_name,
            'completionDate' => $course->pivot->updated_at->format('F j, Y'),
            'certificateId' => 'CERT-'.strtoupper(uniqid()),
            'adminGenerated' => auth()->user()->isAdmin(), // Flag for admin-generated certs
        ];
        
        $pdf = Pdf::loadView('certificates.template', $certificateData);
        return $pdf->download("certificate-{$user->id}-{$course->slug}.pdf");
    }
}