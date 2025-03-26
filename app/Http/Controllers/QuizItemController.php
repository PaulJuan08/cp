<?php
namespace App\Http\Controllers;

use App\Models\{Topic, QuizItem};
use Illuminate\Http\Request;

class QuizItemController extends Controller
{
    public function create(Topic $topic)
    {
        $quiz = $topic->quiz;
        $questionTypes = QuizItem::TYPES;
        return view('admin.quiz_items.create', compact('topic', 'quiz', 'questionTypes'));
    }

    public function store(Request $request, Topic $topic)
    {
        $quiz = $topic->quiz;
        
        $validated = $this->validateItem($request);
        
        $item = $quiz->items()->create($validated['item']);
        
        $this->handleQuestionType($item, $validated);
        
        $quiz->updateTotalPoints();

        return redirect()->route('admin.topics.quiz.show', $topic)
            ->with('success', 'Question added successfully');
    }

    public function edit(Topic $topic, QuizItem $item)
    {
        $item->load(['options', 'answer']);
        $questionTypes = QuizItem::TYPES;
        return view('admin.quiz_items.edit', compact('topic', 'item', 'questionTypes'));
    }

    public function update(Request $request, Topic $topic, QuizItem $item)
    {
        $validated = $this->validateItem($request);
        
        $item->update($validated['item']);
        
        $this->handleQuestionType($item, $validated, true);
        
        $item->quiz->updateTotalPoints();

        return redirect()->route('admin.topics.quiz.show', $topic)
            ->with('success', 'Question updated successfully');
    }

    public function destroy(Topic $topic, QuizItem $item)
    {
        $item->delete();
        $item->quiz->updateTotalPoints();
        return back()->with('success', 'Question deleted successfully');
    }

    protected function validateItem(Request $request): array
    {
        return $request->validate([
            'item.question' => 'required|string',
            'item.question_type' => 'required|in:'.implode(',', array_keys(QuizItem::TYPES)),
            'item.points' => 'required|integer|min:1',
            'item.explanation' => 'nullable|string',
            'item.order' => 'sometimes|integer',
            
            'options' => 'required_if:item.question_type,multiple_choice,true_false|array',
            'options.*.text' => 'required_with:options|string',
            'options.*.is_correct' => 'sometimes|boolean',
            
            'answer.correct_answer' => 'required_if:item.question_type,short_answer,essay|nullable|string',
            'answer.keywords' => 'nullable|string',
            'answer.max_words' => 'nullable|integer|min:1'
        ]);
    }

    protected function handleQuestionType(QuizItem $item, array $validated, bool $isUpdate = false): void
    {
        switch ($item->question_type) {
            case 'multiple_choice':
                if ($isUpdate) $item->options()->delete();
                foreach ($validated['options'] as $option) {
                    $item->options()->create($option);
                }
                break;
                
            case 'true_false':
                if ($isUpdate) $item->options()->delete();
                $item->options()->createMany([
                    ['option_text' => 'True', 'is_correct' => $validated['options'][0]['is_correct']],
                    ['option_text' => 'False', 'is_correct' => !$validated['options'][0]['is_correct']]
                ]);
                break;
                
            case 'short_answer':
            case 'essay':
                if ($isUpdate && $item->answer) {
                    $item->answer()->update($validated['answer']);
                } else {
                    $item->answer()->create($validated['answer']);
                }
                break;
        }
    }
}