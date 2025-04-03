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
                                <a href="{{ route('users.contents.show', $topic->id) }}" class="text-blue-600 hover:underline">
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
