<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Course;
use App\Models\User; 
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
    
}

