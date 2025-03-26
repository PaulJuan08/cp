<x-app-layout>

@extends('layouts.admin')


<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quizzes for: {{ $topic->topic_name }}</h1>
        <a href="{{ route('admin.topics.quizzes.create', $topic) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Quiz
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($quizzes->isEmpty())
        <div class="alert alert-info">
            No quizzes found for this topic.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th>Correct Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->id }}</td>
                        <td>{{ Str::limit($quiz->question, 50) }}</td>
                        <td>
                            @foreach($quiz->options as $option)
                                <span class="badge bg-light text-dark">
                                    {{ $option->option_label }}: {{ Str::limit($option->option_text, 15) }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge bg-success">
                                {{ $quiz->correct_answer }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.topics.quizzes.show', [$topic, $quiz]) }}" 
                               class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.topics.quizzes.edit', [$topic, $quiz]) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.topics.quizzes.destroy', [$topic, $quiz]) }}" 
                                  method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $quizzes->links() }} <!-- Pagination -->
    @endif
    
    <a href="{{ route('admin.topics.index') }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Back to Topics
    </a>
</div>
</x-app-layout>