<x-app-layout>
  @extends('layouts.usersdashboard')


    <div class="lg:ps-[260px]">
      <div class="min-h-[75rem] p-4 md:p-8">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Dashboard</h2>

        <!-- Card Section -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Example Card -->
            <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
              <h3 class="text-lg font-semibold">Welcome to CoursePriva</h3>
              <p class="text-sm text-gray-600 dark:text-gray-300">Manage your courses here.</p>
            </div>
          </div>
        </div>
        <!-- End Card Section -->
      </div>
    </div>

</x-app-layout>
