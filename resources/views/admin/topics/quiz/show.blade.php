<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[240px]">
        <div class="container mx-auto p-6">
            
            <div class="mt-4 flex justify-end">
                <!-- View as Users Button -->
                <a href="{{ route('admin.topics.quiz.user_quiz', [
                    'encryptedTopic' => encrypt($topic->id), 
                    'encryptedQuiz' => encrypt($quiz->id)
                ]) }}" 
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 
                text-white hover:bg-blue-700 focus:outline-none">
                    View as Users
                </a>
            </div>

            <!-- Add Question Modal -->
            <div id="hs-modal-example" class="hs-overlay hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50" 
            role="dialog" tabindex="-1" aria-labelledby="hs-modal-example-label">
                <div class="bg-white border border-gray-200 shadow-2xs rounded-xl w-full max-w-lg p-6 dark:bg-neutral-800 
                dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="hs-modal-example-label" class="font-bold text-gray-800 dark:text-white">Add Question</h3>
                        <button type="button" class="size-8 inline-flex justify-center items-center rounded-full bg-gray-100 text-gray-800 
                        hover:bg-gray-200 focus:outline-none" 
                            aria-label="Close" data-hs-overlay="#hs-modal-example">
                            <span class="sr-only">Close</span>
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Add Question Form -->
                    <form action="{{ route('admin.topics.quiz.questions.store', [
                        'encryptedTopic' => encrypt($topic->id), 
                        'encryptedQuiz' => encrypt($quiz->id)
                    ]) }}" method="POST">
                        @csrf

                        <!-- Question Input -->
                        <div class="mt-4">
                            <label class="text-lg font-semibold text-gray-700">Question:</label>
                            <input type="text" name="question_text" class="w-full p-2 border rounded-md" required>
                        </div>

                        <!-- Correct Answers Section -->
                        <div class="mt-4" x-data="{ correctAnswers: [''] }">
                            <label class="text-lg font-semibold text-gray-700">Correct Answers:</label>
                            <template x-for="(answer, index) in correctAnswers" :key="index">
                                <div class="flex gap-2 mt-2">
                                    <input type="text" :name="'correct_answers[]'" class="w-full p-2 border rounded-md" placeholder="Correct Answer" 
                                    required>
                                    <button type="button" class="bg-red-500 text-white px-2 rounded-md hover:bg-red-600" 
                                            @click="correctAnswers.splice(index, 1)">
                                        &times;
                                    </button>
                                </div>
                            </template>
                            <button type="button" class="mt-2 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
                                    @click="correctAnswers.push('')">
                                + Add Correct Answer
                            </button>
                        </div>

                        <!-- Options Section -->
                        <div class="mt-4" x-data="{ options: [''] }">
                            <label class="text-lg font-semibold text-gray-700">Options:</label>
                            <template x-for="(option, index) in options" :key="index">
                                <div class="flex gap-2 mt-2">
                                    <input type="text" :name="'options[]'" class="w-full p-2 border rounded-md" placeholder="Option" required>
                                    <button type="button" class="bg-red-500 text-white px-2 rounded-md hover:bg-red-600" 
                                            @click="options.splice(index, 1)">
                                        &times;
                                    </button>
                                </div>
                            </template>
                            <button type="button" class="mt-2 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
                                    @click="options.push('')">
                                + Add Option
                            </button>
                        </div>

                        <!-- Form Submit -->
                        <div class="flex justify-end mt-6 gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Question Modal -->
            <div id="edit-question-modal" class="hs-overlay hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="bg-white border border-gray-200 shadow-2xs rounded-xl w-full max-w-lg p-6">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Edit Question</h3>
                        <button type="button" class="size-8 inline-flex justify-center items-center rounded-full bg-gray-100 text-gray-800 
                        hover:bg-gray-200 focus:outline-none" data-hs-overlay="#edit-question-modal">
                            <span class="sr-only">Close</span>
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form id="edit-question-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <label class="text-lg font-semibold text-gray-700">Question:</label>
                            <input type="text" name="question_text" id="edit-question-text" class="w-full p-2 border rounded-md" required>
                        </div>
                        <!-- Add answer/option fields as needed -->
                        <div class="flex justify-end mt-6 gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold text-gray-800">Topic: <span class="font-semibold">{{ $topic->topic_name }}</span></h1>
                
                @if($quiz->questions->isEmpty())
                    <p class="text-red-500">No questions found for this quiz.</p>
                @else
                    <div class="mt-6 space-y-4">
                        @foreach($quiz->questions as $index => $question)
                            <div class="p-4 border rounded-lg bg-gray-50 relative">
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $index + 1 }}. {{ $question->question_text }}
                                </p>

                                @if($question->answers->isEmpty())
                                    <p class="mt-2 text-red-500">No answers provided.</p>
                                @else
                                    <ul class="mt-2 list-disc pl-6">
                                        @php
                                            $correctAnswers = $question->answers->where('is_correct', 1);
                                            $options = $question->answers->where('is_correct', 0);
                                        @endphp

                                        @if(!$correctAnswers->isEmpty())
                                            <li class="text-green-600 font-semibold">
                                                ✅ Correct Answers:
                                                <ul class="ml-4 list-disc">
                                                    @foreach($correctAnswers as $answer)
                                                        <li>{{ $answer->answer_text }}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <p class="mt-2 text-red-500">No correct answer provided.</p>
                                        @endif

                                        @if(!$options->isEmpty())
                                            <li class="text-gray-600 font-semibold mt-2">
                                                ❌ Options:
                                                <ul class="ml-4 list-disc">
                                                    @foreach($options as $option)
                                                        <li>{{ $option->answer_text }}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    </ul>
                                @endif

                                <div class="absolute bottom-2 right-2">
                                    <div class="hs-dropdown relative">
                                        <button type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm 
                                        font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none">
                                            Actions
                                            <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" 
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="m6 9 6 6 6-6"/>
                                            </svg>
                                        </button>

                                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 
                                        hidden min-w-60 bg-white shadow-md rounded-lg mt-2 divide-y divide-gray-200">
                                            <div class="p-1 space-y-0.5">
                                                <!-- Edit Button -->
                                                <button type="button" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm 
                                                text-gray-800 hover:bg-gray-100 focus:outline-none edit-question-btn"
                                                    data-question-id="{{ $question->id }}"
                                                    data-question-text="{{ $question->question_text }}"
                                                    data-update-url="{{ route('admin.topics.quiz.questions.update', [
                                                        'encryptedTopic' => encrypt($topic->id),
                                                        'encryptedQuiz' => encrypt($quiz->id),
                                                        'encryptedQuestion' => encrypt($question->id)
                                                    ]) }}">
                                                    ✎ Edit
                                                </button>

                                                <!-- Delete Form -->
                                                <form action="{{ route('admin.topics.quiz.questions.destroy', [
                                                    'encryptedTopic' => encrypt($topic->id), 
                                                    'encryptedQuiz' => encrypt($quiz->id), 
                                                    'encryptedQuestion' => encrypt($question->id)
                                                ]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg 
                                                    text-sm text-gray-800 hover:bg-gray-100 focus:outline-none">
                                                        ❌ Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <div class="mt-10 flex justify-end">
                    <button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border 
                    border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none" 
                        data-hs-overlay="#hs-modal-example">
                        Add Item
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.2/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit question modal handling
            const editButtons = document.querySelectorAll('.edit-question-btn');
            const editModal = document.getElementById('edit-question-modal');
            const editForm = document.getElementById('edit-question-form');
            const editQuestionText = document.getElementById('edit-question-text');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const questionId = this.getAttribute('data-question-id');
                    const questionText = this.getAttribute('data-question-text');
                    const updateUrl = this.getAttribute('data-update-url');
                    
                    editQuestionText.value = questionText;
                    editForm.action = updateUrl;
                    
                    // Open the modal
                    const hsOverlay = new HSOverlay(editModal);
                    hsOverlay.open();
                });
            });
            
            // Initialize HS Overlays
            document.querySelectorAll('[data-hs-overlay]').forEach(function(el) {
                new HSOverlay(el);
            });
        });
    </script>
</x-app-layout>