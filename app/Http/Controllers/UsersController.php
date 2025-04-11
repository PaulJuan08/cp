<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
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
        ]);
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

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

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