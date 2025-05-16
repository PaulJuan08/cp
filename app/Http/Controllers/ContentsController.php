<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ContentsController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return view('admin.contents.index', compact('topics'));
    }

    // public function show($id)
    // {
    //     $topic = Topic::findOrFail($id); // Find the topic or throw 404

    //     return view('admin.contents.index', compact('topic'));
    // }

    public function show($encryptedId)
    {
        try {
            // Decrypt the ID
            $id = Crypt::decrypt($encryptedId);
            
            // Find the topic or throw 404
            $topic = Topic::findOrFail($id);

            return view('admin.contents.index', compact('topic'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid topic identifier');
        }
    }


}

