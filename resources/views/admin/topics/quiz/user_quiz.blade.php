<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[260px]">
        <div class="container mx-auto p-6">
            <form action="#" method="POST">
                @csrf
                
                <div class="mt-6 space-y-4">
                    @foreach($quiz->questions as $index => $question)
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $index + 1 }}. {{ $question->question_text }}
                            </p>

                            @php
                                $correctAnswers = $question->answers->where('is_correct', 1)->pluck('answer_text')->toArray();
                                $options = $question->answers->pluck('answer_text')->toArray();

                                // Ensure all correct answers are included in options
                                foreach ($correctAnswers as $correctAnswer) {
                                    if (!in_array($correctAnswer, $options)) {
                                        array_push($options, $correctAnswer);
                                    }
                                }

                                // If less than 4 options, add random fillers
                                while (count($options) < 4) {
                                    array_push($options, "Random Option " . rand(1, 100));
                                }

                                shuffle($options); // Shuffle options randomly
                            @endphp

                            <div class="grid space-y-2 mt-3">
                                @foreach($options as $option)
                                    <label class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm">
                                        <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}"
                                            class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                        
                                        <span class="text-sm ms-3 text-gray-500">
                                            {{ $option }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Submit Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
