<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class UsersCoursesController extends Controller
{
    // Show courses assigned to current user's role
    public function index()
    {
        $userRole = Auth::user()->role_name;
        
        $courses = Course::whereHas('assignedRoles', function($query) use ($userRole) {
            $query->where('role_name', $userRole);
        })->get();

        return view('users.courses.index', compact('courses'));
    }

    public function show($id)
    {
        $userRole = Auth::user()->role_name;
        
        $course = Course::with(['topics', 'assignedRoles' => function($query) use ($userRole) {
            $query->where('role_name', $userRole);
        }])->find($id);

        if (!$course || $course->assignedRoles->isEmpty()) {
            return redirect()->route('users.courses.index')->with('error', 'Course not found or not assigned to your role.');
        }

        $topics = Topic::all();
        return view('users.courses.show', compact('course', 'topics'));
    }
}