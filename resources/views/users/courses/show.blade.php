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
                    <span class="text-sm font-medium text-gray-700">{{ $course->progressForUser(auth()->user()) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" 
                        style="width: {{ $course->progressForUser(auth()->user()) }}%"></div>
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
                                @foreach ($course->topics->sortBy('sequence_order') as $index => $topic)
                                @php
                                    $isCompleted = auth()->user()->hasCompletedTopic($topic) && 
                                                auth()->user()->hasPassedQuiz($topic->id);
                                    $isAccessible = $index == 0 || 
                                                (auth()->user()->hasCompletedTopic($course->topics[$index-1]) && 
                                                auth()->user()->hasPassedQuiz($course->topics[$index-1]->id));
                                @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isAccessible)
                                                <a href="{{ route('users.contents.show', $topic->id) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                    {{ $topic->topic_name }}
                                                </a>
                                            @else
                                                <span class="text-sm font-medium text-gray-400">{{ $topic->topic_name }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isCompleted)
                                                <span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Completed</span>
                                                @php $isCompleted = true; @endphp
                                            @elseif($isAccessible)
                                                <span class="px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded">Available</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded">Locked</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isAccessible && $topic->quizzes->isNotEmpty())
                                                @if(!$isCompleted || !$quizPassed)
                                                    <a href="{{ route('users.quiz.show', [$topic, $topic->quizzes->first()]) }}" 
                                                       class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                                        {{ $isCompleted ? 'Retake Quiz' : 'Take Quiz' }}
                                                    </a>
                                                @endif
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
                        } else {
                            retryBtn.classList.remove('hidden');
                            closeBtn.textContent = 'Review Material';
                        }
                        
                        modal.classList.remove('hidden');
                        
                        retryBtn.onclick = function() {
                            modal.classList.add('hidden');
                            window.location.href = this.querySelector('a').href;
                        };
                        
                        closeBtn.onclick = function() {
                            modal.classList.add('hidden');
                            if (result.passed && result.next_topic_available) {
                                window.location.href = result.next_topic_url;
                            } else if (result.passed) {
                                window.location.reload();
                            }
                        };
                        
                    } catch (error) {
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