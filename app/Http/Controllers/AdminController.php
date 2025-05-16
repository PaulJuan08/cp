<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User; 
use App\Models\Course;
use App\Models\Utility;
use Illuminate\Http\Request;
use App\Models\TermsAndCondition;
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


    // Display all utilities
    public function utilitiesIndex()
    {
        $utilities = Utility::paginate(10); // 10 items per page
        return view('admin.utility.index', compact('utilities'));
    }

    // Show create form
    public function createUtility()
    {
        return view('admin.utility.create');
    }

    // Store new utility
    public function storeUtility(Request $request)
    {
        $request->validate([
            'type' => 'required|in:terms,privacy,cookies',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'nullable|boolean'
        ]);

        // Handle publishing logic
        if ($request->is_published && $request->type === 'terms') {
            Utility::where('type', 'terms')->update(['is_published' => false]);
        }

        Utility::create([
            'type' => $request->type,
            'title' => $request->title,
            'content' => $request->content,
            'is_published' => $request->is_published ?? false
        ]);

        return redirect()->route('admin.utilities.index')
            ->with('success', 'Utility created successfully!');
    }

    // Show edit form
    public function editUtility(Utility $utility)
    {
        return view('admin.utility.edit', compact('utility'));
    }

    // Update utility
    public function updateUtility(Request $request, Utility $utility)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $utility->update($validated);

        return redirect()->route('admin.utilities.index')
            ->with('success', 'Utility updated successfully.');
    }

    // Toggle publish status
    public function togglePublish(Utility $utility)
    {
        // If publishing a terms policy, unpublish all other terms policies
        if ($utility->type === 'terms' && !$utility->is_published) {
            Utility::where('type', 'terms')
                ->where('id', '!=', $utility->id)
                ->update(['is_published' => false]);
        }

        $utility->update(['is_published' => !$utility->is_published]);
        
        return back()->with('success', 'Publish status updated.');
    }

    // Delete utility
    public function deleteUtility(Utility $utility)
    {
        $utility->delete();
        return back()->with('success', 'Utility deleted successfully.');
    }

}

