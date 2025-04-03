<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User; 
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Get the logged-in user's role
        $userRole = Auth::user()->role;

        $totalCourses = Course::count(); 
        $totalUsers = User::count();   
        $totalTopics = Topic::count();

        // Pass totalUsers and totalTopics to the view
        return view('admin.dashboard', ['users' => $users], compact('totalCourses', 'totalTopics', 'totalUsers'));
    }
    
    public function assignCourseToRoles(Request $request, Course $course)
    {
        $validated = $request->validate([
            'role_names' => 'required|array',
            'role_names.*' => 'string|exists:users,role_name', // Ensure role names exist
        ]);

        // Assign course to multiple role_names
        foreach ($validated['role_names'] as $roleName) {
            DB::table('course_role')->updateOrInsert([
                'course_id' => $course->id,
                'role_name' => $roleName,
            ]);
        }

        return redirect()->back()->with('success', 'Course assigned to roles successfully.');
    }


    
}

