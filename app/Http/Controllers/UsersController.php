<?php

namespace App\Http\Controllers;


use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Pass the users variable to the view
        return view('admin.users.index', ['users' => $users]);
    }
}
