<x-app-layout>
    @extends('layouts.admindashboard')

    <!-- Content -->
    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8 bg-gray-50 dark:bg-gray-900">
            <div id="scrollspy" class="space-y-10 md:space-y-16">
                <div id="topics" class="min-h-[25rem] scroll-mt-24">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Topics</h2>
                        
                        <!-- Add Topic Button -->
                        <button type="button" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm flex items-center gap-2" 
                            data-hs-overlay="#addTopicModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Topic
                        </button>
                    </div>

                    <!-- Search input for topics -->
                    <div class="mb-6 mt-2 w-full">
                        <div class="relative">
                            <input type="text" id="topic-search" 
                                class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                                placeholder="Search topics by name...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Add Topic Modal - Fixed Version -->
                    <div id="addTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-4xl dark:bg-gray-800 transition-transform duration-300 ease-out transform">
                            <div class="flex justify-between items-center mb-6">
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white">Create New Topic</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#addTopicModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="max-h-[80vh] overflow-y-auto">
                                <!-- SINGLE FORM - Keep only this one form -->
                                <form action="{{ route('admin.topics.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="topic_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                            <input type="text" id="topic_name" name="topic_name" required
                                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        </div>
                                        <div>
                                            <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube Video URL</label>
                                            <input type="url" id="video_url" name="video_url" 
                                                placeholder="https://www.youtube.com/watch?v=..."
                                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="topic_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <textarea id="topic_desc" name="topic_desc" rows="3" required
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600"></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                                        <textarea id="editor" name="content" rows="10"
                                            class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white dark:border-gray-600">{{ old('content') }}</textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="audio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Audio File (MP3, WAV, M4A)</label>
                                        <input type="file" id="audio" name="audio" accept=".mp3, .wav, .m4a"
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                    </div>
                                    
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                            data-hs-overlay="#addTopicModal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-sm">
                                            Create Topic
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- View Topic Modal -->
                    <div id="viewTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md dark:bg-gray-800 transition-transform duration-300 ease-out transform">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle"></h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#viewTopicModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400" id="modalDescription"></p>
                                <div class="mt-4">
                                    <p class="text-gray-700 dark:text-gray-300" id="modalContent"></p>
                                </div>
                                <div class="mt-4">
                                    <audio controls id="modalAudio">
                                        <source src="" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                                <div class="mt-4">
                                    <iframe width="100%" height="315" id="modalVideo" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>

                                <form action="{{ route('admin.topics.store') }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="topic_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                            <input type="text" id="topic_name" name="topic_name" required
                                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        </div>
                                        <div>
                                            <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube Video URL</label>
                                            <input type="url" name="video_url" 
                                                placeholder="https://www.youtube.com/watch?v=..."
                                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="topic_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <textarea id="topic_desc" name="topic_desc" rows="3" required
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600"></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                                        <div id="editor" class="ckeditor-classic"></div>
                                        <textarea id="content" name="content" class="hidden">{{ old('content') }}</textarea>
                                    </div>
                                    
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                            data-hs-overlay="#addTopicModal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                            Create Topic
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Display Topics -->
                    @if ($topics->isEmpty())
                        <div class="flex flex-col items-center justify-center p-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="text-gray-500 text-lg">No topics available.</p>
                            <p class="text-gray-400 text-sm mt-2">Create your first topic to get started.</p>
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($topics as $topic)
                                <!-- Topic Card -->
                                <div class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-gray-800 dark:border-gray-700 overflow-hidden h-full">
                                    <div class="p-5 flex flex-col flex-grow">
                                        <a href="{{ route('admin.contents.show', encrypt($topic->id)) }}" class="no-underline group-hover:text-blue-600 transition-colors">
                                            @if($topic->youtube_thumbnail_url)
                                                <div class="mb-3 rounded-lg overflow-hidden">
                                                    <img src="{{ $topic->youtube_thumbnail_url }}" 
                                                        alt="Video thumbnail" 
                                                        class="w-full h-auto object-cover transition-transform group-hover:scale-105 duration-300">
                                                </div>
                                            @endif
                                            <h3 class="font-bold text-gray-800 text-lg mb-2 dark:text-white group-hover:text-blue-600 transition-colors">
                                                {{ $topic->topic_name }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                                {{ $topic->topic_desc }}
                                            </p>
                                        </a>
                                    </div>
                                    <!-- Dropdown for Actions -->
                                    <div class="px-5 py-3 bg-gray-50 dark:bg-gray-700/50">
                                        <div class="hs-dropdown relative w-full">
                                            <button id="hs-dropdown-with-icons" type="button" class="hs-dropdown-toggle w-full justify-between py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800/80 dark:focus:ring-gray-700" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                                <span>Actions</span>
                                                <svg class="hs-dropdown-open:rotate-180 size-4 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                            </button>

                                            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2 mt-2 divide-y divide-gray-200 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-with-icons">
                                                <div class="py-1 space-y-1">
                                                    <!-- Create Quiz Button -->
                                                    <a href="{{ route('admin.topics.quiz.index', encrypt($topic->id)) }}" class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                        Quiz
                                                    </a>
                                                </div>
                                                <div class="py-1 space-y-1">
                                                    <!-- Edit Action -->
                                                    <button type="button" 
                                                        class="edit-btn w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                                                        data-id="{{ encrypt($topic->id) }}" 
                                                        data-name="{{ $topic->topic_name }}" 
                                                        data-desc="{{ $topic->topic_desc }}" 
                                                        data-content="{{ $topic->content }}" 
                                                        data-video="{{ $topic->video_url }}"
                                                        data-hs-overlay="#editTopicModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </button>

                                                    <!-- Delete Action -->
                                                    <form action="{{ route('admin.topics.destroy', encrypt($topic->id)) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-100 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                    <!-- Edit Topic Modal -->
                    <div id="editTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-4xl dark:bg-gray-800 transition-transform duration-300 ease-out transform">
                            <div class="flex justify-between items-center mb-6">
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white">Edit Topic</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#editTopicModal" id="closeEditModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="max-h-[80vh] overflow-y-auto">
                                <form id="editTopicForm" method="POST" action="">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="edit_topic_id" name="topic_id">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="edit_topic_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic Name</label>
                                            <input type="text" id="edit_topic_name" name="topic_name" required
                                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        </div>
                                        <div>
                                            <label for="edit_video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube Video URL</label>
                                            <input type="url" id="edit_video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=..."
                                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="edit_topic_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic Description</label>
                                        <textarea id="edit_topic_desc" name="topic_desc" rows="3" required
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600"></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                                        <div id="edit_editor" class="ckeditor-classic"></div>
                                        <textarea id="edit_content" name="content" class="hidden"></textarea>
                                    </div>
                                    
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                            data-hs-overlay="#editTopicModal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-sm">
                                            Update Topic
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor 5 for add form
        let addEditor;
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // CKEditor 5 configuration
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'alignment', '|',
                        'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        'undo', 'redo', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                language: 'en',
                licenseKey: '',
            })
            .then(editor => {
                addEditor = editor;
                // Update the hidden textarea when editor content changes
                editor.model.document.on('change:data', () => {
                    document.getElementById('content').value = editor.getData();
                });
                
                // Also update on form submission as a fallback
                document.querySelector('#addTopicModal form').addEventListener('submit', function(e) {
                    document.getElementById('content').value = editor.getData();
                    return true;
                });
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // Edit Topic Modal Handling
        let editEditor;

        // Handle edit button clicks
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Destroy previous editor instance if exists
                if (editEditor) {
                    editEditor.destroy().catch(error => {
                        console.error('Error destroying editor:', error);
                    });
                }
                
                // Get topic data from data attributes
                const topicId = this.getAttribute('data-id');
                const topicName = this.getAttribute('data-name');
                const topicDesc = this.getAttribute('data-desc');
                const content = this.getAttribute('data-content');
                const videoUrl = this.getAttribute('data-video');
                
                // Set form action URL with the correct topic ID
                document.getElementById('editTopicForm').action = `/admin/topics/${topicId}`;
                
                // Set form values
                document.getElementById('edit_topic_id').value = topicId;
                document.getElementById('edit_topic_name').value = topicName;
                document.getElementById('edit_topic_desc').value = topicDesc;
                document.getElementById('edit_video_url').value = videoUrl;
                
                // Initialize CKEditor 5 for the edit form
                ClassicEditor
                    .create(document.querySelector('#edit_editor'), {
                        // CKEditor 5 configuration
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                                'bulletedList', 'numberedList', '|',
                                'outdent', 'indent', '|',
                                'alignment', '|',
                                'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                                'undo', 'redo', '|',
                                'sourceEditing'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        language: 'en',
                        licenseKey: '',
                    })
                    .then(editor => {
                        editEditor = editor;
                        // Set the content in CKEditor
                        editor.setData(content);
                        
                        // Update the hidden textarea when editor content changes
                        editor.model.document.on('change:data', () => {
                            document.getElementById('edit_content').value = editor.getData();
                        });
                        
                        // Also update on form submission as a fallback
                        document.getElementById('editTopicForm').addEventListener('submit', function(e) {
                            document.getElementById('edit_content').value = editor.getData();
                            return true;
                        });
                    })
                    .catch(error => {
                        console.error('Error initializing CKEditor:', error);
                    });
            });
        });
        
        // Clean up when modal is closed
        document.getElementById('closeEditModal').addEventListener('click', function() {
            if (editEditor) {
                editEditor.destroy().catch(error => {
                    console.error('Error destroying editor:', error);
                });
                editEditor = null;
            }
            // Reset form
            document.getElementById('editTopicForm').reset();
            document.getElementById('editTopicForm').action = '';
        });

        // Topic search functionality
        function initTopicSearch() {
            const searchInput = document.getElementById('topic-search');
            if (!searchInput) return;

            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase().trim();
                const topicCards = document.querySelectorAll('.grid > div.group'); // Select all topic cards
                
                // If search is empty, show all topics
                if (searchValue === '') {
                    topicCards.forEach(card => {
                        card.style.display = 'flex';
                    });
                    return;
                }
                
                let hasResults = false;
                
                topicCards.forEach(card => {
                    const topicName = card.querySelector('h3').textContent.toLowerCase().trim();
                    const topicDesc = card.querySelector('p').textContent.toLowerCase().trim();
                    
                    // Check if search value matches topic name or description
                    if (topicName.includes(searchValue) || topicDesc.includes(searchValue)) {
                        card.style.display = 'flex';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Handle no results scenario
                const noTopicsElement = document.querySelector('.flex.flex-col.items-center.justify-center.p-8');
                const noResultsElement = document.getElementById('no-search-results');
                
                if (!hasResults && topicCards.length > 0) {
                    // If no results are found, display the "No results" message
                    if (!noResultsElement) {
                        const noResultsDiv = document.createElement('div');
                        noResultsDiv.id = 'no-search-results';
                        noResultsDiv.className = 'flex flex-col items-center justify-center p-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mt-4';
                        noResultsDiv.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-gray-500 text-lg">No topics match your search criteria.</p>
                            <p class="text-gray-400 text-sm mt-2">Try a different search term or clear the search.</p>
                        `;
                        
                        // Insert after the grid
                        const topicsGrid = document.querySelector('.grid');
                        if (topicsGrid) {
                            topicsGrid.parentNode.insertBefore(noResultsDiv, topicsGrid.nextSibling);
                        }
                    }
                    
                    // Hide the grid when no results
                    document.querySelector('.grid').style.display = 'none';
                    
                    // Also hide the "No topics available" message if it exists
                    if (noTopicsElement) {
                        noTopicsElement.style.display = 'none';
                    }
                } else {
                    // Show the grid when there are results
                    document.querySelector('.grid').style.display = 'grid';
                    
                    // Remove the "No results" message if it exists
                    if (noResultsElement) {
                        noResultsElement.remove();
                    }
                }
            });
        }

        // Initialize search when the DOM is loaded
        initTopicSearch();

        // Toast notification function - consistent with courses page
        function showToast(title, message, type = 'info') {
            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
                document.body.appendChild(toastContainer);
            }
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `flex items-center p-4 mb-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full max-w-xs ${
                type === 'success' ? 'bg-green-50 text-green-800 border-l-4 border-green-500 dark:bg-green-900/40 dark:text-green-300' :
                type === 'error' ? 'bg-red-50 text-red-800 border-l-4 border-red-500 dark:bg-red-900/40 dark:text-red-300' :
                'bg-blue-50 text-blue-800 border-l-4 border-blue-500 dark:bg-blue-900/40 dark:text-blue-300'
            }`;
            
            // Icon based on type
            const iconSvg = type === 'success' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>' :
                type === 'error' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>' :
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            
            toast.innerHTML = `
                ${iconSvg}
                <div>
                    <p class="font-bold">${title}</p>
                    <p class="text-sm">${message}</p>
                </div>
                <button class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            // Add toast to container
            toastContainer.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 10);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
        }
    });
</script>
</x-app-layout>