<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CourseRole;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersCoursesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userRole = $user->role_name;
        
        // Get courses assigned to the user's role through course_roles table
        $assignedCourses = Course::whereHas('assignedRoles', function($query) use ($userRole): void {
            $query->where('role_name', $userRole);
        })->get();

        // Get courses the user is enrolled in
        $enrolledCourses = $user->courses;
        
        // Available courses are those assigned to their role but not yet enrolled
        $availableCourses = $assignedCourses->diff($enrolledCourses);
        
        return view('users.courses.index', [
            'assignedCourses' => $assignedCourses,
            'availableCourses' => $availableCourses,
            'enrolledCourses' => $enrolledCourses,
            'userRole' => $userRole
        ]);
    }

    // public function show($id)
    // {
    //     $user = Auth::user();
    //     $userRole = $user->role_name;
        
    //     $course = Course::with([
    //         'topics',
    //         'users' => function($query) use ($user) {
    //             $query->where('users.id', $user->id);
    //         },
    //         'assignedRoles'
    //     ])->findOrFail($id);

    //     // Check if user has access (either enrolled or course is assigned to their role)
    //     $isEnrolled = $course->users->contains($user->id);
    //     $isAssigned = $course->assignedRoles->contains('role_name', $userRole);
        
    //     if (!$isEnrolled && !$isAssigned) {
    //         return redirect()->route('users.courses.index')
    //             ->with('error', 'You do not have access to this course');
    //     }

    //     $progress = $this->calculateCourseProgress($user, $course);
        
    //     return view('users.courses.show', [
    //         'course' => $course,
    //         'topics' => $course->topics,
    //         'progress' => $progress,
    //         'isEnrolled' => $isEnrolled
    //     ]);
    // }

    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $user = Auth::user();
            $userRole = $user->role_name;

            $course = Course::with(['topics.quizzes', /* other relationships */])
            ->findOrFail($id);
            
            $course = Course::with([
                'topics',
                'users' => function($query) use ($user) {
                    $query->where('users.id', $user->id);
                },
                'assignedRoles'
            ])->findOrFail($id);

            // Check if user has access (either enrolled or course is assigned to their role)
            $isEnrolled = $course->users->contains($user->id);
            $isAssigned = $course->assignedRoles->contains('role_name', $userRole);
            
            if (!$isEnrolled && !$isAssigned) {
                return redirect()->route('users.courses.index')
                    ->with('error', 'You do not have access to this course');
            }

            $progress = $this->calculateCourseProgress($user, $course);
            
            return view('users.courses.show', [
                'course' => $course,
                'topics' => $course->topics,
                'progress' => $progress,
                'isEnrolled' => $isEnrolled,
                'encryptedCourseId' => $encryptedId // Pass encrypted ID to view
            ]);
            
        } catch (DecryptException $e) {
            return redirect()->route('users.courses.index')
                ->with('error', 'Invalid course identifier');
        }
    }


    // public function enroll(Course $course)
    // {
    //     $user = Auth::user();
    //     $userRole = $user->role_name;
        
    //     // Check if course is assigned to user's role using course_roles table
    //     $isAssigned = CourseRole::where('course_id', $course->id)
    //         ->where('role_name', $userRole)
    //         ->exists();

    //     if (!$isAssigned) {
    //         return back()->with('error', 'This course is not available for your role');
    //     }
        
    //     // Check if already enrolled
    //     if ($user->courses()->where('course_id', $course->id)->exists()) {
    //         return back()->with('error', 'You are already enrolled in this course');
    //     }
        
    //     // Enroll the user
    //     $user->courses()->attach($course->id, [
    //         'role_name' => $userRole,
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);
        
    //     return back()->with('success', 'Successfully enrolled in ' . $course->course_name);
    // }

    public function enroll($encryptedCourseId)
    {
        try {
            $courseId = Crypt::decrypt($encryptedCourseId);
            $course = Course::findOrFail($courseId);
            $user = Auth::user();
            $userRole = $user->role_name;
            
            // Check if course is assigned to user's role using course_roles table
            $isAssigned = CourseRole::where('course_id', $course->id)
                ->where('role_name', $userRole)
                ->exists();

            if (!$isAssigned) {
                return back()->with('error', 'This course is not available for your role');
            }
            
            // Check if already enrolled
            if ($user->courses()->where('course_id', $course->id)->exists()) {
                return back()->with('error', 'You are already enrolled in this course');
            }
            
            // Enroll the user
            $user->courses()->attach($course->id, [
                'role_name' => $userRole,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return redirect()->route('users.courses.show', $encryptedCourseId)
                ->with('success', 'Successfully enrolled in ' . $course->course_name);
                
        } catch (DecryptException $e) {
            return redirect()->route('users.courses.index')
                ->with('error', 'Invalid course identifier');
        }
    }

    // public function unenroll(Course $course)
    // {
    //     $user = Auth::user();
        
    //     // Prevent unenrolling from mandatory role-assigned courses
    //     if ($course->roles()->where('name', $user->role_name)->exists()) {
    //         return back()->with('error', 'This course is required for your role and cannot be unenrolled');
    //     }
        
    //     $user->courses()->detach($course->id);
        
    //     return back()->with('success', 'Successfully unenrolled from ' . $course->course_name);
    // }

    public function unenroll($encryptedCourseId)
    {
        try {
            $courseId = Crypt::decrypt($encryptedCourseId);
            $course = Course::findOrFail($courseId);
            $user = Auth::user();
            
            // Prevent unenrolling from mandatory role-assigned courses
            if ($course->roles()->where('name', $user->role_name)->exists()) {
                return back()->with('error', 'This course is required for your role and cannot be unenrolled');
            }
            
            $user->courses()->detach($course->id);
            
            return redirect()->route('users.courses.index')
                ->with('success', 'Successfully unenrolled from ' . $course->course_name);
                
        } catch (DecryptException $e) {
            return redirect()->route('users.courses.index')
                ->with('error', 'Invalid course identifier');
        }
    }

    // public function certificate(Course $course)
    // {
    //     $user = Auth::user();
        
    //     if (!$this->hasCompletedCourse($user, $course)) {
    //         return redirect()->route('users.courses.show', $course)
    //             ->with('error', 'You must complete the course to download the certificate.');
    //     }

    //     $pdf = PDF::loadView('users.courses.certificate', [
    //         'user' => $user,
    //         'course' => $course,
    //         'date' => now()->format('F j, Y')
    //     ]);
        
    //     return $pdf->stream("certificate-{$course->slug}-{$user->id}.pdf");
    // }

    public function certificate($encryptedCourseId)
    {
        try {
            $courseId = Crypt::decrypt($encryptedCourseId);
            $course = Course::findOrFail($courseId);
            $user = Auth::user();
            
            if (!$this->hasCompletedCourse($user, $course)) {
                return redirect()->route('users.courses.show', $encryptedCourseId)
                    ->with('error', 'You must complete the course to download the certificate.');
            }

            $pdf = PDF::loadView('users.courses.certificate', [
                'user' => $user,
                'course' => $course,
                'date' => now()->format('F j, Y')
            ]);
            
            return $pdf->stream("certificate-{$course->slug}-{$user->id}.pdf");
            
        } catch (DecryptException $e) {
            return redirect()->route('users.courses.index')
                ->with('error', 'Invalid course identifier');
        }
    }

    // private function calculateCourseProgress($user, $course)
    // {
    //     $completedTopics = $course->topics->filter(function($topic) use ($user) {
    //         return $user->hasCompletedTopic($topic) && $user->hasPassedQuiz($topic->id);
    //     })->count();

    //     $totalTopics = $course->topics->count();

    //     return $totalTopics > 0 ? (int) round(($completedTopics / $totalTopics) * 100) : 0;
    // }

    private function calculateCourseProgress($user, $course)
    {
        $completedTopics = $course->topics->filter(function($topic) use ($user) {
            return $user->hasCompletedTopic($topic) && $user->hasPassedQuiz($topic->id);
        })->count();

        $totalTopics = $course->topics->count();

        return $totalTopics > 0 ? (int) round(($completedTopics / $totalTopics) * 100) : 0;
    }

    // private function hasCompletedCourse($user, $course)
    // {
    //     $totalTopics = $course->topics->count();
    //     $completedTopics = $course->topics->filter(function($topic) use ($user) {
    //         return $user->hasCompletedTopic($topic) && $user->hasPassedQuiz($topic->id);
    //     })->count();

    //     return $totalTopics > 0 && $completedTopics === $totalTopics;
    // }

    private function hasCompletedCourse($user, $course)
    {
        $totalTopics = $course->topics->count();
        $completedTopics = $course->topics->filter(function($topic) use ($user) {
            return $user->hasCompletedTopic($topic) && $user->hasPassedQuiz($topic->id);
        })->count();

        return $totalTopics > 0 && $completedTopics === $totalTopics;
    }
}