<x-app-layout>
    @extends('layouts.usersdashboard')

    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('users.courses.index') }}" class="text-red-600 no-underline">&larr; Back to Courses</a>
            </div>

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Course: {{ $course->course_name }}</h2>
            <p class="text-gray-600 dark:text-gray-300">{{ $course->course_desc }}</p>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Course Progress Indicator -->
            <div class="mb-6">
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Course Progress</span>
                    <span class="text-sm font-medium text-gray-700 progress-percent">{{ $course->progressForUser(auth()->user()) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full progress-bar" 
                        style="width: {{ $course->progressForUser(auth()->user()) }}%">
                    </div>
                </div>
            </div>

            <!-- Course Topics List -->
            @if ($course->topics->isEmpty())
                <p class="text-gray-500 mt-4">No topics available for this course.</p>
            @else
                <div class="overflow-x-auto mt-4">
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOPIC NAME</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($course->topics->sortBy('id') as $index => $topic)
                                @php
                                    // Make sure to load quizzes for each topic
                                    $topic->load('quizzes');
                                    $hasQuizzes = $topic->quizzes->isNotEmpty();
                                    
                                    $hasPassedQuiz = auth()->user()->hasPassedQuiz($topic->id);
                                    $isCompleted = auth()->user()->hasCompletedTopic($topic) && $hasPassedQuiz;
                                    
                                    // First topic is always accessible
                                    if ($index === 0) {
                                        $isAccessible = true;
                                    } 
                                    // Subsequent topics require completing previous ones
                                    else {
                                        $prevTopic = $course->topics->sortBy('id')[$index-1];
                                        $isAccessible = auth()->user()->hasCompletedTopic($prevTopic) && 
                                                    auth()->user()->hasPassedQuiz($prevTopic->id);
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50" data-topic-id="{{ $topic->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($isAccessible)
                                            <a href="{{ route('users.contents.show', encrypt($topic->id)) }}" 
                                            class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                {{ $topic->topic_name }}
                                            </a>
                                        @else
                                            <span class="text-sm font-medium text-gray-400">{{ $topic->topic_name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($isCompleted)
                                            <span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Completed</span>
                                        @elseif($isAccessible)
                                            <span class="px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded">Available</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded">Locked</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($isCompleted)
                                            <a href="{{ route('users.contents.show', encrypt($topic->id)) }}" 
                                            class="text-sm text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded">
                                                Review
                                            </a>
                                        @elseif($isAccessible && $hasQuizzes)
                                            <a href="{{ route('users.quiz.show', [
                                                'encryptedTopic' => encrypt($topic->id),
                                                'encryptedQuiz' => encrypt($topic->quizzes->first()->id)
                                            ]) }}" 
                                            class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                                Take Quiz
                                            </a>
                                        @elseif($isAccessible)
                                            <span class="text-sm text-gray-500">No quiz available</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quiz Submission Modal -->
    <div id="quizResultModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4" id="quizResultTitle"></h3>
            <p class="mb-4" id="quizResultMessage"></p>
            <div class="flex justify-between">
                <button id="quizResultRetry" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 hidden">
                    Retry Quiz
                </button>
                <button id="quizResultClose" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 ml-auto">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <!-- Course Completion Modal -->
    <div id="courseCompletionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold mt-4 mb-2">Congratulations!</h3>
                <p class="mb-4">You have successfully completed the course: <strong>{{ $course->course_name }}</strong></p>
                <div class="flex justify-center space-x-4">
                    @if($progress == 100)
                        <a href="{{ route('users.certificate.print', [
                            'encryptedUser' => Crypt::encrypt(Auth::id()),
                            'encryptedCourse' => $encryptedCourseId
                        ]) }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Certificate
                        </a>
                    @endif
                    <button onclick="document.getElementById('courseCompletionModal').classList.add('hidden')" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if course is completed (progress 100%) and show modal
            const progress = {{ $course->progressForUser(auth()->user()) }};
            if (progress === 100) {
                document.getElementById('courseCompletionModal').classList.remove('hidden');
            }

            // Handle quiz form submission
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
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        const result = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(result.message || 'Submission failed');
                        }
                        
                        // Update UI elements
                        updateProgressUI(result);
                        updateTopicStatusUI(result);
                        
                        // Show appropriate modal
                        showResultModal(result);
                        
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error submitting quiz: ' + error.message);
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                });
            }

            // Update progress bar and percentage
            function updateProgressUI(result) {
                const progressPercent = document.querySelector('.progress-percent');
                const progressBar = document.querySelector('.progress-bar');
                
                if (progressPercent && progressBar) {
                    progressPercent.textContent = `${result.progress}%`;
                    progressBar.style.width = `${result.progress}%`;
                }
                
                // Show completion modal if 100%
                if (result.progress === 100) {
                    document.getElementById('courseCompletionModal').classList.remove('hidden');
                }
            }

            // Update topic status in the table
            function updateTopicStatusUI(result) {
                const currentTopicRow = document.querySelector(`tr[data-topic-id="${result.topic_id}"]`);
                
                if (!currentTopicRow) return;
                
                // Update status cell
                const statusCell = currentTopicRow.querySelector('td:nth-child(3)');
                if (statusCell) {
                    statusCell.innerHTML = result.passed 
                        ? '<span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Completed</span>'
                        : '<span class="px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded">Available</span>';
                }
                

                // Update action button
                const actionCell = currentTopicRow.querySelector('td:nth-child(4)');
                if (actionCell) {
                    actionCell.innerHTML = result.passed
                        ? `<a href="{{ route('users.contents.show', '') }}/${result.topic_id}" 
                            class="text-sm text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded">
                                Review
                           </a>`
                        : `
                            <a href="{{ route('users.contents.show', '') }}/${result.topic_id}" 
                            class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Take Quiz
                           </a>`;
                }
                
                // Unlock next topic if available
                if (result.passed && result.next_topic_available && currentTopicRow.nextElementSibling) {
                    const nextRow = currentTopicRow.nextElementSibling;
                    const nextStatusCell = nextRow.querySelector('td:nth-child(3)');
                    const nextLink = nextRow.querySelector('td:nth-child(2) a');
                    
                    if (nextStatusCell) {
                        nextStatusCell.innerHTML = '<span class="px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded">Available</span>';
                    }
                    
                    if (nextLink) {
                        nextLink.classList.remove('text-gray-400');
                        nextLink.classList.add('text-gray-900', 'hover:text-blue-600');
                    }
                }
            }

            // Show quiz result modal
            function showResultModal(result) {
                const modal = document.getElementById('quizResultModal');
                const title = document.getElementById('quizResultTitle');
                const message = document.getElementById('quizResultMessage');
                const retryBtn = document.getElementById('quizResultRetry');
                const closeBtn = document.getElementById('quizResultClose');
                
                title.textContent = result.passed ? 'Quiz Passed!' : 'Quiz Results';
                message.textContent = result.message;
                
                if (result.passed) {
                    retryBtn.classList.add('hidden');
                    closeBtn.textContent = 'Continue';
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
            }
        });
    </script>
</x-app-layout>