<x-app-layout>
@extends('layouts.admindashboard')


<div class="lg:ps-[100px]">
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
            
            <!-- Quiz Title -->
            <h1 class="text-2xl font-bold text-gray-800">Topic:<span class="font-semibold">{{ $topic->topic_name }}</span></h1>
            
            <div class="mt-4">
                <h2 class="text-xl font-semibold text-gray-700">Title:</h2>
                <p class="text-gray-800 border p-2 rounded">{{ $quiz->title }}</p>
            </div>

            <div class="mt-4">
                <h2 class="text-xl font-semibold text-gray-700">Description:</h2>
                <p class="text-gray-800 border p-2 rounded">{{ $quiz->description }}</p>
            </div>

            <!-- Quiz Questions -->
            <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow-inner">
                <h2 class="text-lg font-semibold text-gray-700">Questions:</h2>

                @foreach($quiz->questions as $index => $question)
                    <div class="mt-4 border border-green-500 p-4 rounded">
                        <p class="text-gray-800 font-semibold">{{ $index + 1 }}. {{ $question->question_text }}</p>
                        <p class="text-gray-600 mt-2">Correct answer:</p>
                        <input type="text" value="{{ $question->correct_answer }}" class="w-full p-2 border rounded-md">
                    </div>
                @endforeach
            </div>

            <!-- Buttons -->
            <div class="flex justify-end mt-6 gap-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Item
                </button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Publish
                </button>
            </div>

        </div>
    </div>
</div>

</x-app-layout>
