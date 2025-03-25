<x-app-layout>
@extends('layouts.admindashboard')


<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg dark:bg-neutral-800">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Create a Quiz</h2>

    <form action="{{ route('admin.topics.quiz.store') }}" method="POST">
        @csrf
        
        <!-- Quiz Title -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quiz Title</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-neutral-700 dark:text-white" required>
        </div>

        <!-- Quiz Description -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-neutral-700 dark:text-white" required></textarea>
        </div>

        <!-- Questions -->
        <div class="mb-4" id="questions-container">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Questions</label>
            <div class="question-item mt-2">
                <input type="text" name="questions[]" placeholder="Enter a question" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-neutral-700 dark:text-white" required>
            </div>
        </div>

        <button type="button" id="add-question" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Question</button>
        
        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Create Quiz</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-question').addEventListener('click', function() {
        let container = document.getElementById('questions-container');
        let newQuestion = document.createElement('div');
        newQuestion.classList.add('question-item', 'mt-2');
        newQuestion.innerHTML = '<input type="text" name="questions[]" placeholder="Enter a question" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-neutral-700 dark:text-white" required>';
        container.appendChild(newQuestion);
    });
</script>
</x-app-layout>