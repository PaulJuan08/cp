<x-app-layout>
@extends('layouts.admindashboard')


<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quiz Settings: {{ $topic->topic_name }}</h1>
        <a href="{{ route('admin.topics.quiz.show', $topic) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.topics.quiz.update', $topic) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Quiz Title</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="{{ old('title', $quiz->title ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="3">{{ old('description', $quiz->description ?? '') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="time_limit" class="form-label">Time Limit (minutes)</label>
                            <input type="number" class="form-control" id="time_limit" name="time_limit" 
                                   value="{{ old('time_limit', $quiz->time_limit ?? '') }}" min="1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_published" 
                                       name="is_published" value="1" 
                                       {{ old('is_published', $quiz->is_published ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Published
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </div>
        </div>
    </form>
</div>
</x-app-layout>