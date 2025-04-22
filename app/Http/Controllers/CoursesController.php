<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Role;
use App\Models\Topic;
use App\Models\Course;
use App\Models\CourseRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::with('assignedRoles')->get();
        return view('admin.courses.index', compact('courses'));
    }

    // Show a specific course with its topics
    public function show($id)
    {
        $course = Course::with('topics')->find($id);

        if (!$course) {
            return redirect()->route('admin.courses.index')->with('error', 'Course not found.');
        }

        $topics = Topic::all(); // Fetch all topics for modal selection

        return view('admin.courses.show', compact('course', 'topics'));
    }


    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_desc' => 'nullable|string',
        ]);

        // Save course to database
        Course::create($validatedData);

        return redirect()->route('admin.courses.index')->with('success', 'Course added successfully!');
    }

    // Add a topic to the course
    public function addTopic(Request $request, Course $course)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
        ]);

        // Check if the topic is already associated with this course
        if ($course->topics()->where('topic_id', $request->topic_id)->exists()) {
            return redirect()->route('admin.courses.show', $course->id)
                ->with('warning', 'This topic is already added to the course.');
        }

        $course->topics()->attach($request->topic_id);

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Topic added successfully.');
    }

    public function assignRoles(Request $request, Course $course)
    {
        $validated = $request->validate([
            'roles' => 'sometimes|array',
            'roles.*' => 'string|in:Faculty,Staff,Student,Others'
        ]);

        try {
            DB::beginTransaction();
            
            // Get current unique roles to prevent duplicates
            $currentRoles = $course->assignedRoles->pluck('role_name')->unique()->toArray();
            
            // Only add roles that aren't already assigned
            $rolesToAdd = array_diff($validated['roles'] ?? [], $currentRoles);
            
            // Remove roles that aren't in the new selection
            $rolesToRemove = array_diff($currentRoles, $validated['roles'] ?? []);
            
            if (!empty($rolesToRemove)) {
                $course->assignedRoles()
                    ->whereIn('role_name', $rolesToRemove)
                    ->delete();
            }
            
            // Add new roles
            if (!empty($rolesToAdd)) {
                $rolesToAdd = array_map(function($role) {
                    return ['role_name' => $role];
                }, $rolesToAdd);
                
                $course->assignedRoles()->createMany($rolesToAdd);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Roles assigned successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign roles: ' . $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $course = Course::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->course_name = $request->course_name;
        $course->course_desc = $request->course_desc;
        $course->save();

        return redirect()->back()->with('success', 'Course updated successfully');
    }


    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->back()->with('success', 'Course deleted successfully');
    }

    // public function removeTopic(Request $request, Course $course)
    // {
    //     $request->validate([
    //         'topic_id' => 'required|exists:topics,id'
    //     ]);

    //     $course->topics()->detach($request->topic_id);

    //     return back()->with('success', 'Topic removed from course successfully');
    // }

    public function removeTopic($courseId, $topicId)
    {
        $course = Course::findOrFail($courseId);
        $course->topics()->detach($topicId);

        return redirect()->back()->with('success', 'Topic removed from course.');
    }

    // Show the list of users enrolled in the course
    public function showUsers($courseId)
    {
        \Log::info("Attempting to fetch users for course: {$courseId}");
        
        try {
            $course = Course::with(['assignedRoles.user'])->findOrFail($courseId);
            
            Log::info("Found course: {$course->course_name}");
            \Log::info("Assigned roles count: " . $course->assignedRoles->count());
            
            $enrolledUsers = $course->assignedRoles
                ->whereNotNull('user_id')
                ->map(function($role) {
                    \Log::info("Processing role: {$role->id}, User: " . ($role->user ? $role->user->id : 'null'));
                    return [
                        'user_id' => $role->user_id,
                        'user_name' => $role->user->name ?? 'Unknown User',
                        'role_name' => $role->role_name
                    ];
                })
                ->values()
                ->toArray();
                
            \Log::info("Returning users: " . json_encode($enrolledUsers));
            
            return response()->json([
                'success' => true,
                'users' => $enrolledUsers,
                'course_name' => $course->course_name
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error fetching users: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch users: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function removeUser($courseId, $userId)
    // {
    //     try {
    //         $course = Course::findOrFail($courseId);
            
    //         // Delete from course_roles table
    //         $course->assignedRoles()
    //             ->where('user_id', $userId)
    //             ->delete();
            
    //         return response()->json(['success' => true]);
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to remove user: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

}

