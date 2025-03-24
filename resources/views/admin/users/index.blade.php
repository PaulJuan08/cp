<x-app-layout>
    

    <!-- ========== MAIN CONTENT ========== -->
@extends('layouts.admindashboard')
<div class="lg:ps-[260px] ">
<div id="users" class="min-h-[25rem] scroll-mt-24">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Users</h2>
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                    <h3 class="text-lg font-bold mb-4">All Users</h3>
                </div>
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-800">
                                <tr>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Name</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Email</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Contact</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Role</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Student ID</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Employee ID</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Course</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Department</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Office Unit</span>
                                    </th>
                                    <th class="px-4 py-2 text-start whitespace-nowrap">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Stakeholder</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @foreach($users as $user)
                            <tr class="border">
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border">{{ $user->contact }}</td>
                                <td class="px-4 py-2 border">{{ $user->role_name }}</td>
                                <td class="px-4 py-2 border">{{ $user->studentID ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border">{{ $user->employeeID ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border">{{ $user->college_department ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border">{{ $user->office_unit ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border">{{ $user->stakeholder ?? 'N/A' }}</td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>