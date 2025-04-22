<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\UserSession;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on role
        if ($user->role_name === 'Admin') {
            // Admin
            return redirect()->route('admin.dashboard');
        } else {
            // Non-admin users (Faculty, Staff, Student, Others)
            return redirect()->route('users.dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        // Create new session record
        $session = $user->sessions()->create([
            'login_at' => now()
        ]);
        
        // Store session ID for logout tracking
        session(['current_session_id' => $session->id]);
        
        return redirect()->intended($this->redirectPath());
    }
    
    public function logout(Request $request)
    {
        // Update the session record if exists
        if ($sessionId = session('current_session_id')) {
            $session = UserSession::find($sessionId);
            if ($session) {
                $session->update([
                    'logout_at' => now(),
                    'duration_minutes' => now()->diffInMinutes($session->login_at)
                ]);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
