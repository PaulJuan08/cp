<x-app-layout>
    @extends('layouts.usersdashboard')

    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8">
            <div class="space-y-10 md:space-y-16">
                <!-- Available Courses Section (combines assigned and available) -->
                <div id="available-courses" class="scroll-mt-24">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Available Courses for Your Role ({{ $userRole }})
                        </h2>
                        @if($enrolledCourses->isNotEmpty())
                            <a href="#enrolled-courses" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                View My Enrolled Courses
                            </a>
                        @endif
                    </div>
                    
                    @if($availableCourses->isEmpty())
                        <div class="bg-blue-100 border border-blue-300 text-blue-700 p-4 rounded-lg">
                            No courses available for enrollment at this time.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($availableCourses as $course)
                                @include('users.courses.partials.course-card', [
                                    'course' => $course,
                                    'isAssigned' => true,
                                    'isEnrolled' => $enrolledCourses->contains($course->id)
                                ])
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Enrolled Courses Section -->
                @if($enrolledCourses->isNotEmpty())
                <div id="enrolled-courses" class="scroll-mt-24">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">My Enrolled Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($enrolledCourses as $course)
                            @include('users.courses.partials.course-card', [
                                'course' => $course,
                                'isAssigned' => $assignedCourses->contains($course->id),
                                'isEnrolled' => true
                            ])
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>