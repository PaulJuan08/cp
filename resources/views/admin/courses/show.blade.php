<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.courses.index') }}" class="flex items-center text-red-600 no-underline hover:text-red-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Courses
                </a>
            </div>

            <!-- Course Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Course: {{ $course->course_name }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $course->course_desc }}</p>
                </div>
                <button type="button" 
                        class="flex items-center px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition"
                        onclick="document.getElementById('addTopicModal').classList.remove('hidden')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Topic
                </button>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="p-4 mb-6 text-green-800 bg-green-100 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-red-800 bg-red-100 rounded-lg border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add Topic Modal -->
            <div id="addTopicModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                    <div class="p-4 border-b flex justify-between items-center">
                        <h5 class="text-lg font-semibold">Add Topic to Course</h5>
                        <button type="button" class="text-gray-500 hover:text-gray-700 transition"
                                onclick="document.getElementById('addTopicModal').classList.add('hidden')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.courses.addTopic', encrypt($course->id)) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="topic_id" class="block text-sm font-medium text-gray-700 mb-2">Select Topic</label>
                                <select name="topic_id" id="topic_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->topic_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" 
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                                        onclick="document.getElementById('addTopicModal').classList.add('hidden')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Add Topic
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Course Topics List -->
            @if ($course->topics->isEmpty())
                <div class="bg-white border border-gray-200 rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No topics available</h3>
                    <p class="mt-1 text-gray-500">Add topics to this course to get started.</p>
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topic Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($course->topics as $topic)
                                @if($topic->status == 1)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($topic->youtube_thumbnail_url)
                                            <img src="{{ $topic->youtube_thumbnail_url }}" 
                                                alt="Video thumbnail" 
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $topic->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.contents.show', encrypt($topic->id)) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:no-underline">
                                            {{ $topic->topic_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <!-- Remove Button -->
                                            <form action="{{ route('admin.courses.removeTopic', ['encryptedCourse' => $course->id, 'encryptedTopic' => $topic->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 transition"
                                                        title="Remove from this course"
                                                        onclick="return confirm('Are you sure you want to remove this topic from this course?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
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