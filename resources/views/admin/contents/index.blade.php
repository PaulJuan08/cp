<x-app-layout>
    @extends('layouts.admindashboard')

    <!-- Content -->
    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="#" onclick="window.history.back(); return false;" class="text-red-600 no-underline hover:text-red-800 transition">
                    &larr; Back 
                </a>
            </div>

            <div id="scrollspy" class="space-y-10 md:space-y-16">

                @isset($topic)
                    <!-- Display details of a single topic -->
                    <div id="topics" class="min-h-[25rem] scroll-mt-24">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Topic Content</h2>

                        <div class="bg-white border shadow-sm rounded-xl p-4 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-col md:flex-row gap-4">
                                <!-- Left side - Content -->
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800 dark:text-white">{{ $topic->topic_name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topic->topic_desc }}</p>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">{!! $topic->content !!}</p>
                                    </div>
                                </div>

                                
                                <!-- Right side - Video or Thumbnail -->
                                <div class="w-full md:w-1/3">
                                    @if($topic->video_url)
                                        @if($topic->youtube_embed_url)
                                            <div class="embed-responsive embed-responsive-16by9 mb-3">
                                                <iframe class="embed-responsive-item" 
                                                        src="{{ $topic->youtube_embed_url }}" 
                                                        allowfullscreen></iframe>
                                            </div>
                                        @else
                                            <div class="relative rounded-lg overflow-hidden" style="height: 180px;">
                                                <!-- YouTube thumbnail as background -->
                                                <a href="{{ $topic->video_url }}" 
                                                    target="_blank" 
                                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                        Watch on YouTube
                                                        @if($topic->youtube_thumbnail_url)
                                                            <img src="{{ $topic->youtube_thumbnail_url }}" 
                                                                alt="Video thumbnail" 
                                                                class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                                        @endif
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                <p>Created at: {{ $topic->created_at }}</p>
                                <p>Updated at: {{ $topic->updated_at }}</p>
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
                                <a href="{{ route('admin.contents.index', ['id' => $topic->id]) }}" class="text-blue-500 mt-4 block">View Details</a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>


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
