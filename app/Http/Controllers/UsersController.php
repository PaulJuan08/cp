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

    public function userindex()
    {
        $user = auth()->user();
        $userRole = $user->role_name;
        
        // Get courses assigned to the user's role
        $assignedCourses = Course::whereHas('roles', function($query) use ($userRole) {
            $query->where('name', $userRole);
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

    public function enroll(Course $course)
    {
        $user = auth()->user();
        
        // Check if course is assigned to user's role
        if (!$course->roles()->where('name', $user->role_name)->exists()) {
            return back()->with('error', 'This course is not available for your role');
        }
        
        // Check if already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'You are already enrolled in this course');
        }
        
        // Enroll the user
        $user->courses()->attach($course->id, [
            'role_name' => $user->role_name,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return back()->with('success', 'Successfully enrolled in ' . $course->course_name);
    }

    public function unenroll(Course $course)
    {
        $user = auth()->user();
        
        // Prevent unenrolling from mandatory role-assigned courses
        if ($course->roles()->where('name', $user->role_name)->exists()) {
            return back()->with('error', 'This course is required for your role and cannot be unenrolled');
        }
        
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
        
        // Get courses with progress data
        $userCourses = $user->courses()
            ->with(['topics.quizzes.attempts' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get()
            ->each(function($course) use ($user) {
                $course->progress = $this->calculateCourseProgress($user, $course);
            });

        return view('users.dashboard', [
            'user' => $user,
            'userCourses' => $userCourses
        ]);
    }

    private function calculateCourseProgress($user, $course)
    {
        $completedTopics = $course->topics->filter(function($topic) use ($user) {
            return $user->hasCompletedTopic($topic) && 
                   $user->hasPassedQuiz($topic->id);
        })->count();

        $totalTopics = $course->topics->count();

        return $totalTopics > 0 ? (int) round(($completedTopics / $totalTopics) * 100) : 0;
    }

    // public function boot()
    // {
    //     Blade::if('role', function ($role) {
    //         return auth()->check() && auth()->user()->role_name === $role;
    //     });
    // }

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

    // public function show(User $user)
    // {
    //     return view('admin.users.show', ['user' => $user]);
    // }

    public function show(User $user)
    {
        // Load user with their courses and progress data
        $user->load([
            'courses' => function($query) {
                $query->withCount('topics');
            },
            'courses.topics' => function($query) use ($user) {
                $query->with(['quizzes' => function($q) use ($user) {
                    $q->with(['attempts' => function($a) use ($user) {
                        $a->where('user_id', $user->id)
                        ->orderByDesc('created_at')
                        ->limit(1);
                    }]);
                }]);
            },
            'topicAccesses'
        ]);

        // Calculate course progress for each course
        $coursesWithProgress = $user->courses->map(function($course) use ($user) {
            $course->progress = $this->calculateCourseProgress($user, $course);
            $course->lastActivity = $this->getLastActivity($user, $course);
            return $course;
        });

        // Calculate overall metrics
        $metrics = $this->calculateUserMetrics($user);

        return view('admin.users.show', [
            'user' => $user,
            'courses' => $coursesWithProgress,
            'metrics' => $metrics
        ]);
    }

    private function getLastActivity(User $user, Course $course)
    {
        if (!method_exists($user, 'topicAccesses')) {
            return null;
        }

        return $user->topicAccesses()
            ->whereIn('topic_id', $course->topics->pluck('id'))
            ->orderByDesc('created_at')
            ->first();
    }

    private function calculateUserMetrics(User $user)
    {
        // Get all courses the user is enrolled in with topics count
        $courses = $user->courses()->withCount('topics')->get();
        
        // Calculate total courses
        $totalCourses = $courses->count();
        
        // Calculate completed courses (all topics completed)
        $completedCourses = $courses->filter(function($course) use ($user) {
            $completedTopics = $user->completedTopics()
                                ->whereIn('topic_id', $course->topics->pluck('id'))
                                ->count();
            return $completedTopics == $course->topics_count;
        })->count();

        // Calculate total topics across all enrolled courses
        $totalTopics = $courses->sum('topics_count');
        
        // Count completed topics
        $completedTopics = $user->completedTopics()->count();
        
        

        // Calculate total time spent (in minutes)
        $totalTimeSpent = $user->topicAccesses()->sum('time_spent') ?? 0;
        
        // Get last activity
        $lastActivity = $user->topicAccesses()->latest()->first();
        
        return [
            'completedCourses' => $completedCourses,
            'totalCourses' => $totalCourses,
            'completedTopics' => $completedTopics,
            'totalTopics' => $totalTopics,
            'totalTimeSpent' => $totalTimeSpent,
            'lastActivity' => $lastActivity,
        ];
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