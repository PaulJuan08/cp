<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class ContentsController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return view('admin.contents.index', compact('topics'));
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id); // Find the topic or throw 404

        return view('admin.contents.index', compact('topic'));
    }


}

