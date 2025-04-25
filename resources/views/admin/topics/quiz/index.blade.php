<x-app-layout>
    @extends('layouts.admindashboard')
    <div class="lg:ps-[260px]">
    <div class="container mx-auto p-6">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="#" onclick="window.history.back(); return false;" class="text-red-600 no-underline hover:text-red-800 transition">
                    &larr; Back to Topics
                </a>
            </div>

        <h2 class="text-2xl font-bold mb-4">Quizzes for Topic: {{ $topic->topic_name }}</h2>

        <!-- Button to create a new quiz - Fixed route parameter -->
        <a href="{{ route('admin.topics.quiz.create', ['encryptedTopic' => encrypt($topic->id)]) }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block">Create New Quiz</a>

        @if ($quizzes->count() > 0)
            <div class="overflow-x-auto bg-white p-4 rounded-lg shadow-lg">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">Quiz Title</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $quiz->title }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <!-- View button - Fixed route parameters -->
                                <a href="{{ route('admin.topics.quiz.show', ['encryptedTopic' => encrypt($topic->id), 'encryptedQuiz' => encrypt($quiz->id)]) }}" 
                                   class="bg-green-500 text-white px-3 py-1 rounded">View</a>
                                <!-- Edit button - Fixed route parameters -->
                                <a href="{{ route('admin.topics.quiz.edit', ['encryptedTopic' => encrypt($topic->id), 'encryptedQuiz' => encrypt($quiz->id)]) }}" 
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                                <!-- Delete form - Fixed route parameters -->
                                <form action="{{ route('admin.topics.quiz.destroy', ['encryptedTopic' => encrypt($topic->id), 'encryptedQuiz' => encrypt($quiz->id)]) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded" 
                                            onclick="return confirm('Are you sure you want to delete this quiz?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600 mt-4">No quizzes found for this topic.</p>
        @endif
    </div>
    </div>
</x-app-layout>