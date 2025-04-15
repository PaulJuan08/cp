<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Blade;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    // public function userindex()
    // {
    //     return view('users.dashboard'); 
    // }

    public function userindex()
    {
        $user = auth()->user();
        
        return view('users.courses.index', [
            'courses' => Course::whereDoesntHave('users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->get(),
            'enrolledCourses' => $user->courses()->get()
        ]);
    }

    public function enroll(Course $course)
    {
        $user = auth()->user();
        
        // Check if already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'You are already enrolled in this course');
        }
        
        // Enroll the user with default 'Student' role
        $user->courses()->attach($course->id, [
            'role_name' => 'Student',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return back()->with('success', 'Successfully enrolled in ' . $course->course_name);
    }

    public function unenroll(Course $course)
    {
        $user = auth()->user();
        $user->courses()->detach($course->id);
        
        return back()->with('success', 'Successfully unenrolled from ' . $course->course_name);
    }

    // public function dashboard()
    // {
    //     $userRole = Auth::user()->role_name;
        
    //     return view('user.dashboard', [
    //         'user' => $userRole,
    //     ]);
    // }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Get courses with progress data and role information
        $userCourses = $user->courses()
            ->with(['topics.quizzes.attempts' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get()
            ->each(function($course) use ($user) {
                // Manually add the user's role for this course
                $course->user_role = $course->users()->find($user->id)->pivot->role_name ?? 'Participant';
            });

        return view('users.dashboard', [
            'user' => $user,
            'userCourses' => $userCourses
        ]);
    }

    public function boot()
    {
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role_name === $role;
        });
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|string|max:20',
            'role_name' => 'required|string|in:Admin,Faculty,Staff,Student,Others',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'role_name' => $validated['role_name'],
            'password' => Hash::make($validated['password']),
        ];

        // Add role-specific fields
        if (in_array($validated['role_name'], ['Faculty', 'Staff'])) {
            $userData['employee_id'] = $request->input('employee_id');
        }
        
        if ($validated['role_name'] === 'Faculty') {
            $userData['department'] = $request->input('department');
        }
        
        if ($validated['role_name'] === 'Staff') {
            $userData['office_unit'] = $request->input('office_unit');
        }
        
        if ($validated['role_name'] === 'Student') {
            $userData['student_id'] = $request->input('student_id');
            $userData['college_department'] = $request->input('college_department');
        }
        
        if ($validated['role_name'] === 'Others') {
            $userData['stakeholder'] = $request->input('stakeholder');
        }

        User::create($userData);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    // public function show(User $user)
    // {
    //     return view('admin.users.show', compact('user'));
    // }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'contact' => 'required|string|max:20',
            'role_name' => 'required|string|in:Admin,Faculty,Staff,Student,Others',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'role_name' => $validated['role_name'],
        ];

        // Update password if provided
        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        // Update role-specific fields
        if (in_array($validated['role_name'], ['Faculty', 'Staff'])) {
            $userData['employee_id'] = $request->input('employee_id');
        }
        
        if ($validated['role_name'] === 'Faculty') {
            $userData['department'] = $request->input('department');
        }
        
        if ($validated['role_name'] === 'Staff') {
            $userData['office_unit'] = $request->input('office_unit');
        }
        
        if ($validated['role_name'] === 'Student') {
            $userData['student_id'] = $request->input('student_id');
            $userData['college_department'] = $request->input('college_department');
        }
        
        if ($validated['role_name'] === 'Others') {
            $userData['stakeholder'] = $request->input('stakeholder');
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}