<?php

namespace App\Http\Controllers;

<<<<<<< Updated upstream
=======
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Course;
use App\Models\User; 
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
use App\Models\Topic;
use App\Models\User; 
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
<<<<<<< Updated upstream
=======
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> parent of c90dbe7 (done major functionalities)
>>>>>>> Stashed changes
use Illuminate\Support\Facades\Auth;
use App\Models\TermsAndCondition;

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
    
<<<<<<< Updated upstream
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

    // Terms and Conditions Management
    public function indexTerms()
    {
        $terms = TermsAndCondition::orderBy('created_at', 'desc')->get();
        return view('admin.terms.index', compact('terms'));
    }

    public function createTerms()
    {
        return view('admin.terms.create');
    }

    public function storeTerms(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        TermsAndCondition::create([
            'content' => $request->content,
            'is_published' => false
        ]);

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms draft created successfully');
    }

    public function editTerms($id)
    {
        $terms = TermsAndCondition::findOrFail($id);
        return view('admin.terms.edit', compact('terms'));
    }

    public function updateTerms(Request $request, $id)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $terms = TermsAndCondition::findOrFail($id);
        $terms->update([
            'content' => $request->content
        ]);

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms updated successfully');
    }

    public function publishTerms($id)
    {
        // Unpublish all other terms
        TermsAndCondition::query()->update(['is_published' => false]);
        
        // Publish selected terms
        $terms = TermsAndCondition::findOrFail($id);
        $terms->update([
            'is_published' => true,
            'published_at' => now()
        ]);

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms published successfully');
    }

    public function destroyTerms($id)
    {
        $terms = TermsAndCondition::findOrFail($id);
        
        // Prevent deletion of published terms
        if ($terms->is_published) {
            return redirect()->back()
                ->with('error', 'Cannot delete published terms');
        }

        $terms->delete();

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms deleted successfully');
    }

    
=======
>>>>>>> Stashed changes
}

