<x-app-layout>
    @extends('layouts.admindashboard')

    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <div id="scrollspy" class="space-y-10 md:space-y-16">
                <div id="courses" class="min-h-[25rem] scroll-mt-24">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Courses</h2>

                    <!-- Add Course Button -->
                    <div class="mb-4">
                        <button type="button" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" 
                            data-hs-overlay="#addcourseModal">
                            + Add Course
                        </button>
                    </div>

                    <!-- Add Course Modal -->
                    <div id="addcourseModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Course</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    data-hs-overlay="#addcourseModal">
                                    ✕
                                </button>
                            </div>
                            <form action="{{ route('admin.courses.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Name</label>
                                    <input type="text" id="course_name" name="course_name" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="mb-3">
                                    <label for="course_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Description</label>
                                    <textarea id="course_desc" name="course_desc" rows="3" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Course</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Display Courses -->
                    @if ($courses->isEmpty())
                        <p class="text-gray-500">No courses available.</p>
                    @else
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($courses as $course)
                                <!-- Course Card -->
                                <div class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-gray-900 dark:border-gray-800 p-4">
                                    <a href="{{ route('admin.courses.show', $course->id) }}" class="no-underline text-blue-500 hover:underline">
                                        <h3 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $course->course_name }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $course->course_desc }}
                                        </p>
                                    </a>

                                    <!-- Assigned Roles Badges -->
                                    @if($course->assignedRoles->isNotEmpty())
                                        <div class="mt-2 flex flex-wrap gap-1">
                                            @foreach($course->assignedRoles as $role)
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $role->role_name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Dropdown for Actions -->
                                    <div class="mt-4 flex justify-end">
                                        <div class="hs-dropdown relative inline-flex">
                                            <button id="hs-dropdown-with-icons" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                                Actions
                                                <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                            </button>

                                            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 divide-y divide-gray-200 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-with-icons">
                                                <div class="p-1 space-y-0.5">
                                                    
                                                    <!-- Assign Role Action -->
                                                    <button type="button" 
                                                        class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none dark:text-neutral-400 dark:hover:bg-neutral-700"
                                                        onclick="openAssignModal(
                                                            '{{ $course->id }}', 
                                                            '{{ $course->course_name }}', 
                                                            {{ json_encode($course->assignedRoles->pluck('role_name')->toArray()) }}
                                                        )">
                                                        🎓 Assign Role
                                                    </button>

                                                    <!-- Edit Action -->
                                                    <button type="button" 
                                                        class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none dark:text-neutral-400 dark:hover:bg-neutral-700"
                                                        onclick="openEditModal(
                                                            '{{ $course->id }}', 
                                                            '{{ $course->course_name }}', 
                                                            '{{ $course->course_desc }}'
                                                        )">
                                                        ✎ Edit
                                                    </button>

                                                    <!-- Delete Action -->
                                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700">
                                                            🗑️ Delete
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

                    <!-- Edit Course Modal -->
                    <div id="editcourseModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Course</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    onclick="closeEditModal()">
                                    ✕
                                </button>
                            </div>

                            <form id="editCourseForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="edit_course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Name</label>
                                    <input type="text" id="edit_course_name" name="course_name" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_course_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Description</label>
                                    <textarea id="edit_course_desc" name="course_desc" rows="3" required
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Course</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Assign Role Modal -->
                    <div id="assignRoleModal" class="hs-overlay hidden fixed inset-0 z-[80] w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Assign Role to Course: <span id="modalCourseName"></span>
                                </h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" 
                                    onclick="closeAssignModal()">
                                    ✕
                                </button>
                            </div>

                            <form id="assignRoleForm" method="POST">
                                @csrf
                                <input type="hidden" id="courseIdInput" name="course_id">
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-2 dark:text-white">
                                        Select Roles
                                    </label>
                                    <div class="space-y-2">
                                        @foreach(['Faculty', 'Staff', 'Student', 'Others'] as $role)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="roles[]" value="{{ $role }}" 
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 role-checkbox"
                                                    data-role="{{ $role }}">
                                                <span class="ml-2">{{ $role }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="closeAssignModal()"
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:text-white dark:hover:bg-gray-700">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
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

        // Handle form submission
        document.getElementById('assignRoleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            const courseId = formData.get('course_id');
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = 'Saving...';
            
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
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeAssignModal();
                    // Refresh the page to show changes
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Failed to save roles');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving roles: ' + error.message);
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Save Roles';
            });
        });

        // Handle edit form submission
        document.getElementById('editCourseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = 'Saving...';
            
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the course');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Update Course';
            });
        });
    </script>
</x-app-layout>