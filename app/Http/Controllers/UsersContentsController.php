<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class UsersContentsController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return view('users.contents.index', compact('topics'));
    }

    public function show($id)
    {
        $topic = Topic::with('quizzes')->findOrFail($id);
        return view('users.contents.index', compact('topic'));
    }
}
