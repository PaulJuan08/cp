<x-app-layout>
@extends('layouts.admindashboard')

<!-- Content -->

<div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <div id="scrollspy" class="space-y-10 md:space-y-16">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add Question to: {{ $quiz->title }}</h1>
        <a href="{{ route('admin.topics.quiz.show', $topic) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.topics.quiz.items.store', $topic) }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Question Type</label>
                    <select name="item[question_type]" class="form-select" id="questionType" required>
                        @foreach($questionTypes as $key => $type)
                            <option value="{{ $key }}" {{ old('item.question_type') == $key ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <textarea name="item[question]" class="form-control" rows="3" required>{{ old('item.question') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Points</label>
                            <input type="number" name="item[points]" class="form-control" 
                                   value="{{ old('item.points', 1) }}" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" name="item[order]" class="form-control" 
                                   value="{{ old('item.order', $quiz->items->count() + 1) }}" min="1">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Explanation (optional)</label>
                    <textarea name="item[explanation]" class="form-control" rows="2">{{ old('item.explanation') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Multiple Choice Options -->
        <div class="card mb-4" id="multipleChoiceCard">
            <div class="card-header">
                <h5>Multiple Choice Options</h5>
            </div>
            <div class="card-body">
                @for($i = 0; $i < 4; $i++)
                    <div class="row mb-3 option-row">
                        <div class="col-md-9">
                            <input type="text" name="options[{{ $i }}][text]" 
                                   class="form-control option-text" 
                                   value="{{ old("options.$i.text") }}"
                                   placeholder="Option {{ $i+1 }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check pt-2">
                                <input type="radio" name="options[{{ $i }}][is_correct]" 
                                       class="form-check-input correct-option" 
                                       value="1" {{ old("options.$i.is_correct") ? 'checked' : '' }}>
                                <label class="form-check-label">Correct Answer</label>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- True/False Options -->
        <div class="card mb-4 d-none" id="trueFalseCard">
            <div class="card-header">
                <h5>True/False Options</h5>
            </div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input type="radio" name="options[0][is_correct]" 
                           class="form-check-input" value="1" 
                           {{ old('options.0.is_correct') ? 'checked' : '' }}>
                    <label class="form-check-label">True</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="options[0][is_correct]" 
                           class="form-check-input" value="0"
                           {{ !old('options.0.is_correct') && old('options') ? 'checked' : '' }}>
                    <label class="form-check-label">False</label>
                </div>
            </div>
        </div>

        <!-- Short Answer/Essay Options -->
        <div class="card mb-4 d-none" id="textAnswerCard">
            <div class="card-header">
                <h5>Answer Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Model Answer</label>
                    <textarea name="answer[correct_answer]" class="form-control" rows="3">{{ old('answer.correct_answer') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keywords (comma separated)</label>
                    <input type="text" name="answer[keywords]" class="form-control" 
                           value="{{ old('answer.keywords') }}" 
                           placeholder="keyword1, keyword2, keyword3">
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Question
            </button>
        </div>
    </form>
</div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionType = document.getElementById('questionType');
    const mcCard = document.getElementById('multipleChoiceCard');
    const tfCard = document.getElementById('trueFalseCard');
    const taCard = document.getElementById('textAnswerCard');

    function toggleCards() {
        const type = questionType.value;
        mcCard.classList.toggle('d-none', type !== 'multiple_choice');
        tfCard.classList.toggle('d-none', type !== 'true_false');
        taCard.classList.toggle('d-none', !['short_answer', 'essay'].includes(type));
    }

    questionType.addEventListener('change', toggleCards);
    toggleCards(); // Initialize
});
</script>
</x-app-layout>