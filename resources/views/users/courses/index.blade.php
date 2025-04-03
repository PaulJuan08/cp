<x-app-layout>
@extends('layouts.usersdashboard')


<div class="lg:ps-[260px]">
    <div class="min-h-[75rem] p-4 md:p-8">
        <div id="scrollspy" class="space-y-10 md:space-y-16">
            <div id="courses" class="min-h-[25rem] scroll-mt-24">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Courses</h2>
                
                @if($courses->isEmpty())
                    <div class="bg-blue-100 border border-blue-300 text-blue-700 p-4 rounded-lg">
                        No courses are currently assigned to your role ({{ Auth::user()->role_name }}).
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($courses as $course)
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
                                    {{ $course->course_name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    {{ $course->course_desc }}
                                </p>
                                <a href="{{ route('users.courses.show', $course->id) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    View Course
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>  
        </div>
    </div>
</div>
</x-app-layout>
