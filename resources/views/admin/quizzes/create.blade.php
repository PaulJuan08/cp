
<x-app-layout>
@extends('layouts.admindashboard')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
            Create Quiz for: {{ $topic->topic_name }}
        </h1>
        <a href="{{ route('admin.topics.index') }}" 
           class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Topic
        </a>
    </div>

    <div class="bg-white rounded-lg shadow dark:bg-neutral-800">
        <form action="{{ route('admin.topics.quiz.store', $topic) }}" method="POST" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">
                    Quiz Title
                </label>
                <input type="text" id="title" name="title" 
                       class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-200" 
                       required>
            </div>

            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">
                    Description
                </label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-200"></textarea>
            </div>

            <div class="flex items-center mb-6">
                <input id="is_published" name="is_published" type="checkbox" 
                       class="w-4 h-4 text-blue-600 border rounded focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600">
                <label for="is_published" class="ml-2 text-sm font-medium text-gray-700 dark:text-neutral-300">
                    Publish immediately
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Create Quiz
                </button>
            </div>
        </form>
    </div>
</div>


<!--  If you want to allow more than 4 options dynamically -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addOptionBtn = document.getElementById('add-option');
    const optionsContainer = document.getElementById('options-container');
    let optionCount = 4; // Starts after D
    
    addOptionBtn.addEventListener('click', function() {
        optionCount++;
        const optionLetter = String.fromCharCode(64 + optionCount);
        
        const optionDiv = document.createElement('div');
        optionDiv.className = 'option-group';
        optionDiv.innerHTML = `
            <label>Option ${optionLetter}</label>
            <input type="text" name="options[${optionLetter}][text]" required>
        `;
        
        optionsContainer.appendChild(optionDiv);
        
        // Add to correct answer dropdown
        const select = document.querySelector('select[name="correct_answer"]');
        const newOption = document.createElement('option');
        newOption.value = optionLetter;
        newOption.textContent = `Option ${optionLetter}`;
        select.appendChild(newOption);
    });
});
</script>

</x-app-layout>