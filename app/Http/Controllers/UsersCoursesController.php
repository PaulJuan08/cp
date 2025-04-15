<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersCoursesController extends Controller
{
    // Show all available courses with enrollment status
    public function index()
    {
        $user = Auth::user();
        
        // Get courses assigned to user's role
        $assignedCourses = Course::whereHas('assignedRoles', function($query) use ($user) {
            $query->where('role_name', $user->role_name);
        })->get();

        // Get courses the user is enrolled in (regardless of role assignment)
        $enrolledCourses = $user->courses;

        // Get all available courses (excluding already enrolled)
        $availableCourses = Course::whereDoesntHave('users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();

        return view('users.courses.index', [
            'assignedCourses' => $assignedCourses,
            'enrolledCourses' => $enrolledCourses,
            'availableCourses' => $availableCourses,
            'userRole' => $user->role_name
        ]);
    }

    // Show course details
    public function show($id)
    {
        $user = Auth::user();
        $course = Course::with(['topics', 'users' => function($query) use ($user) {
            $query->where('users.id', $user->id);
        }])->findOrFail($id);

        // Check if user is enrolled or the course is assigned to their role
        $isEnrolled = $course->users->contains($user->id);
        $isAssigned = $course->assignedRoles()
            ->where('role_name', $user->role_name)
            ->exists();

        if (!$isEnrolled && !$isAssigned) {
            return redirect()->route('users.courses.index')
                ->with('error', 'You must enroll in this course first.');
        }

        $topics = $course->topics;
        $progress = $this->calculateCourseProgress($user, $course);

        return view('users.courses.show', compact('course', 'topics', 'progress', 'isEnrolled'));
    }

    // Handle course enrollment
    public function enroll(Course $course)
    {
        $user = Auth::user();
        
        // Check if already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        // Enroll with default 'Student' role
        $user->courses()->attach($course->id, [
            'role_name' => 'Student',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Successfully enrolled in ' . $course->course_name);
    }

    // Handle unenrollment
    public function unenroll(Course $course)
    {
        $user = Auth::user();
        
        // Prevent unenrolling from role-assigned courses
        if ($course->assignedRoles()->where('role_name', $user->role_name)->exists()) {
            return back()->with('error', 'Cannot unenroll from a course assigned to your role.');
        }

        $user->courses()->detach($course->id);
        
        return back()->with('success', 'Successfully unenrolled from ' . $course->course_name);
    }

    // Generate certificate
    public function certificate(Course $course)
    {
        $user = Auth::user();
        
        // Verify user has completed the course
        if (!$this->hasCompletedCourse($user, $course)) {
            return redirect()->route('users.courses.show', $course)
                ->with('error', 'You must complete the course to download the certificate.');
        }

        $pdf = PDF::loadView('users.courses.certificate', [
            'user' => $user,
            'course' => $course,
            'date' => now()->format('F j, Y')
        ]);
        
        return $pdf->stream("certificate-{$course->slug}-{$user->id}.pdf");
    }

    // Helper method to calculate course progress
    private function calculateCourseProgress($user, $course)
    {
        $completedTopics = $course->topics->filter(function($topic) use ($user) {
            return $user->hasCompletedTopic($topic) && $user->hasPassedQuiz($topic->id);
        })->count();

        $totalTopics = $course->topics->count();

        return $totalTopics > 0 ? (int) round(($completedTopics / $totalTopics) * 100) : 0;
    }

    // Helper method to check course completion
    private function hasCompletedCourse($user, $course)
    {
        $totalTopics = $course->topics->count();
        $completedTopics = $course->topics->filter(function($topic) use ($user) {
            return $user->hasCompletedTopic($topic) && $user->hasPassedQuiz($topic->id);
        })->count();

        return $totalTopics > 0 && $completedTopics === $totalTopics;
    }
}