<x-app-layout>
    @extends('layouts.usersdashboard')

    <div class="lg:ps-[260px]">
        <div class="container mx-auto p-6">
            <form id="quiz-form" method="POST" action="{{ route('users.quiz.submit', 
            ['topic' => $topic->id, 'quiz' => $quiz->id]) }}">
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
        document.getElementById('quiz-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...
            `;
            
            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (!data.success) {
                    throw new Error(data.message || 'Error submitting quiz');
                }
                
                // Safely handle modal elements
                const modal = document.getElementById('quizResultModal');
                const title = document.getElementById('quizResultTitle');
                const message = document.getElementById('quizResultMessage');
                const retryBtn = document.getElementById('quizResultRetry');
                const closeBtn = document.getElementById('quizResultClose');
                
                // Check if elements exist before manipulating them
                if (!modal || !title || !message || !retryBtn || !closeBtn) {
                    console.error('Modal elements not found');
                    alert(`You scored ${data.score} out of ${data.total} (${data.percentage}%)\n${data.feedback}`);
                    window.location.reload();
                    return;
                }
                
                title.textContent = data.passed ? 'Quiz Passed!' : 'Quiz Results';
                message.textContent = data.message;
                
                if (data.passed) {
                    retryBtn.classList.add('hidden');
                    closeBtn.textContent = data.next_topic_available ? 'Next Topic' : 'Continue';
                } else {
                    retryBtn.classList.remove('hidden');
                    closeBtn.textContent = 'Review Material';
                }
                
                modal.classList.remove('hidden');
                
                // Set up button handlers
                retryBtn.onclick = function() {
                    modal.classList.add('hidden');
                    window.location.reload();
                };
                
                closeBtn.onclick = function() {
                    modal.classList.add('hidden');
                    if (data.passed && data.next_topic_available) {
                        window.location.href = data.next_topic_url;
                    } else {
                        window.location.reload();
                    }
                };
                
            } catch (error) {
                console.error('Error:', error);
                alert(error.message);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    </script>
</x-app-layout>