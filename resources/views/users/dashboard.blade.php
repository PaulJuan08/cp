<x-app-layout>
    @extends('layouts.usersdashboard')
    
    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Dashboard</h2>
            
            <!-- Welcome Card -->
            <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <h3 class="text-lg font-semibold">Welcome back, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            @if(auth()->user()->role_name === 'Student')
                                You're enrolled in {{ $userCourses->count() }} courses
                            @else
                                You have access to {{ $userCourses->count() }} courses
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Course Progress Section -->
            <div class="max-w-[85rem] px-4 pb-10 sm:px-6 lg:px-8 mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        @if(auth()->user()->role_name === 'Student')
                            My Course Progress
                        @else
                            Assigned Courses
                        @endif
                    </h3>
                    <a href="{{ route('users.courses.index') }}" class="text-sm text-blue-600 hover:underline">
                        View All Courses
                    </a>
                </div>
                
                @if($userCourses->isEmpty())
                    <div class="bg-white p-6 rounded-lg shadow-md text-center dark:bg-gray-800">
                        <p class="text-gray-600 dark:text-gray-300">
                            @if(auth()->user()->role_name === 'Student')
                                You haven't enrolled in any courses yet.
                            @else
                                No courses assigned to you yet.
                            @endif
                        </p>
                        <a href="{{ route('users.courses.index') }}" class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Browse Courses
                        </a>
                    </div>
                @else
                    <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($userCourses as $course)
                            @php
                                $progressPercent = $course->progressForUser(Auth::user());
                                $completedTopics = $course->topics->filter(function($topic) {
                                    return Auth::user()->hasCompletedTopic($topic) && 
                                           Auth::user()->hasPassedQuiz($topic->id);
                                })->count();
                                $totalTopics = $course->topics->count();
                            @endphp
                            
                            <div class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-800 hover:shadow-lg transition-shadow">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-800 dark:text-white">{{ $course->course_name }}</h4>
                                        <span class="text-xs text-gray-500">{{ ucfirst($course->user_role) }}</span>
                                    </div>
                                    <span class="text-sm font-medium {{ $progressPercent == 100 ? 'text-green-600' : 'text-blue-600' }}">
                                        {{ $progressPercent }}% Complete
                                    </span>
                                </div>
                                
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                                    <div class="h-2.5 rounded-full {{ $progressPercent == 100 ? 'bg-green-600' : 'bg-blue-600' }}" 
                                        style="width: {{ $progressPercent }}%">
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                    {{ $course->course_desc }}
                                </p>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        {{ $completedTopics }} of {{ $totalTopics }} topics completed
                                    </span>
                                    
                                    <a href="{{ route('users.courses.show', $course->id) }}" 
                                       class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                        @if($progressPercent == 100)
                                            Review Course
                                        @else
                                            @if(auth()->user()->role_name === 'Student')
                                                Continue Learning
                                            @else
                                                View Course
                                            @endif
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>