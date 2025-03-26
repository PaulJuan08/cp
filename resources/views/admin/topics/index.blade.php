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

                    <!-- Add Topic Modal -->
                    <div id="addTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Topic</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#addTopicModal">
                                    ✕
                                </button>
                            </div>
                            <div class="max-h-[80vh] overflow-y-auto">
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

                    

                    <!-- Display Topics -->
                    @if ($topics->isEmpty())
                        <p class="text-gray-500">No topics available.</p>
                    @else
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($topics as $topic)
                                <!-- Topic Card -->
                                <div class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-gray-900 dark:border-gray-800 p-4">
                                <a href="{{ route('admin.contents.show', $topic->id) }}" 
                                class="no-underline text-blue-500 hover:underline">
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
                                                    <a href="{{ route('admin.topics.quiz.create', $topic) }}"
                                                    class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700">
                                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M12 5v14M5 12h14"/>
                                                        </svg>
                                                        Create Quiz
                                                    </a>


                                                    <!-- Edit Action -->
                                                    <a href="#" class="edit-btn flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700"
                                                        data-id="{{ $topic->id }}" 
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
                                                    <form action="{{ route('admin.topics.destroy', $topic->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');">
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

                    <!-- Edit Topic Modal -->
                    <div id="editTopicModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Topic</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#editTopicModal">
                                    ✕
                                </button>
                            </div>
                            <div class="max-h-[80vh] overflow-y-auto">
                            <form id="editTopicForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_topic_id" name="topic_id">

                                <div class="mb-3">
                                    <label for="edit_topic_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic Name</label>
                                    <input type="text" id="edit_topic_name" name="topic_name" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_topic_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic Description</label>
                                    <textarea id="edit_topic_desc" name="topic_desc" rows="3" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                                    <textarea id="edit_content" name="content" rows="3" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube Video URL</label>
                                    <input type="url" id="edit_video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=..."
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Topic</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            CKEDITOR.replace('content');
        });
    </script>

    <!-- JavaScript to Handle Edit Modal -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            CKEDITOR.replace('edit_content'); // Initialize CKEditor for the edit modal

            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function() {
                    document.getElementById("edit_topic_id").value = this.dataset.id;
                    document.getElementById("edit_topic_name").value = this.dataset.name;
                    document.getElementById("edit_topic_desc").value = this.dataset.desc;
                    CKEDITOR.instances['edit_content'].setData(this.dataset.content);
                    document.getElementById("edit_video_url").value = this.dataset.video;

                    document.getElementById("editTopicForm").setAttribute("action", `/admin/topics/${this.dataset.id}`);
                });
            });
        });
    </script>



</x-app-layout>