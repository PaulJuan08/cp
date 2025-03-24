<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'contact' => ['nullable', 'string', 'max:50'],
            'role_name' => ['required', 'string', 'max:50'],
            'employeeID' => ['nullable', 'string', 'max:100'],
            'college_department' => ['nullable', 'string', 'max:255'],
            'office_unit' => ['nullable', 'string', 'max:255'],
            'studentID' => ['nullable', 'string', 'max:100'],
            'stake_holder' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'role_name' => $request->role_name,
            'employeeID' => $request->employeeID,
            'college_department' => $request->college_department,
            'office_unit' => $request->office_unit,
            'studentID' => $request->studentID,
            'stake_holder' => $request->stake_holder,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
