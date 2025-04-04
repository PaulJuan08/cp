<x-app-layout>
    @extends('layouts.usersdashboard')

    <div class="lg:ps-[260px]">
        <div class="container mx-auto p-6">
            <form id="quiz-form" method="POST" action="{{ route('users.quiz.submit', ['topic' => $topic->id, 'quiz' => $quiz->id]) }}">
                @csrf
                
                <div class="mt-6 space-y-4">
                    <h2 class="text-2xl font-bold mb-4">Quizzes for Topic: {{ $topic->topic_name }}</h2>
                    
                    @foreach($quiz->questions as $question)
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $loop->iteration }}. {{ $question->question_text }}
                            </p>

                            <div class="grid space-y-2 mt-3">
                                @foreach($question->answers as $answer)
                                    <label class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm">
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="{{ $answer->id }}"
                                               class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                        
                                        <span class="text-sm ms-3 text-gray-500">
                                            {{ $answer->answer_text }}
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
    
    <script>
        document.getElementById('quiz-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Submitting...';
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showScoreModal(data);
                } else {
                    alert('Error submitting quiz');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the quiz');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit Quiz';
            });
        });

        function showScoreModal(data) {
            // Implement your modal display logic here
            alert(`You scored ${data.score} out of ${data.total} (${data.percentage}%)\n${data.feedback}`);
        }
    </script>
</x-app-layout>