<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[260px]">
        <div class="container mx-auto p-6">
            
            <!-- Modal Button -->
            <button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none" 
                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-modal-example" data-hs-overlay="#hs-modal-example">
                Add Item
            </button>
            <!-- End Modal Button -->

            <!-- Modal Content -->
            <div id="hs-modal-example" class="hs-overlay hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50" role="dialog" tabindex="-1" aria-labelledby="hs-modal-example-label">
                <div class="bg-white border border-gray-200 shadow-2xs rounded-xl w-full max-w-lg p-6 dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="hs-modal-example-label" class="font-bold text-gray-800 dark:text-white">Add Question</h3>
                        <button type="button" class="size-8 inline-flex justify-center items-center rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none" 
                            aria-label="Close" data-hs-overlay="#hs-modal-example">
                            <span class="sr-only">Close</span>
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form to Add Question -->
                    <form action="{{ route('admin.topics.quiz.questions.store', ['topic' =>  $quiz->id, 'quiz' => $quiz->id]) }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label class="text-lg font-semibold text-gray-700">Question:</label>
                            <input type="text" name="question_text" class="w-full p-2 border rounded-md" required>
                        </div>

                        <div class="mt-4">
                            <label class="text-lg font-semibold text-gray-700">Correct Answer:</label>
                            <input type="text" name="answer_text" class="w-full p-2 border rounded-md" required>
                        </div>

                        <div class="flex justify-end mt-6 gap-4">
                            <button type="button" class="py-2 px-3 text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none" data-hs-overlay="#hs-modal-example">
                                Close
                            </button>
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
                
                <div class="mt-4">
                    <h2 class="text-xl font-semibold text-gray-500">{{ $quiz->title }}</h2>
                </div>

                <!-- List of Questions with Multiple Choice Answers -->
                @if($quiz->questions->isEmpty())
                    <p class="text-red-500">No questions found for this quiz.</p>
                @else
                    <div class="mt-6 space-y-4">
                    @foreach($quiz->questions as $index => $question)
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $index + 1 }}. {{ $question->question_text }}
                            </p>

                            @if($question->answers->isEmpty())
                                <p class="mt-2 text-red-500">No answers provided.</p>
                            @else
                                <ul class="mt-2 list-disc pl-6">
                                    @foreach($question->answers as $answer)
                                        <li class="text-gray-700">{{ $answer->answer_text }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach

                    </div>
                @endif
 
            </div>
        </div>
    </div>
</x-app-layout>
