<x-app-layout>
@extends('layouts.admindashboard')

@section('content')
<div class="lg:ps-[260px]">
<div class="container mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
            Create Quiz for Topic: {{ $topic->topic_name }}
        </h1>

        <form action="{{ route('admin.topics.quiz.store', $topic) }}" method="POST">
            @csrf

            <!-- Quiz Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Quiz Title
                </label>
                <input type="text" name="title" id="title" 
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none 
                    dark:bg-gray-700 dark:text-white dark:border-gray-600" 
                    required>
            </div>

            <!-- Quiz Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Quiz Description (Optional)
                </label>
                <textarea name="description" id="description" 
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none 
                    dark:bg-gray-700 dark:text-white dark:border-gray-600" 
                    rows="3"></textarea>
            </div>

            <!-- Buttons -->
            <div class="buttons-container mt-4 flex justify-between items-center">
                <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600">
                    Create
                </button>
            </div>
        </form>

        <!-- Display Created Quizzes -->
        <h2 class="text-xl font-semibold mt-8 text-gray-800 dark:text-white">Created Quizzes</h2>

        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-800 dark:text-white">Title</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-800 dark:text-white">Description</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-800 dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topic->quizzes as $quiz)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-white">
                                {{ $quiz->title }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-white">
                                {{ $quiz->description ?? 'No description' }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                <a href="{{ route('admin.topics.quiz.edit', [$topic, $quiz]) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                    Edit
                                </a>
                                |
                                <form action="{{ route('admin.topics.quiz.destroy', [$topic, $quiz]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline dark:text-red-400" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                No quizzes created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>
</x-app-layout>
