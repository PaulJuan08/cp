<x-app-layout>
    

    <!-- ========== MAIN CONTENT ========== -->
@extends('layouts.admindashboard')

<!-- Content -->
<div class="lg:ps-[260px] ">
  <div class="min-h-[75rem] p-4 md:p-8">
    <!-- your content goes here ... -->

    <!-- Content -->
    <div id="scrollspy" class="space-y-10 md:space-y-16">
      <div id="dashboard" class="min-h-[25rem] scroll-mt-24">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Dashboard</h2>
        
        <!-- Card Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Grid -->
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    
    <!-- Card -->
    <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
      <div class="inline-flex justify-center items-center">
        <span class="size-2 inline-block bg-green-500 rounded-full me-2"></span>
        <span class="text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400">Courses</span>
      </div>

      <div class="text-center">
          <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200">
              @if($totalCourses > 0)
                  {{ $totalCourses }} <!-- Display total number of topics -->
              @else
                  0 <!-- Fallback if no topics exist -->
              @endif
          </h3>
      </div>
      <dl class="flex justify-center items-center divide-x divide-gray-200 dark:divide-neutral-800">
        <dt class="pe-3">
          <span class="text-green-600">
            <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
            <span class="inline-block text-sm">
              1.7%
            </span>
          </span>
          <span class="block text-sm text-gray-500 dark:text-neutral-500">change</span>
        </dt>
        <dd class="text-start ps-3">
          <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">5</span>
          <span class="block text-sm text-gray-500 dark:text-neutral-500">last week</span>
        </dd>
      </dl>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
      <div class="inline-flex justify-center items-center">
        <span class="size-2 inline-block bg-green-500 rounded-full me-2"></span>
        <span class="text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400">Topics</span>
      </div>

      <div class="text-center">
          <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200">
              @if($totalTopics > 0)
                  {{ $totalTopics }} <!-- Display total number of topics -->
              @else
                  0 <!-- Fallback if no topics exist -->
              @endif
          </h3>
      </div>
      <dl class="flex justify-center items-center divide-x divide-gray-200 dark:divide-neutral-800">
        <dt class="pe-3">
          <span class="text-green-600">
            <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
            <span class="inline-block text-sm">
              1.7%
            </span>
          </span>
          <span class="block text-sm text-gray-500 dark:text-neutral-500">change</span>
        </dt>
        <dd class="text-start ps-3">
          <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">5</span>
          <span class="block text-sm text-gray-500 dark:text-neutral-500">last week</span>
        </dd>
      </dl>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
      <div class="inline-flex justify-center items-center">
        <span class="size-2 inline-block bg-green-500 rounded-full me-2"></span>
        <span class="text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400">Users</span>
      </div>

      <div class="text-center">
        <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200">
              @if($totalUsers > 0)
                  {{ $totalUsers }} <!-- Display total number of users -->
              @else
                  0 <!-- Fallback if no users exist -->
              @endif
        </h3>
      </div>

      <dl class="flex justify-center items-center divide-x divide-gray-200 dark:divide-neutral-800">
        <dt class="pe-3">
          <span class="text-red-600">
            <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
            <span class="inline-block text-sm">
              5.6%
            </span>
          </span>
          <span class="block text-sm text-gray-500 dark:text-neutral-500">change</span>
        </dt>
        <dd class="text-start ps-3">
          <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">7</span>
          <span class="block text-sm text-gray-500 dark:text-neutral-500">last week</span>
        </dd>
      </dl>
    </div>
    <!-- End Card -->

  </div>
  <!-- End Grid -->
</div>
<!-- End Card Section -->
      </div>  
      </div>
    </div>
    <!-- End Content -->
  </div>
</div>

<script>
    function scrollToUsers() {
        document.getElementById('users-section').scrollIntoView({ behavior: 'smooth' });
    }
</script>
<!-- End Content -->
<!-- ========== END MAIN CONTENT ========== -->

    
</x-app-layout>