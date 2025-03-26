<?php
namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\{QuizItem, QuizOption};

class QuizOptionController extends Controller
{
    public function store(Request $request, Topic $topic, QuizItem $item)
    {
        $validated = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'sometimes|boolean',
            'order' => 'sometimes|integer'
        ]);

        $option = $item->options()->create($validated);
        
        return response()->json([
            'success' => true,
            'option' => $option
        ]);
    }

    public function update(Request $request, Topic $topic, QuizItem $item, QuizOption $option)
    {
        $validated = $request->validate([
            'option_text' => 'sometimes|string',
            'is_correct' => 'sometimes|boolean',
            'order' => 'sometimes|integer'
        ]);

        $option->update($validated);
        
        return response()->json(['success' => true]);
    }

    public function destroy(Topic $topic, QuizItem $item, QuizOption $option)
    {
        $option->delete();
        return response()->json(['success' => true]);
    }
}