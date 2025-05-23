<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8 bg-gray-50 dark:bg-gray-900">
            <div id="scrollspy" class="space-y-10 md:space-y-16">
                <div id="courses" class="min-h-[25rem] scroll-mt-24">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Courses</h2>
                        
                        <!-- Add Course Button -->
                        <button type="button" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm flex items-center gap-2" 
                            data-hs-overlay="#addcourseModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Course
                        </button>
                    </div>

                    <!-- Add Course Modal -->
                    <div id="addcourseModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md dark:bg-gray-800 transition-transform duration-300 ease-out transform">
                            <div class="flex justify-between items-center mb-6">
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white">Create New Course</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#addcourseModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('admin.courses.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course Name</label>
                                    <input type="text" id="course_name" name="course_name" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors">
                                </div>
                                <div class="mb-5">
                                    <label for="course_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course Description</label>
                                    <textarea id="course_desc" name="course_desc" rows="4" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-sm">Create Course</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Search functionality-->
                    <div class="mb-6 mt-2 w-full">
                        <div class="relative">
                            <input type="text" id="course-search" 
                                class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                                placeholder="Search courses by name or role...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Display Courses -->
                    @if ($courses->isEmpty())
                        <div class="flex flex-col items-center justify-center p-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="text-gray-500 text-lg">No courses available.</p>
                            <p class="text-gray-400 text-sm mt-2">Create your first course to get started.</p>
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($courses as $course)
                                <!-- Course Card -->
                                <div class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-gray-800 dark:border-gray-700 overflow-hidden h-full">
                                    <div class="p-5 flex flex-col flex-grow">
                                        <a href="{{ route('admin.courses.show', encrypt($course->id)) }}" class="no-underline group-hover:text-blue-600 transition-colors">
                                            <h3 class="font-bold text-gray-800 text-lg mb-2 dark:text-white group-hover:text-blue-600 transition-colors">
                                                {{ $course->course_name }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                                {{ $course->course_desc }}
                                            </p>
                                        </a>

                                        <!-- Assigned Roles Badges -->
                                        @if($course->assignedRoles->isNotEmpty())
                                            <div class="mt-auto pt-3 flex flex-wrap gap-1.5 border-t border-gray-100 dark:border-gray-700">
                                                @foreach($course->assignedRoles->unique('role_name') as $role)
                                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full inline-flex items-center justify-center
                                                        @switch($role->role_name)
                                                            @case('Faculty') bg-blue-100 text-blue-800 @break
                                                            @case('Staff') bg-green-100 text-green-800 @break
                                                            @case('Student') bg-yellow-100 text-yellow-800 @break
                                                            @default bg-gray-100 text-gray-800
                                                        @endswitch">
                                                        {{ $role->role_name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="mt-auto pt-3 border-t border-gray-100 dark:border-gray-700">
                                                <span class="text-xs text-gray-500 dark:text-gray-400 italic">
                                                    No roles assigned
                                                </span>
                                            </div>
                                        @endif
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
                                                    <!-- Assign Role Action -->
                                                    <button type="button" 
                                                        class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                                                        onclick="openAssignModal(
                                                            '{{ $course->id }}', 
                                                            '{{ $course->course_name }}', 
                                                            {{ json_encode($course->assignedRoles->pluck('role_name')->unique()->toArray()) }}
                                                        )">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                        Assign Role
                                                    </button>

                                                    <!-- View Users Who Enrolled this Course -->   
                                                    <button type="button"
                                                        class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                                                        onclick="fetchEnrolledUsers('{{ $course->id }}', '{{ $course->course_name }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        List of Users Enrolled 
                                                    </button>
                                                </div>
                                                <div class="py-1 space-y-1">
                                                    <!-- Edit Action -->
                                                    <button type="button" 
                                                        class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                                                        onclick="openEditModal(
                                                            '{{ encrypt($course->id) }}', 
                                                            '{{ $course->course_name }}', 
                                                            '{{ $course->course_desc }}'
                                                        )">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </button>

                                                    <!-- Delete Action -->
                                                    <form action="{{ route('admin.courses.destroy', encrypt($course->id)) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
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

                    <!-- List of Users Enrolled in this Course -->
                    <div id="viewUsersModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-lg dark:bg-gray-800 transition-transform duration-300 ease-out transform">
                            <div class="flex justify-between items-center mb-6">
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white" id="viewUsersModalTitle"></h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    onclick="closeViewUsersModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div id="enrolledUsersList" class="bg-white dark:bg-gray-800 rounded-lg"></div>
                        </div>
                    </div>

                    <!-- Edit Course Modal -->
                    <div id="editcourseModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md dark:bg-gray-800 transition-transform duration-300 ease-out transform">
                            <div class="flex justify-between items-center mb-6">
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white">Edit Course</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    onclick="closeEditModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form id="editCourseForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="edit_course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course Name</label>
                                    <input type="text" id="edit_course_name" name="course_name" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors">
                                </div>
                                <div class="mb-5">
                                    <label for="edit_course_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course Description</label>
                                    <textarea id="edit_course_desc" name="course_desc" rows="4" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"></textarea>
                                </div>
                                <div class="flex justify-end gap-3">
                                    <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-sm">
                                        Update Course
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Assign Role Modal -->
                    <div id="assignRoleModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md dark:bg-gray-800 transition-transform duration-300 ease-out transform">
                            <div class="flex justify-between items-center mb-6">
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white">
                                    Assign Role to Course: <span id="modalCourseName" class="text-blue-600 dark:text-blue-400"></span>
                                </h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    onclick="closeAssignModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form id="assignRoleForm" method="POST">
                                @csrf
                                <input type="hidden" id="courseIdInput" name="course_id">
                                
                                <div class="mb-6">
                                    <label class="block text-base font-medium mb-3 dark:text-white">
                                        Select Roles
                                    </label>
                                    <div class="space-y-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        @foreach(['Faculty', 'Staff', 'Student', 'Others'] as $role)
                                            <label class="flex items-center p-2 hover:bg-white dark:hover:bg-gray-600 rounded-md transition-colors cursor-pointer">
                                                <input type="checkbox" name="roles[]" value="{{ $role }}" 
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 role-checkbox h-5 w-5"
                                                    data-role="{{ $role }}">
                                                <span class="ml-3 text-gray-700 dark:text-gray-300">{{ $role }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3">
                                    <button type="button" onclick="closeAssignModal()"
                                        class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-sm">
                                        Save Roles
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Edit Course Modal Functions
        function openEditModal(id, name, desc) {
            document.getElementById('edit_course_name').value = name;
            document.getElementById('edit_course_desc').value = desc;
            document.getElementById('editCourseForm').action = `/admin/courses/${id}`;
            document.getElementById('editcourseModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editcourseModal').classList.add('hidden');
        }

        // Assign Role Modal Functions
        function openAssignModal(courseId, courseName, assignedRoles) {
            // Set course name in modal title
            document.getElementById('modalCourseName').textContent = courseName;
            
            // Set course ID in hidden input
            document.getElementById('courseIdInput').value = courseId;
            
            // Reset all checkboxes
            document.querySelectorAll('.role-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Check the boxes for assigned roles
            if (Array.isArray(assignedRoles)) {
                assignedRoles.forEach(role => {
                    const checkbox = document.querySelector(`.role-checkbox[data-role="${role}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
            
            // Show modal
            document.getElementById('assignRoleModal').classList.remove('hidden');
        }

        function closeAssignModal() {
            document.getElementById('assignRoleModal').classList.add('hidden');
        }

        // AssignRoleForm event listener 
        document.getElementById('assignRoleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            const courseId = formData.get('course_id');
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
            
            fetch(`/admin/courses/${courseId}/assign-roles`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeAssignModal();
                    // Show success message with toast
                    showToast('Success', 'Roles assigned successfully!', 'success');
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Failed to save roles');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'Error saving roles: ' + (error.message || 'Unknown error'), 'error');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Save Roles';
            });
        });

        // EditCourseForm event listener 
        document.getElementById('editCourseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Updating...';
            
            // Add _method=PUT to the form data
            formData.append('_method', 'PUT');
            
            fetch(form.action, {
                method: 'POST', // Still POST because we're using _method override
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    showToast('Success', 'Course updated successfully!', 'success');
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Failed to update course');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'Error updating course: ' + (error.message || 'Unknown error'), 'error');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Update Course';
            });
        });

        // View Users Modal Functions
        function fetchEnrolledUsers(courseId, courseName) {
            const usersList = document.getElementById('enrolledUsersList');
            usersList.innerHTML = `
                <div class="flex justify-center items-center p-8">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="ml-3 text-gray-600 dark:text-gray-300">Loading users...</span>
                </div>`;
            
            // Show modal immediately with loading state
            document.getElementById('viewUsersModal').classList.remove('hidden');
            
            fetch(`/admin/courses/${courseId}/users`)
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Error response text:', text);
                            throw new Error(`Server returned ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        displayEnrolledUsers(courseId, courseName, data.users);
                    } else {
                        throw new Error(data.message || 'Failed to fetch enrolled users');
                    }
                })
                .catch(error => {
                    console.error('Full error:', error);
                    usersList.innerHTML = `
                        <div class="p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-red-500 font-medium mb-3">Error: ${error.message}</p>
                            <button onclick="fetchEnrolledUsers('${courseId}', '${courseName}')" 
                                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Retry
                            </button>
                        </div>
                    `;
                });
        }

        function displayEnrolledUsers(courseId, courseName, enrolledUsers) {
            // Set course name in modal title
            document.getElementById('viewUsersModalTitle').textContent = 
                `Users Enrolled in ${courseName}`;
            
            // Clear previous content
            const usersList = document.getElementById('enrolledUsersList');
            
            // Check if there are enrolled users
            if (enrolledUsers && enrolledUsers.length > 0) {
                // Create a table to display users
                usersList.innerHTML = `
                    <div class="overflow-y-auto max-h-[400px] rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-12 gap-4 font-semibold text-sm py-3 px-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700 sticky top-0">
                            <div class="col-span-2">ID</div>
                            <div class="col-span-6">Name</div>
                            <div class="col-span-4">Role</div>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700" id="usersTableBody"></div>
                    </div>
                `;
                
                const tableBody = document.getElementById('usersTableBody');
                
                // Add each user to the table
                enrolledUsers.forEach(user => {
                    const userRow = document.createElement('div');
                    userRow.className = 'grid grid-cols-12 gap-4 text-sm py-3 px-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors';
                    userRow.innerHTML = `
                        <div class="col-span-2 flex items-center font-medium text-gray-700 dark:text-gray-300">${user.user_id}</div>
                        <div class="col-span-6 flex items-center text-gray-800 dark:text-gray-200">${user.user_name}</div>
                        <div class="col-span-4">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full ${getRoleBadgeClass(user.role_name)}">
                                ${user.role_name}
                            </span>
                        </div>
                    `;
                    tableBody.appendChild(userRow);
                });
            } else {
                usersList.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-gray-500 text-lg">No users enrolled in this course yet.</p>
                        <p class="text-gray-400 text-sm mt-2">Users will appear here once they enroll.</p>
                    </div>
                `;
            }
        }

        function getRoleBadgeClass(roleName) {
            switch(roleName) {
                case 'Faculty': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                case 'Staff': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                case 'Student': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                default: return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
            }
        }

        function closeViewUsersModal() {
            document.getElementById('viewUsersModal').classList.add('hidden');
        }

        // Toast notification function
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

        // Course search functionality
        function initCourseSearch() {
            const searchInput = document.getElementById('course-search');
            if (!searchInput) return;

            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase().trim();
                const courseCards = document.querySelectorAll('.grid > div.group'); // Select all course cards
                
                // If search is empty, show all courses
                if (searchValue === '') {
                    courseCards.forEach(card => {
                        card.style.display = 'flex';
                    });
                    return;
                }
                
                let hasResults = false;
                
                courseCards.forEach(card => {
                    const courseName = card.querySelector('h3').textContent.toLowerCase().trim();
                    const roleElements = card.querySelectorAll('.mt-auto span');
                    let roleNames = [];
                    
                    // Extract role names from badges
                    roleElements.forEach(roleElem => {
                        if (roleElem.textContent.trim() !== 'No roles assigned') {
                            roleNames.push(roleElem.textContent.toLowerCase().trim());
                        }
                    });
                    
                    // Check if search value matches course name or any role
                    const matchesCourseName = courseName.includes(searchValue);
                    const matchesRole = roleNames.some(role => role.includes(searchValue));
                    
                    if (matchesCourseName || matchesRole) {
                        card.style.display = 'flex';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Handle no results scenario
                const noCoursesElement = document.querySelector('.flex.flex-col.items-center.justify-center.p-8');
                const noResultsElement = document.getElementById('no-search-results');
                
                if (!hasResults && courseCards.length > 0) {
                    // If no results are found, display the "No results" message
                    if (!noResultsElement) {
                        const noResultsDiv = document.createElement('div');
                        noResultsDiv.id = 'no-search-results';
                        noResultsDiv.className = 'flex flex-col items-center justify-center p-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mt-4';
                        noResultsDiv.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-gray-500 text-lg">No courses match your search criteria.</p>
                            <p class="text-gray-400 text-sm mt-2">Try a different search term or clear the search.</p>
                        `;
                        
                        // Insert after the grid
                        const coursesGrid = document.querySelector('.grid');
                        if (coursesGrid) {
                            coursesGrid.parentNode.insertBefore(noResultsDiv, coursesGrid.nextSibling);
                        }
                    }
                    
                    // Hide the grid when no results
                    document.querySelector('.grid').style.display = 'none';
                    
                    // Also hide the "No courses available" message if it exists
                    if (noCoursesElement) {
                        noCoursesElement.style.display = 'none';
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
        document.addEventListener('DOMContentLoaded', function() {
            initCourseSearch();
        });
</script>
</x-app-layout>