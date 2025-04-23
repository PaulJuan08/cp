<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersContentsController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return view('users.contents.index', compact('topics'));
    }

    // public function show($id)
    // {
    //     $topic = Topic::with('quizzes')->findOrFail($id);
    //     return view('users.contents.index', compact('topic'));
    // }

    public function show($encryptedTopicId)
    {
        try {
            // Decrypt the ID
            $id = Crypt::decrypt($encryptedTopicId);
            
            // Find the topic with quizzes
            $topic = Topic::with('quizzes')->findOrFail($id);
            
            return view('users.contents.index', [
                'topic' => $topic,
                'encryptedId' => $encryptedTopicId // Pass encrypted ID to view if needed
            ]);
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid topic identifier');
        }
    }

    
}
