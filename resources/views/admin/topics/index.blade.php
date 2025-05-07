<x-app-layout>
    @extends('layouts.admindashboard')

    <!-- Content -->
    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <div id="scrollspy" class="space-y-10 md:space-y-16">
                <div id="topics" class="min-h-[25rem] scroll-mt-24">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Topics</h2>

                    <!-- Add Topic Button -->
                    <div class="mb-4">
                        <button type="button" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" 
                            data-hs-overlay="#addTopicModal">
                            + Add Topic
                        </button>
                    </div>

                    <!-- Add Topic Modal - Wider Version -->
                    <div id="addTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Topic</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#addTopicModal">
                                    ✕
                                </button>
                            </div>
                            <div class="max-h-[80vh] overflow-y-auto">
<<<<<<< Updated upstream
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
                                        <textarea id="editor" name="content" rows="10"
                                            class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white dark:border-gray-600">{{ old('content') }}</textarea>
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
=======
                            <form action="{{ route('admin.topics.store') }}" method="POST" >
                                @csrf
                                <div class="mb-3">
                                    <label for="topic_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic Name</label>
                                    <input type="text" id="topic_name" name="topic_name" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="mb-3">
                                    <label for="topic_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic Description</label>
                                    <textarea id="topic_desc" name="topic_desc" rows="3" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                                    <div class="mb-3">
                                    <textarea id="content" name="content" rows="3" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                    </textarea>
                                </div>

                                </div>
                                <div class="mb-3">
                                    <label for="audio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Audio File (MP3, WAV, M4A)</label>
                                    <input type="file" id="audio" name="audio" accept=".mp3, .wav, .m4a"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="mb-3">
                                    <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube Video URL</label>
                                    <input type="url" id="video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=..."
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Topic</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- View Topic Modal -->
                    <div id="viewTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitle"></h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#viewTopicModal">
                                    ✕
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
>>>>>>> Stashed changes
                            </div>
                        </div>
                    </div>

                    <!-- Display Topics -->
                    @if ($topics->isEmpty())
                        <p class="text-gray-500">No topics available.</p>
                    @else
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($topics as $topic)
                                <!-- Topic Card -->
                                <div class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-gray-900 dark:border-gray-800 p-4">
                                    <a href="{{ route('admin.contents.show', encrypt($topic->id)) }}" class="no-underline text-blue-500 hover:no-underline">
                                    @if($topic->youtube_thumbnail_url)
                                        <img src="{{ $topic->youtube_thumbnail_url }}" 
                                            alt="Video thumbnail" 
                                            class="img-thumbnail w-60 h-auto max-h-25 object-cover">
                                    @endif
                                        <h3 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $topic->topic_name }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $topic->topic_desc }}
                                        </p>
                                    </a>

                                    <!-- Dropdown for Actions -->
                                    <div class="mt-4 flex justify-end">
                                        <div class="hs-dropdown relative inline-flex">
                                            <button id="hs-dropdown-with-icons" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                                Actions
                                                <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                            </button>

                                            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 divide-y divide-gray-200 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-with-icons">
                                                <div class="p-1 space-y-0.5">
                                                    <!-- Create Quiz Button -->
                                                    <a href="{{ route('admin.topics.quiz.index', encrypt($topic->id)) }}" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700">
                                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M12 5v14M5 12h14"/>
                                                        </svg>
                                                        Quiz
                                                    </a>

                                                    <!-- Edit Action -->
                                                    <a href="#" class="edit-btn flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700"
                                                        data-id="{{ encrypt($topic->id) }}" 
                                                        data-name="{{ $topic->topic_name }}" 
                                                        data-desc="{{ $topic->topic_desc }}" 
                                                        data-content="{{ $topic->content }}" 
                                                        data-video="{{ $topic->video_url }}"
                                                        data-hs-overlay="#editTopicModal">
                                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                                        </svg>
                                                        Edit
                                                    </a>

                                                    <!-- Delete Action -->
                                                    <form action="{{ route('admin.topics.destroy', encrypt($topic->id)) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700">
                                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M3 6h18"/>
                                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
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
<<<<<<< Updated upstream

                    <!-- Edit Topic Modal -->
                    <div id="editTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Topic</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#editTopicModal" id="closeEditModal">
                                    ✕
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
                                        <textarea id="edit_content" name="content" class="hidden"></textarea>
                                        <div id="editor-holder" class="border rounded-lg overflow-hidden dark:border-gray-600 min-h-[300px]"></div>
                                    </div>
                                    
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                            data-hs-overlay="#editTopicModal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                            Update Topic
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
=======
>>>>>>> Stashed changes
                </div>
            </div>
        </div>
    </div>

<<<<<<< Updated upstream
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
=======
<<<<<<< HEAD
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
>>>>>>> parent of c90dbe7 (done major functionalities)
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('content');
<<<<<<< HEAD
=======
=======
>>>>>>> Stashed changes
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
>>>>>>> Stashed changes
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CKEditor for add form
            CKEDITOR.replace('editor', {
                height: 400,
                toolbar: [
                    { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] }
                ],
                contentsCss: [
                    'body { font-family: "Inter", sans-serif; font-size: 14px; }',
                    'body.dark { background: #1e293b; color: white; }'
                ]
            });

            // Edit Topic Modal Handling
            let editEditor = null;

            // Handle edit button clicks
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Destroy previous editor instance if exists
                    if (editEditor) {
                        editEditor.destroy();
                        editEditor = null;
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
                    
                    // Initialize CKEditor for the edit form
                    editEditor = CKEDITOR.replace('editor-holder', {
                        height: 400,
                        toolbar: [
                            { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                            { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                            { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                            { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                            '/',
                            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                            { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] }
                        ],
                        contentsCss: [
                            'body { font-family: "Inter", sans-serif; font-size: 14px; }',
                            'body.dark { background: #1e293b; color: white; }'
                        ]
                    });
                    
                    // Set the content in CKEditor after initialization
                    editEditor.on('instanceReady', function() {
                        this.setData(content);
                    });
                    
                    // Update the hidden textarea before form submission
                    document.getElementById('editTopicForm').addEventListener('submit', function() {
                        document.getElementById('edit_content').value = editEditor.getData();
                    });
                });
            });
            
            // Clean up when modal is closed
            document.getElementById('closeEditModal').addEventListener('click', function() {
                if (editEditor) {
                    editEditor.destroy();
                    editEditor = null;
                }
                // Reset form
                document.getElementById('editTopicForm').reset();
                document.getElementById('editTopicForm').action = '';
            });
<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes
=======
>>>>>>> parent of c90dbe7 (done major functionalities)
>>>>>>> Stashed changes
        });
    </script>
</x-app-layout>