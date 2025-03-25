<x-app-layout>
@extends('layouts.admindashboard')

<div class="lg:ps-[260px]">
    <div class="min-h-[75rem] p-4 md:p-8">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.courses.index') }}" class="text-red-600 no-underline">&larr; Back to Courses</a>
        </div>

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Course: {{ $course->course_name }}</h2>
        <p class="text-gray-600 dark:text-gray-300">{{ $course->course_desc }}</p>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-red-800 bg-red-100 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Button to open modal -->
        <button type="button" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                onclick="document.getElementById('addTopicModal').classList.remove('hidden')">
            + Add Topic
        </button>

        <!-- Add Topic Modal -->
        <div id="addTopicModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                <div class="p-4 border-b flex justify-between">
                    <h5 class="text-lg font-semibold">Select a Topic to Add</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700"
                            onclick="document.getElementById('addTopicModal').classList.add('hidden')">✕</button>
                </div>
                <div class="p-4">
                    <form action="{{ route('admin.courses.addTopic', $course->id) }}" method="POST">
                        @csrf
                        <label for="topic_id" class="block text-sm font-medium text-gray-700">Select Topic</label>
                        <select name="topic_id" id="topic_id" class="w-full border-gray-300 rounded-lg">
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->topic_name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="mt-4 w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                            Add Topic
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Course Topics List -->
        @if ($course->topics->isEmpty())
            <p class="text-gray-500 mt-4">No topics available for this course.</p>
        @else
            <div class="overflow-x-auto mt-4">
                <table class="w-full border border-gray-200 shadow-md rounded-lg">
                    <thead class="bg-gray-100">
                        <tr class="border-b">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Topic Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->topics as $topic)
                        @if($topic->status == 1)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $topic->id }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.contents.show', $topic->id) }}" class="text-blue-600 hover:underline">
                                    {{ $topic->topic_name }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

</x-app-layout>
