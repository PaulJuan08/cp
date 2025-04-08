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
        document.addEventListener('DOMContentLoaded', function() {
            const quizForm = document.getElementById('quizForm');
            if (quizForm) {
                quizForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        
                        const result = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(result.message || 'Submission failed');
                        }
                        
                        // Show result in modal
                        const modal = document.getElementById('quizResultModal');
                        const title = document.getElementById('quizResultTitle');
                        const message = document.getElementById('quizResultMessage');
                        const retryBtn = document.getElementById('quizResultRetry');
                        const closeBtn = document.getElementById('quizResultClose');
                        
                        title.textContent = result.passed ? 'Quiz Passed!' : 'Quiz Results';
                        message.textContent = result.message;
                        
                        if (result.passed) {
                            retryBtn.classList.add('hidden');
                            closeBtn.textContent = result.next_topic_available ? 'Next Topic' : 'Continue';
                            
                            // Update the UI for the completed topic
                            const completedRow = document.querySelector(`tr[data-topic-id="${result.topic_id}"]`);
                            if (completedRow) {
                                // Update status to Completed
                                completedRow.querySelector('td:nth-child(3)').innerHTML = 
                                    '<span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Completed</span>';
                                
                                // Update action button
                                const actionCell = completedRow.querySelector('td:nth-child(4)');
                                if (actionCell) {
                                    actionCell.innerHTML = `
                                        <a href="${actionCell.querySelector('a').href}" 
                                        class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                            Retake Quiz
                                        </a>`;
                                }
                                
                                // Unlock next topic if available
                                if (result.next_topic_available) {
                                    const nextRow = completedRow.nextElementSibling;
                                    if (nextRow) {
                                        // Update status to Available
                                        nextRow.querySelector('td:nth-child(3)').innerHTML = 
                                            '<span class="px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded">Available</span>';
                                        
                                        // Enable the topic link
                                        const topicLink = nextRow.querySelector('td:nth-child(2) a');
                                        if (topicLink) {
                                            topicLink.classList.remove('text-gray-400');
                                            topicLink.classList.add('text-gray-900', 'hover:text-blue-600');
                                        }
                                    }
                                }
                            }
                            
                            // Update progress bar
                            document.querySelector('.progress-percent').textContent = `${result.progress}%`;
                            document.querySelector('.progress-bar').style.width = `${result.progress}%`;
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
                            if (result.passed && result.next_topic_available) {
                                window.location.href = result.next_topic_url;
                            } else {
                                window.location.reload();
                            }
                        };
                        
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error submitting quiz: ' + error.message);
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                });
            }
        });
    </script>
</x-app-layout>