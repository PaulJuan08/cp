<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Topic;

class CoursesController extends Controller
{
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


    public function index()
    {
        $courses = Course::all(); // Fetch all courses
        return view('admin.courses.index', compact('courses'));
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

        $course->topics()->attach($request->topic_id);

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Topic added successfully.');
    }



}
