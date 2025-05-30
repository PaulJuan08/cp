<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Mail::to('dpo@cmu.edu.ph')->send(new ContactFormMail($validated));
        Mail::to('pauljuanz08@gmail.com')->send(new ContactFormMail($validated));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}