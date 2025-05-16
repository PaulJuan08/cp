<x-app-layout>
@extends('layouts.admindashboard')

@section('content')
<div class="lg:ps-[260px]">
<div class="container mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
            Edit Quiz for Topic: {{ $topic->topic_name }}
        </h1>

        <form action="{{ route('admin.topics.quiz.update', ['topic' => encrypt($topic->id), 'quiz' => encrypt($quiz->id)]) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Quiz Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Quiz Title
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}"
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
                    rows="3">{{ old('description', $quiz->description) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="buttons-container mt-4 flex justify-between items-center">
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600">
                    Update
                </button>
                <a href="{{ route('admin.topics.show', encrypt($topic->id)) }}" 
                    class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</x-app-layout>