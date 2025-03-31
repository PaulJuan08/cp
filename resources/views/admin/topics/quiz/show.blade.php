<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[240px]">
        <div class="container mx-auto p-6">
            
            <div class="mt-4 flex justify-end">
                <!-- View as Users Button -->
                <a href="{{ route('admin.topics.quiz.user_quiz', ['topic' => $topic->id, 'quiz' => $quiz->id]) }}" 
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 
                text-white hover:bg-blue-700 focus:outline-none">
                    View as Users
                </a>
            </div>

            
            <!-- Modal Content -->
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
                    <form action="{{ route('admin.topics.quiz.questions.store', ['topic' => $quiz->id, 'quiz' => $quiz->id]) }}" 
                    method="POST">
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
            <!-- End Modal Content -->

            <div class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
                
                <!-- Quiz Title -->
                <h1 class="text-2xl font-bold text-gray-800">Topic: <span class="font-semibold">{{ $topic->topic_name }}</span></h1>
                
                <!-- List of Questions with Multiple Choice and Correct Answers -->
                @if($quiz->questions->isEmpty())
                    <p class="text-red-500">No questions found for this quiz.</p>
                @else
                    <div class="mt-6 space-y-4">
                        @foreach($quiz->questions as $index => $question)
                            <div class="p-4 border rounded-lg bg-gray-50 relative">
                                <!-- Question Text -->
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

                                <!-- Action Dropdown - Positioned Bottom Right -->
                                <div class="absolute bottom-2 right-2">
                                    <div class="hs-dropdown relative">
                                        <button type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm 
                                        font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none" 
                                                aria-haspopup="menu" aria-expanded="false">
                                            Actions
                                            <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" 
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m6 9 6 6 6-6"/>
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 
                                        hidden min-w-60 bg-white shadow-md rounded-lg mt-2 divide-y divide-gray-200" role="menu" aria-orientation="vertical">
                                            <div class="p-1 space-y-0.5">
                                                <!-- Edit Button -->
                                                <button type="button" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm 
                                                text-gray-800 hover:bg-gray-100 focus:outline-none" 
                                                        onclick="openEditModal('{{ $question->id }}', '{{ $question->question_text }}')">
                                                    ✎ Edit
                                                </button>

                                                <!-- Delete Form -->
                                                <form action="{{ route('admin.topics.quiz.questions.destroy', 
                                                ['topic' => $topic->id, 'quiz' => $quiz->id, 'question' => $question->id]) }}" method="POST">
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
                                </div> <!-- End Action Dropdown -->
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <div class="mt-4 flex justify-end">
                    <!-- Add Item Button -->
                    <button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border 
                    border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none" 
                        aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-modal-example" data-hs-overlay="#hs-modal-example">
                        Add Item
                    </button>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.2/dist/cdn.min.js" defer></script>

    <script>
        function openEditModal(questionId, questionText, updateUrl) {
        document.getElementById('editQuestionId').value = questionId;
        document.getElementById('editQuestionText').value = questionText;
        document.getElementById('editForm').action = updateUrl;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    </script>

</x-app-layout>
