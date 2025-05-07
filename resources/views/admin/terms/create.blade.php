@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add Terms and Conditions</h1>

    <form action="{{ route('admin.terms.store', $terms->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <textarea id="editor" name="content" class="w-full rounded border-gray-300 min-h-[400px]">
                {{ old('content', $terms->content) }}
            </textarea>
        </div>
        
        <div class="flex items-center space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Changes
            </button>
            <a href="{{ route('admin.terms.index') }}" class="text-gray-600 hover:text-gray-800">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@endpush
@endsection