<x-app-layout>
@extends('layouts.admindashboard')

<!-- Content --> 
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $quiz->title }}</h1>
            <p class="lead">{{ $quiz->description }}</p>
        </div>
        <div>
            <a href="{{ route('admin.topics.quiz.edit', $topic) }}" class="btn btn-warning">
                <i class="fas fa-cog"></i> Settings
            </a>
            <a href="{{ route('admin.topics.quiz.items.create', $topic) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Question
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $quiz->is_published ? 'success' : 'secondary' }}">
                            {{ $quiz->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </p>
                </div>
                <div class="col-md-4">
                    <p><strong>Total Points:</strong> {{ $quiz->total_points }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Questions:</strong> {{ $quiz->items->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($quiz->items->isEmpty())
        <div class="alert alert-info">
            No questions added yet. <a href="{{ route('admin.topics.quiz.items.create', $topic) }}">Add your first question</a>.
        </div>
    @else
        <div class="quiz-items">
            @foreach($quiz->items as $item)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <span class="badge bg-primary me-2">#{{ $loop->iteration }}</span>
                                {{ $item->question }}
                            </h4>
                        </div>
                        <div>
                            <span class="badge bg-info me-2">{{ $item->type_name }}</span>
                            <span class="badge bg-success">{{ $item->points }} pts</span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        @if($item->isMultipleChoice() || $item->isTrueFalse())
                            <ul class="list-group mb-3">
                                @foreach($item->options as $option)
                                    <li class="list-group-item {{ $option->is_correct ? 'list-group-item-success' : '' }}">
                                        {{ $option->option_text }}
                                        @if($option->is_correct)
                                            <span class="float-end"><i class="fas fa-check"></i></span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-secondary">
                                <strong>Model Answer:</strong>
                                <p>{{ $item->answer->correct_answer ?? 'Not specified' }}</p>
                                @if($item->answer->keywords ?? false)
                                    <p class="mb-0"><small>Keywords: {{ $item->answer->keywords }}</small></p>
                                @endif
                            </div>
                        @endif

                        @if($item->explanation)
                            <div class="alert alert-light">
                                <strong>Explanation:</strong>
                                <p>{{ $item->explanation }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('admin.topics.quiz.items.edit', [$topic, $item]) }}" 
                           class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.topics.quiz.items.destroy', [$topic, $item]) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this question?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

</x-app-layout>