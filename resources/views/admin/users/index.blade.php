<x-app-layout>
    @extends('layouts.admindashboard')
    <div class="lg:ps-[260px]">
        <div id="users" class="min-h-[75rem] p-4 md:p-8">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Users</h2>
            
            <!-- Add User Button -->
            <div class="mb-4">
                <button onclick="openCreateModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Add New User
                </button>
            </div>

            <div class="overflow-x-auto">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-neutral-300">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-neutral-300">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-neutral-300">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-neutral-300">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-neutral-300">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-neutral-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-neutral-100">{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-neutral-100">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-neutral-100">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-neutral-100">{{ $user->contact }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $user->role_name === 'Admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-100' : 
                                           ($user->role_name === 'Faculty' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' :
                                           ($user->role_name === 'Staff' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' :
                                           ($user->role_name === 'Student' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100' : 
                                           'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100'))) }}">
                                        {{ $user->role_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-neutral-100">
                                    <div class="flex gap-2">
                                        <button onclick="openEditModal('{{ $user->id }}')" 
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button onclick="openDeleteModal('{{ $user->id }}', '{{ $user->name }}')" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="create-user-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-[90vh] flex flex-col dark:bg-neutral-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create New User</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto flex-grow">
                <form id="createUserForm" method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="create_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" id="create_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                        </div>
                        <div>
                            <label for="create_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="create_email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                        </div>
                        <div>
                            <label for="create_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact</label>
                            <input type="text" name="contact" id="create_contact" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                        </div>
                        <div>
                            <label for="create_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                            <select name="role_name" id="create_role" required onchange="toggleCreateFields()"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Faculty">Faculty</option>
                                <option value="Staff">Staff</option>
                                <option value="Student">Student</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div id="create_extra_fields"></div>
                        <div>
                            <label for="create_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input type="password" name="password" id="create_password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                        </div>
                        <div>
                            <label for="create_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="create_password_confirmation" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-neutral-600 dark:text-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="edit-user-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 dark:bg-neutral-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit User</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="edit_name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" id="edit_email" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact</label>
                        <input type="text" name="contact" id="edit_contact" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select name="role_name" id="edit_role" required onchange="toggleEditFields()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                            <option value="">Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Staff">Staff</option>
                            <option value="Student">Student</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div id="edit_extra_fields"></div>
                    <div>
                        <label for="edit_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" id="edit_password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-neutral-600 dark:text-gray-300">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-user-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 dark:bg-neutral-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Confirm Deletion</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mb-6" id="delete-confirmation-text">Are you sure you want to delete this user?</p>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-neutral-600 dark:text-gray-300">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Create User Modal Functions
        function openCreateModal() {
            document.getElementById('create-user-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-user-modal').classList.add('hidden');
        }

        // Edit User Modal Functions
        function openEditModal(userId) {
            fetch(`/admin/users/${userId}/edit`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('edit_name').value = user.name;
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_contact').value = user.contact;
                    document.getElementById('edit_role').value = user.role_name;
                    document.getElementById('editUserForm').action = `/admin/users/${userId}`;
                    
                    // Trigger role change to show appropriate fields
                    document.getElementById('edit_role').dispatchEvent(new Event('change'));
                    
                    // Open modal
                    document.getElementById('edit-user-modal').classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        function closeEditModal() {
            document.getElementById('edit-user-modal').classList.add('hidden');
        }

        // Delete User Modal Functions
        function openDeleteModal(userId, userName) {
            document.getElementById('delete-confirmation-text').textContent = 
                `Are you sure you want to delete user "${userName}"?`;
            document.getElementById('deleteUserForm').action = `/admin/users/${userId}`;
            document.getElementById('delete-user-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-user-modal').classList.add('hidden');
        }

        // Dynamic Field Functions
        function toggleCreateFields() {
            const role = document.getElementById('create_role').value;
            const container = document.getElementById('create_extra_fields');
            container.innerHTML = '';

            if (role === 'Faculty' || role === 'Staff') {
                container.innerHTML += `
                    <div>
                        <label for="create_employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee ID</label>
                        <input type="text" name="employee_id" id="create_employee_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Faculty') {
                container.innerHTML += `
                    <div>
                        <label for="create_department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                        <input type="text" name="department" id="create_department"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Staff') {
                container.innerHTML += `
                    <div>
                        <label for="create_office_unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Office Unit</label>
                        <input type="text" name="office_unit" id="create_office_unit"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Student') {
                container.innerHTML += `
                    <div>
                        <label for="create_student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student ID</label>
                        <input type="text" name="student_id" id="create_student_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                    <div>
                        <label for="create_college_department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">College/Department</label>
                        <input type="text" name="college_department" id="create_college_department" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Others') {
                container.innerHTML += `
                    <div>
                        <label for="create_stakeholder" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stakeholder</label>
                        <input type="text" name="stakeholder" id="create_stakeholder"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
        }

        function toggleEditFields() {
            const role = document.getElementById('edit_role').value;
            const container = document.getElementById('edit_extra_fields');
            container.innerHTML = '';

            if (role === 'Faculty' || role === 'Staff') {
                container.innerHTML += `
                    <div>
                        <label for="edit_employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee ID</label>
                        <input type="text" name="employee_id" id="edit_employee_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Faculty') {
                container.innerHTML += `
                    <div>
                        <label for="edit_department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                        <input type="text" name="department" id="edit_department"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Staff') {
                container.innerHTML += `
                    <div>
                        <label for="edit_office_unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Office Unit</label>
                        <input type="text" name="office_unit" id="edit_office_unit"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Student') {
                container.innerHTML += `
                    <div>
                        <label for="edit_student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student ID</label>
                        <input type="text" name="student_id" id="edit_student_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_college_department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">College/Department</label>
                        <input type="text" name="college_department" id="edit_college_department" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
            if (role === 'Others') {
                container.innerHTML += `
                    <div>
                        <label for="edit_stakeholder" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stakeholder</label>
                        <input type="text" name="stakeholder" id="edit_stakeholder"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                    </div>
                `;
            }
        }
    </script>
</x-app-layout>