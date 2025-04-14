<x-app-layout>
    @extends('layouts.usersdashboard')

    <div class="lg:ps-[260px]">
        <div class="container mx-auto p-6">
            <form id="quiz-form" method="POST" action="{{ route('users.quiz.submit', 
            ['topic' => $topic->id, 'quiz' => $quiz->id]) }}">
                @csrf
                
                <div class="mt-6 space-y-4">
                    <h2 class="text-2xl font-bold mb-4">Quiz for {{ $topic->topic_name }}</h2>
                    
                    @foreach($quiz->questions as $question)
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $loop->iteration }}. {{ $question->question_text }}
                            </p>

                            <div class="grid space-y-2 mt-3">
                                @foreach($question->answers->shuffle() as $answer)
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

                <div class="mt-6 ">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Submit Quiz
                    </button>
                </div>
                <div class="mt-20"></div>
            </form>

            <!-- Quiz Result Modal -->
            <div id="hs-quiz-result-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1">
                <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                    <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-900">
                        <div class="absolute top-2 end-2">
                            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-quiz-result-modal">
                                <span class="sr-only">Close</span>
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>

                        <div class="p-4 sm:p-10 text-center overflow-y-auto">
                            <!-- Icon - Changes based on pass/fail -->
                            <span id="quiz-result-icon" class="mb-4 inline-flex justify-center items-center size-11 rounded-full border-4 border-green-50 bg-green-100 text-green-500 dark:bg-green-700 dark:border-green-600 dark:text-green-100">
                                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                                </svg>
                            </span>

                            <h3 id="quiz-result-title" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                                Quiz Results
                            </h3>
                            <p id="quiz-result-message" class="text-gray-500 dark:text-neutral-500 mb-4">
                                Your score will appear here.
                            </p>
                            
                            <div id="quiz-score-display" class="mb-6">
                                <div class="text-4xl font-bold text-blue-600 dark:text-blue-500" id="quiz-score-percentage">0%</div>
                                <div class="text-sm text-gray-500 dark:text-neutral-400 mt-1">
                                    <span id="quiz-correct-answers">0</span> out of <span id="quiz-total-questions">0</span> correct
                                </div>
                            </div>

                            <div class="mt-6 flex justify-center gap-x-4">
                                <button id="quiz-result-retry" type="button" class="hidden py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                    Retry Quiz
                                </button>
                                <button id="quiz-result-close" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-blue-700">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quizForm = document.getElementById('quiz-form');
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
                        const modal = document.getElementById('hs-quiz-result-modal');
                        const icon = document.getElementById('quiz-result-icon');
                        const title = document.getElementById('quiz-result-title');
                        const message = document.getElementById('quiz-result-message');
                        const scorePercentage = document.getElementById('quiz-score-percentage');
                        const correctAnswers = document.getElementById('quiz-correct-answers');
                        const totalQuestions = document.getElementById('quiz-total-questions');
                        const retryBtn = document.getElementById('quiz-result-retry');
                        const closeBtn = document.getElementById('quiz-result-close');
                        const controllertotal = result.total;
                        
                        // Calculate percentage
                        const score = Number(result.score) || 0;
                        const total = Math.max(Number(result.total_questions) || 1, 1); // Ensure ≥1
                        const percentage = Math.round((score / controllertotal) * 100);
                        
                        // Update modal content
                        if (result.passed) {
                            title.textContent = 'Quiz Passed!';
                            message.textContent = result.message || 'Congratulations! You have passed the quiz.';
                            
                            // Success icon
                            icon.className = 'mb-4 inline-flex justify-center items-center size-11 rounded-full border-4 border-green-50 bg-green-100 text-green-500 dark:bg-green-700 dark:border-green-600 dark:text-green-100';
                            icon.innerHTML = '<svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>';
                            
                            retryBtn.classList.add('hidden');
                            closeBtn.textContent = result.next_topic_available ? 'Next Topic' : 'Continue';
                            
                            // Set close button action for passing
                            closeBtn.onclick = function() {
                                HSOverlay.close(modal);
                                if (result.next_topic_available && result.next_topic_url) {
                                    window.location.href = result.next_topic_url;
                                } else {
                                    window.location.href = "{{ route('users.dashboard') }}";
                                }
                            };
                        } else {
                            title.textContent = 'Quiz Not Passed';
                            message.textContent = result.message || 'You need to score higher to pass this quiz. Please try again.';
                            
                            // Warning icon
                            icon.className = 'mb-4 inline-flex justify-center items-center size-11 rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500 dark:bg-yellow-700 dark:border-yellow-600 dark:text-yellow-100';
                            icon.innerHTML = '<svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>';
                            
                            retryBtn.classList.remove('hidden');
                            closeBtn.textContent = 'Review Material';
                            
                            // Set button actions for failing
                            retryBtn.onclick = function() {
                                HSOverlay.close(modal);
                                window.location.reload(); // Reloads the quiz page to retry
                            };
                            
                            closeBtn.onclick = function() {
                                HSOverlay.close(modal);
                                window.location.href = "{{ route('users.courses.show', $topic->id) }}"; // Goes back to topic materials
                            };
                        }
                        
                        // Update score display
                        scorePercentage.textContent = `${percentage}%`;
                        correctAnswers.textContent = result.score;
                        totalQuestions.textContent = result.total_questions;
                        
                        // Show modal
                        HSOverlay.open(modal);
                        
                        // Update the UI for the completed topic if passed
                        if (result.passed) {
                            const completedRow = document.querySelector(`tr[data-topic-id="${result.topic_id}"]`);
                            if (completedRow) {
                                // Update status to Completed
                                completedRow.querySelector('td:nth-child(3)').innerHTML = 
                                    '<span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Completed</span>';
                                
                                // Update action button
                                const actionCell = completedRow.querySelector('td:nth-child(4)');
                                if (actionCell) {
                                    actionCell.innerHTML = `
                                        <a href="{{ route('users.quiz.show', ['topic' => $topic->id, 'quiz' => $quiz->id]) }}" 
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
                            const progressPercent = document.querySelector('.progress-percent');
                            const progressBar = document.querySelector('.progress-bar');
                            if (progressPercent && progressBar) {
                                progressPercent.textContent = `${result.progress}%`;
                                progressBar.style.width = `${result.progress}%`;
                            }
                        }
                        
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