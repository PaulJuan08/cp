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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
        
        $allCourses = Course::query()
            ->with(['roles', 'users' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->where(function($query) use ($userRole, $user) {
                $query->whereHas('roles', function($q) use ($userRole) {
                    $q->where('name', $userRole);
                })
                ->orWhereHas('users', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->get()
            ->unique('id');

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

    public function enroll($encryptedCourseId)
    {
        try {
            $courseId = Crypt::decrypt($encryptedCourseId);
            $course = Course::findOrFail($courseId);
            $user = auth()->user();
            
            $isEnrolled = $user->courses()
                ->where('course_id', $course->id)
                ->exists();

            if ($isEnrolled) {
                return back()->with('error', 'You already have access to this course');
            }

            $isRoleAssigned = $course->roles()
                ->where('name', $user->role_name)
                ->exists();

            $user->courses()->attach($course->id, [
                'role_name' => $user->role_name,
                'created_at' => now(),
                'updated_at' => now(),
                'is_direct_enrollment' => !$isRoleAssigned
            ]);
            
            return back()->with('success', 'Successfully enrolled in ' . $course->course_name);
            
        } catch (DecryptException $e) {
            return back()->with('error', 'Invalid course identifier');
        }
    }

    public function unenroll($encryptedCourseId)
    {
        try {
            $courseId = Crypt::decrypt($encryptedCourseId);
            $course = Course::findOrFail($courseId);
            $user = auth()->user();
            
            $enrollment = $user->courses()
                ->where('course_id', $course->id)
                ->first();

            if (!$enrollment) {
                return back()->with('error', 'You are not enrolled in this course');
            }

            if ($enrollment->pivot->is_direct_enrollment === 0) {
                return back()->with('error', 'This course is required for your role and cannot be unenrolled');
            }
            
            $user->courses()->detach($course->id);
            
            return back()->with('success', 'Successfully unenrolled from ' . $course->course_name);
            
        } catch (DecryptException $e) {
            return back()->with('error', 'Invalid course identifier');
        }
    }

    public function dashboard()
    {
        $user = Auth::user();
        
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
                   $user->hasPassedQuiz($topic->encrypted_id);
        })->count();

        $totalTopics = $course->topics->count();

        return $totalTopics > 0 ? (int) round(($completedTopics / $totalTopics) * 100) : 0;
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

    

    public function show($encryptedUserId)
    {
        try {
            $userId = Crypt::decrypt($encryptedUserId);
            $user = User::findOrFail($userId);
            
            $metrics = [
                'completedCourses' => 0,
                'totalCourses' => 0,
                'completedTopics' => 0,
                'totalTopics' => 0,
                'avgQuizScore' => 0,
                'totalQuestions' => 0,
                'totalCorrectAnswers' => 0,
                'totalTimeSpent' => 0,
                'avgTimePerTopic' => 0
            ];

            if ($user) {
                $metrics = $this->calculateUserMetrics($user);
                
                $courses = $user->courses()
                    ->withCount(['topics', 'quizzes'])
                    ->get()
                    ->each(function($course) use ($user) {
                        $course->progress = $this->calculateCourseProgress($user, $course);
                    });
                
                $recentTopics = $user->completedTopics()
                    ->with('courses')
                    ->latest()
                    ->take(5)
                    ->get();
            } else {
                $courses = collect();
                $recentTopics = collect();
            }

            return view('admin.users.show', [
                'user' => $user,
                'metrics' => $metrics,
                'courses' => $courses ?? collect(),
                'recentTopics' => $recentTopics ?? collect()
            ]);
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid user identifier');
        }
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
        $courses = $user->courses()->withCount('topics')->get();
        $totalCourses = $courses->count();  
        
        $completedCourses = $courses->filter(function($course) use ($user) {
            $completedTopics = $user->completedTopics()
                                ->whereIn('topic_id', $course->topics->pluck('id'))
                                ->count();
            return $completedTopics == $course->topics_count;
        })->count();

        $totalTopics = $courses->sum('topics_count');
        $completedTopics = $user->completedTopics()->count();
        
        $quizAttempts = $user->quizAttempts()->get();
        $totalQuestions = $quizAttempts->sum('total_questions');
        $totalCorrectAnswers = $quizAttempts->sum('score');
        $avgQuizScore = $totalQuestions > 0 ? ($totalCorrectAnswers / $totalQuestions) * 100 : 0;
        
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

    public function edit($encryptedUserId)
    {
        try {
            $userId = Crypt::decrypt($encryptedUserId);
            $user = User::findOrFail($userId);
            return view('admin.users.edit', ['user' => $user]);
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid user identifier');
        }
    }

    public function update(Request $request, $encryptedUserId)
    {
        try {
            $userId = Crypt::decrypt($encryptedUserId);
            $user = User::findOrFail($userId);
            
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

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

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
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid user identifier');
        }
    }

    public function destroy($encryptedUserId)
    {
        try {
            $userId = Crypt::decrypt($encryptedUserId);
            $user = User::findOrFail($userId);
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid user identifier');
        }
    }

    public function resetPassword(Request $request, $encryptedUserId)
    {
        try {
            $userId = Crypt::decrypt($encryptedUserId);
            $user = User::findOrFail($userId);
            
            $request->validate([
                'password' => 'required|string|min:12'
            ]);

            $newPassword = $request->password;
            $user->password = Hash::make($newPassword);
            $user->password_changed_at = now();
            $user->save();

            Mail::to($user->email)->send(new PasswordResetMail(
                $newPassword,
                $user->name
            ));

            return response()->json([
                'success' => true,
                'message' => 'Password has been reset and emailed to the user'
            ]);
            
        } catch (DecryptException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user identifier'
            ], 400);
        }
    }
}