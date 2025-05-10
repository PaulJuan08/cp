<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;


class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'login_at',
        'logout_at',
        'duration_minutes'
    ];

    protected $dates = ['login_at', 'logout_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
