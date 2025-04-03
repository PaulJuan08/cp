<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Pass the users variable to the view
        return view('admin.users.index', ['users' => $users]);
    }

    public function userindex()
    {
        return view('users.dashboard'); 
    }

    public function dashboard()
    {
        $userRole = Auth::user()->role_name;
        
        return view('user.dashboard', [
            'user' => $userRole,
            // Add any other user-specific data here
        ]);
    }
}
