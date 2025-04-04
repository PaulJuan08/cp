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

            <!-- Course Topics List -->
            @if ($course->topics->isEmpty())
                <p class="text-gray-500 mt-4">No topics available for this course.</p>
            @else
                <div class="overflow-x-auto mt-4">
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IMAGE</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOPIC NAME</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $previousCompleted = true; // First topic is always accessible
                                @endphp

                                @foreach ($course->topics as $index => $topic)
                                    @if($topic->status == 1)
                                        @php
                                            // Check if user has completed this topic
                                            $isCompleted = auth()->user()->hasCompletedTopic($topic->id);
                                            $quizPassed = auth()->user()->hasPassedQuiz($topic->id);
                                            $isAccessible = $previousCompleted;
                                            $previousCompleted = $isCompleted && $quizPassed;
                                        @endphp

                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($topic->youtube_thumbnail_url)
                                                    <img src="{{ $topic->youtube_thumbnail_url }}" 
                                                        alt="Video thumbnail" 
                                                        class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                                                @endif
                                            </td>
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
                                                @if($index == 0)
                                                    <span class="px-2 py-1 text-xs font-semibold text-blue-600 rounded">Available</span>
                                                @elseif($isCompleted && $quizPassed)
                                                    <span class="px-2 py-1 text-xs font-semibold text-green-600 rounded">Completed</span>
                                                    @php $previousCompleted = true; @endphp
                                                @elseif(!$isAccessible)
                                                    <span class="px-2 py-1 text-xs font-semibold text-gray-500 rounded">Locked</span>
                                                @else
                                                    <!-- Keeping other statuses neutral -->
                                                    <span class="px-2 py-1 text-xs font-semibold text-gray-700 rounded">
                                                        @if($isAccessible && !$isCompleted)
                                                            In Progress
                                                        @elseif($isCompleted && !$quizPassed)
                                                            Quiz Required
                                                        @endif
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>