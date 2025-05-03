<?php

namespace App\Http\Controllers;

use App\Models\Utility;

class UtilityController extends Controller
{
    public function show($type)
    {
        $utility = Utility::where('type', $type)
            ->where('is_published', true)
            ->firstOrFail();
            
        return view('utility.show', compact('utility'));
    }

    
}