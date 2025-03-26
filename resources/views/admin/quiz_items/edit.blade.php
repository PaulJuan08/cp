<x-app-layout>
@extends('layouts.admindashboard')

<!-- Content -->

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Question</h1>
        <a href="{{ route('admin.topics.quiz.show', $topic) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.topics.quiz.items.update', [$topic, $item]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Question Type</label>
                    <select name="item[question_type]" class="form-select" id="questionType" required>
                        @foreach($questionTypes as $key => $type)
                            <option value="{{ $key }}" {{ $item->question_type == $key ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <textarea name="item[question]" class="form-control" rows="3" required>{{ old('item.question', $item->question) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Points</label>
                            <input type="number" name="item[points]" class="form-control" 
                                   value="{{ old('item.points', $item->points) }}" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" name="item[order]" class="form-control" 
                                   value="{{ old('item.order', $item->order) }}" min="1">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Explanation (optional)</label>
                    <textarea name="item[explanation]" class="form-control" rows="2">{{ old('item.explanation', $item->explanation) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Multiple Choice Options -->
        <div class="card mb-4" id="multipleChoiceCard" style="{{ !$item->isMultipleChoice() ? 'display:none' : '' }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Multiple Choice Options</h5>
                <button type="button" class="btn btn-sm btn-outline-primary" id="addOption">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>
            <div class="card-body" id="optionsContainer">
                @foreach($item->options as $index => $option)
                    <div class="row mb-3 option-row">
                        <div class="col-md-9">
                            <input type="text" name="options[{{ $index }}][text]" 
                                   class="form-control option-text" 
                                   value="{{ old("options.$index.text", $option->option_text) }}"
                                   placeholder="Option {{ $index+1 }}" required>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check pt-2">
                                <input type="radio" name="correct_option" 
                                       class="form-check-input correct-option" 
                                       value="{{ $index }}" 
                                       {{ $option->is_correct ? 'checked' : '' }}>
                                <label class="form-check-label">Correct</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            @if($index >= 2) {{-- Don't allow deleting if less than 2 options --}}
                                <button type="button" class="btn btn-sm btn-danger remove-option">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- True/False Options -->
        <div class="card mb-4" id="trueFalseCard" style="{{ !$item->isTrueFalse() ? 'display:none' : '' }}">
            <div class="card-header">
                <h5>True/False Options</h5>
            </div>
            <div class="card-body">
                @php
                    $correctOption = $item->options->firstWhere('is_correct', true);
                @endphp
                <div class="form-check mb-3">
                    <input type="radio" name="options[0][is_correct]" 
                           class="form-check-input" value="1" 
                           {{ $correctOption && $correctOption->option_text === 'True' ? 'checked' : '' }}>
                    <label class="form-check-label">True</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="options[0][is_correct]" 
                           class="form-check-input" value="0"
                           {{ $correctOption && $correctOption->option_text === 'False' ? 'checked' : '' }}>
                    <label class="form-check-label">False</label>
                </div>
            </div>
        </div>

        <!-- Short Answer/Essay Options -->
        <div class="card mb-4" id="textAnswerCard" style="{{ $item->isMultipleChoice() || $item->isTrueFalse() ? 'display:none' : '' }}">
            <div class="card-header">
                <h5>Answer Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Model Answer</label>
                    <textarea name="answer[correct_answer]" class="form-control" rows="3">{{ old('answer.correct_answer', $item->answer->correct_answer ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keywords (comma separated)</label>
                    <input type="text" name="answer[keywords]" class="form-control" 
                           value="{{ old('answer.keywords', $item->answer->keywords ?? '') }}" 
                           placeholder="keyword1, keyword2, keyword3">
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Question
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle question type sections
    const questionType = document.getElementById('questionType');
    const mcCard = document.getElementById('multipleChoiceCard');
    const tfCard = document.getElementById('trueFalseCard');
    const taCard = document.getElementById('textAnswerCard');

    questionType.addEventListener('change', function() {
        const type = this.value;
        mcCard.style.display = type === 'multiple_choice' ? 'block' : 'none';
        tfCard.style.display = type === 'true_false' ? 'block' : 'none';
        taCard.style.display = ['short_answer', 'essay'].includes(type) ? 'block' : 'none';
    });

    // Add/remove options for multiple choice
    const optionsContainer = document.getElementById('optionsContainer');
    const addOptionBtn = document.getElementById('addOption');
    let optionCount = {{ $item->options->count() }};

    addOptionBtn.addEventListener('click', function() {
        const newOption = document.createElement('div');
        newOption.className = 'row mb-3 option-row';
        newOption.innerHTML = `
            <div class="col-md-9">
                <input type="text" name="options[${optionCount}][text]" 
                       class="form-control option-text" 
                       placeholder="Option ${optionCount+1}" required>
            </div>
            <div class="col-md-2">
                <div class="form-check pt-2">
                    <input type="radio" name="correct_option" 
                           class="form-check-input correct-option" 
                           value="${optionCount}">
                    <label class="form-check-label">Correct</label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger remove-option">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        optionsContainer.appendChild(newOption);
        optionCount++;
    });

    optionsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option')) {
            const optionRow = e.target.closest('.option-row');
            if (document.querySelectorAll('.option-row').length > 2) {
                optionRow.remove();
                // Reindex remaining options
                document.querySelectorAll('.option-row').forEach((row, index) => {
                    row.querySelector('.option-text').name = `options[${index}][text]`;
                    row.querySelector('.correct-option').value = index;
                });
                optionCount = document.querySelectorAll('.option-row').length;
            }
        }
    });
});
</script>
</x-app-layout>