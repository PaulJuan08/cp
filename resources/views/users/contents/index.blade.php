<x-app-layout>
    @extends('layouts.usersdashboard')

    <!-- Content -->
    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="#" onclick="window.history.back(); return false;" class="text-red-600 no-underline hover:text-red-800 transition">
                    &larr; Back to Topics
                </a>
            </div>

            <div id="scrollspy" class="space-y-10 md:space-y-16">

                @isset($topic)
                    <!-- Display details of a single topic -->
                    <div id="topics" class="min-h-[25rem] scroll-mt-24">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Topic Content</h2>

                        <div class="bg-white border shadow-sm rounded-xl p-4 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Left side - Content -->
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800 dark:text-white">{{ $topic->topic_name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topic->topic_desc }}</p>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">{!! $topic->content !!}</p>
                                    </div>

                                    <div class="mt-6">
                                        <!-- Toggle Button -->
                                        <button id="toggleQuizButton" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none">
                                            Done
                                        </button>

                                        <!-- Quiz Container -->
                                        <div id="quizContainer" class="hidden mt-4">
                                            @if($topic->quizzes && $topic->quizzes->count())
                                                @foreach($topic->quizzes as $quiz)
                                                    <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                                        <h5 class="font-medium">{{ $quiz->title }}</h5>
                                                        <p class="text-sm">{{ $quiz->description }}</p>
                                                        <a href="{{ route('users.quiz.show', ['topic' => $topic->id, 'quiz' => $quiz->id]) }}" 
                                                        class="text-blue-500 text-sm mt-1 inline-block">
                                                            Take Quiz
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-sm text-gray-500">No quizzes available for this topic.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Right side - Video -->
                                <div class="w-full md:w-1/3">
                                    @if($topic->video_url)
                                        <div class="sticky top-4"> <!-- Makes video stay visible when scrolling -->
                                            <div class="embed-responsive embed-responsive-16by9 mb-3 rounded-lg overflow-hidden">
                                                <iframe class="embed-responsive-item" 
                                                        src="{{ $topic->youtube_embed_url }}" 
                                                        allowfullscreen></iframe>
                                            </div>
                                            @if(!$topic->youtube_embed_url)
                                                <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-800 text-center">
                                                    <p class="text-gray-500 dark:text-gray-400 mb-2">Video unavailable</p>
                                                    <a href="{{ $topic->video_url }}" 
                                                       target="_blank" 
                                                       class="text-blue-600 dark:text-blue-400 hover:underline">
                                                        Watch on YouTube
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif(isset($topics))
                    <!-- Display list of topics -->
                    <div id="topics" class="min-h-[25rem] scroll-mt-24">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">All Topics</h2>

                        @foreach($topics as $topic)
                            <div class="bg-white border shadow-sm rounded-xl p-4 dark:bg-gray-900 dark:border-gray-800 mb-4">
                                <h3 class="font-semibold text-gray-800 dark:text-white">{{ $topic->topic_name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topic->topic_desc }}</p>
                                <a href="{{ route('users.contents.index', ['id' => $topic->id]) }}" class="text-blue-500 mt-4 block">View Details</a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        // Toggle the visibility of the quiz container when the button is clicked
        document.getElementById('toggleQuizButton').addEventListener('click', function(){
            const container = document.getElementById('quizContainer');
            container.classList.toggle('hidden');
        });
    </script>

    <style>
        .embed-responsive {
            position: relative;
            display: block;
            width: 100%;
            padding: 0;
            overflow: hidden;
        }

        .embed-responsive-16by9::before {
            display: block;
            content: "";
            padding-top: 56.25%;
        }

        .embed-responsive-item {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</x-app-layout>