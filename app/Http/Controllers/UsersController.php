<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Blade;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;


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
        
        // Get all courses available to the user (either by role assignment or direct enrollment)
        $allCourses = Course::query()
            ->with(['roles', 'users' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->where(function($query) use ($userRole, $user) {
                // Courses assigned to user's role
                $query->whereHas('roles', function($q) use ($userRole) {
                    $q->where('name', $userRole);
                })
                // OR courses the user is directly enrolled in
                ->orWhereHas('users', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->get()
            ->unique('id'); // Ensure no duplicates

        // Separate into role-assigned vs directly enrolled
        $roleAssignedCourses = $allCourses->filter(function($course) use ($userRole) {
            return $course->roles->contains('name', $userRole);
        });

        $directlyEnrolledCourses = $allCourses->filter(function($course) use ($user) {
            return $course->users->contains('id', $user->id);
        });

        return view('users.courses.index', [
            'roleAssignedCourses' => $roleAssignedCourses,
            'directlyEnrolledCourses' => $directlyEnrolledCourses,
            'userRole' => $userRole
        ]);
    }

    public function enroll(Course $course)
    {
        $user = auth()->user();
        
        // Check if already enrolled (either directly or through role)
        $isEnrolled = $user->courses()
            ->where('course_id', $course->id)
            ->exists();

        if ($isEnrolled) {
            return back()->with('error', 'You already have access to this course');
        }

        // Check if course is assigned to user's role
        $isRoleAssigned = $course->roles()
            ->where('name', $user->role_name)
            ->exists();

        // Enroll the user
        $user->courses()->attach($course->id, [
            'role_name' => $user->role_name,
            'created_at' => now(),
            'updated_at' => now(),
            'is_direct_enrollment' => !$isRoleAssigned // Mark if this is a direct enrollment
        ]);
        
        return back()->with('success', 'Successfully enrolled in ' . $course->course_name);
    }

    public function unenroll(Course $course)
    {
        $user = auth()->user();
        
        // Only allow unenrolling from directly enrolled courses
        $enrollment = $user->courses()
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'You are not enrolled in this course');
        }

        // Prevent unenrolling from role-assigned courses
        if ($enrollment->pivot->is_direct_enrollment === 0) {
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
        
        // Calculate quiz statistics
        $quizAttempts = $user->quizAttempts()->get();
        $totalQuestions = $quizAttempts->sum('total_questions');
        $totalCorrectAnswers = $quizAttempts->sum('score');
        $avgQuizScore = $totalQuestions > 0 ? ($totalCorrectAnswers / $totalQuestions) * 100 : 0;
        
        // Get last activity
        $lastActivity = $user->topicAccesses()->latest()->first();
        
        return [
            'completedCourses' => $completedCourses,
            'totalCourses' => $totalCourses,
            'completedTopics' => $completedTopics,
            'totalTopics' => $totalTopics,
            'avgQuizScore' => round($avgQuizScore),
            'totalQuestions' => $totalQuestions,
            'totalCorrectAnswers' => $totalCorrectAnswers,
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

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:12'
        ]);

        // Update user password
        $newPassword = $request->password;
        $user->password = Hash::make($newPassword);
        $user->password_changed_at = now();
        $user->save();

        // Send email with new password
        Mail::to($user->email)->send(new PasswordResetMail(
            $newPassword,
            $user->name
        ));

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset and emailed to the user'
        ]);
    }
    
}