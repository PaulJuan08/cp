<x-app-layout>
    @extends('layouts.admindashboard')

    <!-- Content -->
    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <div id="scrollspy" class="space-y-10 md:space-y-16">

                @isset($topic)
                    <!-- Display details of a single topic -->
                    <div id="topics" class="min-h-[25rem] scroll-mt-24">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Topic Details</h2>

                        <div class="bg-white border shadow-sm rounded-xl p-4 dark:bg-gray-900 dark:border-gray-800">
                            <h3 class="font-semibold text-gray-800 dark:text-white">{{ $topic->topic_name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topic->topic_desc }}</p>
                            <div class="mt-4">
                                <p class="text-gray-700 dark:text-gray-300">{{ $topic->content }}</p>
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
</x-app-layout>
