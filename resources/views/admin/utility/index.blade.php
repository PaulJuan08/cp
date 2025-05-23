<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[260px]">
        <div class="container mx-auto px-4 py-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Utilities Management</h1>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Manage legal documents and policies</p>
                </div>
                <button type="button" 
                    class="px-4 py-2.5 inline-flex items-center justify-center gap-x-2 text-sm font-medium rounded-lg bg-blue-600 text-white shadow-sm hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    data-hs-overlay="#create-utility-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Create New Utility</span>
                </button>
            </div>

            <!-- Utilities Table -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border dark:border-neutral-700 overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-neutral-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-neutral-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-neutral-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-neutral-300 uppercase tracking-wider">Last Updated</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-neutral-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-gray-200 dark:divide-neutral-700">
                            @forelse($utilities as $utility)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($utility->type)
                                    @case('terms')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            <svg class="mr-1.5 h-2 w-2 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Terms & Conditions
                                        </span>
                                        @break
                                    @case('privacy')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <svg class="mr-1.5 h-2 w-2 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Privacy Policy
                                        </span>
                                        @break
                                    @case('cookies')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <svg class="mr-1.5 h-2 w-2 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Cookies 
                                        </span>
                                        @break
                                @endswitch
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium" 
                                            data-hs-overlay="#utility-content-modal-{{ $utility->id }}">
                                        {{ $utility->title }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($utility->is_published)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-neutral-200">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-gray-500 dark:text-neutral-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $utility->updated_at->format('M j, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-x-2">
                                        <button class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 p-1.5 rounded hover:bg-gray-100 dark:hover:bg-neutral-700" 
                                                data-hs-overlay="#edit-utility-modal-{{ $utility->id }}"
                                                title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        
                                        <form action="{{ route('admin.utilities.toggle-publish', $utility) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center text-{{ $utility->is_published ? 'yellow' : 'green' }}-600 hover:text-{{ $utility->is_published ? 'yellow' : 'green' }}-800 dark:text-{{ $utility->is_published ? 'yellow' : 'green' }}-400 dark:hover:text-{{ $utility->is_published ? 'yellow' : 'green' }}-300 p-1.5 rounded hover:bg-gray-100 dark:hover:bg-neutral-700"
                                                    title="{{ $utility->is_published ? 'Unpublish' : 'Publish' }}">
                                                @if($utility->is_published)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.utilities.destroy', $utility) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-1.5 rounded hover:bg-gray-100 dark:hover:bg-neutral-700"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this utility?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Content Modal for each utility -->
                            <div class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" id="utility-content-modal-{{ $utility->id }}">
                                <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                                    <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-xl">
                                        <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                                {{ $utility->title }}
                                                <span class="text-xs font-normal text-gray-500 dark:text-neutral-400 ml-2">{{ ucfirst($utility->type) }}</span>
                                            </h3>
                                            <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#utility-content-modal-{{ $utility->id }}">
                                                <span class="sr-only">Close</span>
                                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 6 6 18"/>
                                                    <path d="m6 6 12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <div class="p-4 overflow-y-auto max-h-[60vh]">
                                            <div class="prose dark:prose-invert max-w-none">
                                                {!! $utility->content !!}
                                            </div>
                                        </div>
                                        
                                        <div class="p-4 border-t dark:border-neutral-700 flex justify-between items-center">
                                            <div class="text-sm text-gray-500 dark:text-neutral-400">
                                                Last updated: {{ $utility->updated_at->format('M j, Y \a\t H:i') }}
                                            </div>
                                            <div class="flex gap-x-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-hs-overlay="#utility-content-modal-{{ $utility->id }}">Close</button>
                                                <button type="button" class="btn btn-sm btn-primary">Accept</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-400">
                                    No utilities found. Click "Create New Utility" to add one.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($utilities->hasPages())
                <div class="px-6 py-3 border-t dark:border-neutral-700">
                    {{ $utilities->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Create Utility Modal with CKEditor -->
        <div class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" id="create-utility-modal">
            <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto">
                <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-xl">
                    <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Create New Utility Document
                        </h3>
                        <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#create-utility-modal">
                            <span class="sr-only">Close</span>
                            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"/>
                                <path d="m6 6 12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form action="{{ route('admin.utilities.store') }}" method="POST" id="create-utility-form">
                        @csrf
                        <div class="p-4 overflow-y-auto max-h-[70vh] space-y-4">
                            <div>
                                <label for="create-type" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">Document Type</label>
                                <select id="create-type" name="type" class="form-select" required>
                                    <option value="" disabled selected>Select document type</option>
                                    <option value="terms">Terms and Conditions</option>
                                    <option value="privacy">Privacy Policy</option>
                                    <option value="cookies">Cookies </option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="create-title" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">Document Title</label>
                                <input type="text" id="create-title" name="title" class="form-input" placeholder="e.g., Updated Terms of Service" required>
                            </div>
                            
                            <div>
                                <label for="create-content" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">Document Content</label>
                                <textarea id="create-content" name="content" class="hidden"></textarea>
                                <div id="create-content-editor" class="ckeditor-content border border-gray-200 dark:border-neutral-600 rounded-lg"></div>
                            </div>
                            
                        </div>
                        
                        <div class="p-4 border-t dark:border-neutral-700 flex justify-end gap-x-2">
                            <!-- Cancel Button -->
                            <button type="button" 
                                    class="px-4 py-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-gray-300 dark:hover:bg-neutral-700" 
                                    data-hs-overlay="#create-utility-modal">
                                Cancel
                            </button>
                            
                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="px-4 py-2 inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-blue-700 dark:hover:bg-blue-800"
                                    id="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Create Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Utility Modal with CKEditor (for each utility) -->
        @foreach($utilities as $utility)
        <div class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" id="edit-utility-modal-{{ $utility->id }}">
            <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto">
                <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-xl">
                    <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Edit Utility Document
                        </h3>
                        <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#edit-utility-modal-{{ $utility->id }}">
                            <span class="sr-only">Close</span>
                            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"/>
                                <path d="m6 6 12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form action="{{ route('admin.utilities.update', $utility) }}" method="POST" id="edit-utility-form-{{ $utility->id }}">
                        @csrf
                        @method('PUT')
                        <div class="p-4 overflow-y-auto max-h-[70vh] space-y-4">
                            <div>
                                <label for="edit-type-{{ $utility->id }}" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">Document Type</label>
                                <select id="edit-type-{{ $utility->id }}" name="type" class="form-select" disabled>
                                    <option value="terms" {{ $utility->type == 'terms' ? 'selected' : '' }}>Terms and Conditions</option>
                                    <option value="privacy" {{ $utility->type == 'privacy' ? 'selected' : '' }}>Privacy Policy</option>
                                    <option value="cookies" {{ $utility->type == 'cookies' ? 'selected' : '' }}>Cookies </option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="edit-title-{{ $utility->id }}" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">Document Title</label>
                                <input type="text" id="edit-title-{{ $utility->id }}" name="title" class="form-input" value="{{ $utility->title }}" required>
                            </div>
                            
                            <div>
                                <label for="edit-content-{{ $utility->id }}" class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-300">Document Content</label>
                                <textarea id="edit-content-{{ $utility->id }}" name="content" class="hidden">{{ $utility->content }}</textarea>
                                <div id="edit-content-editor-{{ $utility->id }}" class="ckeditor-content border border-gray-200 dark:border-neutral-600 rounded-lg">{!! $utility->content !!}</div>
                            </div>
                            
                        </div>
                        
                        <div class="p-4 border-t dark:border-neutral-700 flex justify-end gap-x-3">
                            <!-- Cancel Button -->
                            <button type="button"
                                    class="px-5 py-2.5 inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-700 shadow-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-200 ease-in-out dark:bg-neutral-800 dark:border-neutral-700 dark:text-gray-300 dark:hover:bg-neutral-700 dark:focus:ring-offset-gray-800"
                                    data-hs-overlay="#edit-utility-modal-{{ $utility->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </button>
                            
                            <!-- Submit Button -->
                            <button type="submit"
                                    class="px-5 py-2.5 inline-flex items-center justify-center rounded-lg border border-transparent bg-blue-600 text-sm font-medium text-white shadow-xs hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-200 ease-in-out disabled:opacity-70 disabled:cursor-not-allowed dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-offset-gray-800"
                                    id="save-changes-btn-{{ $utility->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    
    <!-- JavaScript Initialization -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all HS Overlay modals
        document.querySelectorAll('[data-hs-overlay]').forEach(function(button) {
            button.addEventListener('click', function(e) {
                const target = this.getAttribute('data-hs-overlay');
                const modal = document.querySelector(target);
                
                if (modal) {
                    if (modal.classList.contains('hidden')) {
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    } else {
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                }
            });
        });
        
        // Close modal when clicking on backdrop
        document.querySelectorAll('.hs-overlay').forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // Initialize CKEditor for create modal
        let createEditor;
        const createEditorElement = document.querySelector('#create-content-editor');
        if (createEditorElement) {
            ClassicEditor
                .create(createEditorElement, {
                    // CKEditor configuration options
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    }
                })
                .then(editor => {
                    createEditor = editor;
                    
                    // Update textarea before form submission
                    document.getElementById('create-utility-form').addEventListener('submit', function() {
                        document.getElementById('create-content').value = editor.getData();
                    });
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        }
        
        // Initialize CKEditor for each edit modal
        @foreach($utilities as $utility)
        (function(utilityId) {
            let editEditor;
            const editEditorElement = document.querySelector('#edit-content-editor-' + utilityId);
            if (editEditorElement) {
                ClassicEditor
                    .create(editEditorElement, {
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                                'blockQuote', 'insertTable', 'undo', 'redo'
                            ]
                        }
                    })
                    .then(editor => {
                        editEditor = editor;
                        
                        const form = document.getElementById('edit-utility-form-' + utilityId);
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                // Update the hidden textarea with editor content
                                document.getElementById('edit-content-' + utilityId).value = editor.getData();
                                
                                // Continue with form submission
                                return true;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error initializing CKEditor for utility ' + utilityId + ':', error);
                    });
            }
        })('{{ $utility->id }}');
        @endforeach
    });
    </script>
</x-app-layout>