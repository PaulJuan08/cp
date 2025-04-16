<x-app-layout>
    @extends('layouts.admindashboard')
    <div class="lg:ps-[260px]">
        <div class="min-h-[75rem] p-4 md:p-8 bg-gray-50 dark:bg-neutral-800">
            <!-- Header with improved spacing and design -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">User Details</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">View and manage user information</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Users
                </a>
            </div>

            <!-- User information card with shadow and better spacing -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                <!-- Card header with user role badge -->
                <div class="border-b border-gray-200 dark:border-neutral-700 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- User avatar placeholder -->
                            <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 text-xl font-bold">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                <div class="flex items-center mt-1">
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full 
                                        {{ $user->role_name === 'Admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-100' : 
                                            ($user->role_name === 'Faculty' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' :
                                            ($user->role_name === 'Staff' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' :
                                            ($user->role_name === 'Student' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100' : 
                                            'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100'))) }}">
                                        {{ $user->role_name }}
                                    </span>
                                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">• ID: {{ $user->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="hidden sm:flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-600 dark:text-gray-200 dark:hover:bg-neutral-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </a>
                            <button type="button" onclick="openResetModal({{ $user->id }}, '{{ $user->name }}')" 
                                class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Reset Password
                            </button>
                        </div>
                    </div>
                </div>

                <!-- User information tabs -->
                <div class="border-b border-gray-200 dark:border-neutral-700">
                    <nav class="flex -mb-px">
                        <button onclick="showTab('info')" id="info-tab" class="tab-button text-blue-600 border-blue-500 dark:text-blue-400 dark:border-blue-400 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                            Basic Information
                        </button>
                        <button onclick="showTab('progress')" id="progress-tab" class="tab-button text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-6 border-b-2 border-transparent font-medium text-sm">
                            Learning Progress
                        </button>
                    </nav>
                </div>

                <!-- Basic Information Tab Content -->
                <div id="info-content" class="tab-content p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Basic Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-neutral-700 pb-2">Basic Information</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $user->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Contact</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $user->contact }}</p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Password</label>
                                    <p class="mt-1 text-sm font-mono bg-gray-100 dark:bg-neutral-800 p-2 rounded-md overflow-x-auto">{{ $user->password }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->updated_at }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-neutral-700 pb-2">Additional Information</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @if($user->employeeID)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Employee ID</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $user->employeeID }}</p>
                                </div>
                                @endif

                                @if($user->department)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Department</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->department }}</p>
                                </div>
                                @endif

                                @if($user->office_unit)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Office Unit</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->office_unit }}</p>
                                </div>
                                @endif

                                @if($user->studentID)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Student ID</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $user->studentID }}</p>
                                </div>
                                @endif

                                @if($user->college_department)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">College/Department</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->college_department }}</p>
                                </div>
                                @endif

                                @if($user->stakeholder)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Stakeholder</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->stakeholder }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Tab Content -->
<div id="progress-content" class="tab-content p-6 hidden">
    <!-- Overall Progress Summary -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Learning Progress Summary</h3>
            
            <!-- Date filter dropdown -->
            <div class="relative">
                <select id="time-filter" class="bg-white dark:bg-neutral-800 border border-gray-300 dark:border-neutral-600 rounded-md py-2 pl-3 pr-10 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Time</option>
                    <option value="month">Last Month</option>
                    <option value="week">Last Week</option>
                </select>
            </div>
        </div>
        
        <!-- Progress stats cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Courses completed -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg border border-gray-200 dark:border-neutral-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Courses Completed</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $metrics['completedCourses'] }}/{{ $metrics['totalCourses'] }}
                        </p>
                    </div>
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    @php
                        $coursePercentage = $metrics['totalCourses'] > 0 
                            ? ($metrics['completedCourses'] / $metrics['totalCourses']) * 100 
                            : 0;
                    @endphp
                    <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $coursePercentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ round($coursePercentage) }}% Complete
                    </p>
                </div>
            </div>
            
            <!-- Topics mastered -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg border border-gray-200 dark:border-neutral-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Topics Mastered</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $metrics['completedTopics'] ?? 0 }}/{{ $metrics['totalTopics'] ?? 0 }}
                        </p>
                    </div>
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    
                    @php
                        $topicPercentage = ($metrics['totalTopics'] ?? 0) > 0 
                        ? round((($metrics['completedTopics'] ?? 0) / ($metrics['totalTopics'] ?? 1) * 100))
                        : 0;
                    @endphp

                    <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $topicPercentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ round($topicPercentage) }}% Complete
                    </p>
                </div>
            </div>
            
            
            
            <!-- Time Spent -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg border border-gray-200 dark:border-neutral-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Time Spent</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            @php
                                $totalMinutes = $metrics['totalTimeSpent'] ?? 0;
                                $hours = floor($totalMinutes / 60);
                                $minutes = $totalMinutes % 60;
                                echo "{$hours}h {$minutes}m";
                            @endphp
                        </p>
                    </div>
                    <div class="p-2 bg-amber-100 dark:bg-amber-900 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600 dark:text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Courses Progress -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Progress</h3>
        
        <div class="bg-white dark:bg-neutral-800 rounded-lg border border-gray-200 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead class="bg-gray-50 dark:bg-neutral-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Course Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Progress</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Activity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                        @foreach($courses as $course)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->course_name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $course->topics_count }} Topics • {{ $course->quizzes_count }} Quizzes</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-48">
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-700 dark:text-gray-300 mr-2">{{ $course->progress }}%</span>
                                            <div class="flex-1">
                                                <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                                    <div class="bg-{{ $course->progress == 100 ? 'green' : 'blue' }}-600 h-2 rounded-full" style="width: {{ $course->progress }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if($course->lastActivity)
                                        {{ $course->lastActivity->created_at->format('M d, Y • h:i A') }}
                                    @else
                                        No activity yet
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $course->progress == 100 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 
                                        ($course->progress > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' : 
                                        'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200') }}">
                                        {{ $course->progress == 100 ? 'Completed' : ($course->progress > 0 ? 'In Progress' : 'Not Started') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 dark:bg-neutral-800 px-6 py-3 border-t border-gray-200 dark:border-neutral-700">
                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">View all courses</a>
            </div>
        </div>
    </div>
    
    <!-- Recently Completed Topics -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recently Completed Topics</h3>
            
            <!-- Topics filter dropdown -->
            <div class="relative">
                <select id="topics-filter" class="bg-white dark:bg-neutral-800 border border-gray-300 dark:border-neutral-600 rounded-md py-2 pl-3 pr-10 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="recent">Recently Completed</option>
                    <option value="progress">In Progress</option>
                    <option value="mastered">Mastered</option>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($user->courses as $course)
                @foreach($course->topics as $topic)
                    @php
                        $hasPassed = false;
                        $quizScore = null;
                        $lastAttempt = null;
                        
                        if ($topic->quizzes->isNotEmpty()) {
                            foreach ($topic->quizzes as $quiz) {
                                if ($quiz->attempts->isNotEmpty() && $quiz->attempts->first()->passed) {
                                    $hasPassed = true;
                                    $quizScore = $quiz->attempts->first()->score;
                                    $lastAttempt = $quiz->attempts->first()->created_at;
                                }
                            }
                        } else {
                            $access = $user->topicAccesses()->where('topic_id', $topic->id)->first();
                            if ($access) {
                                $hasPassed = true;
                                $lastAttempt = $access->created_at;
                            }
                        }
                    @endphp
                    
                    @if($hasPassed)
                        <div class="bg-white dark:bg-neutral-800 rounded-lg border border-gray-200 dark:border-neutral-700 p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex justify-between">
                                <div class="flex items-center">
                                    <div class="bg-green-100 dark:bg-green-900 p-2 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $topic->topic_name }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $course->course_name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100">
                                        Completed
                                    </span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $lastAttempt ? $lastAttempt->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            @if($quizScore !== null)
                                <div class="mt-3">
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                        <span>Quiz Score</span>
                                        <span>{{ $quizScore }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-1.5">
                                        <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ $quizScore }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
        
        <div class="mt-4 text-center">
            <button class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                View all topics
            </button>
        </div>
    </div>
</div>

                <!-- Mobile action buttons -->
                <div class="sm:hidden border-t border-gray-200 dark:border-neutral-700 p-4 flex justify-end space-x-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                        class="flex-1 flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit User
                    </a>
                    <button type="button" onclick="openResetModal({{ $user->id }}, '{{ $user->name }}')" 
                        class="flex-1 flex justify-center items-center px-4 py-2 bg-orange-600 text-white rounded-md text-sm font-medium hover:bg-orange-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Reset Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Improved Reset Password Modal -->
    <div id="reset-user-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4 dark:bg-neutral-800 transform transition-all">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Reset Password</h3>
                <button onclick="closeResetModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="flex items-center justify-center mb-4 text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-center" id="reset-confirmation-text">
                    Are you sure you want to reset the password for this user? This action cannot be undone.
                </p>
            </div>
            
            <form id="resetUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeResetModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:border-neutral-600 dark:text-gray-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-orange-600 text-white rounded-md text-sm font-medium hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('text-blue-600', 'border-blue-500', 'dark:text-blue-400', 'dark:border-blue-400');
                button.classList.add('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab button
            document.getElementById(tabName + '-tab').classList.remove('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
            document.getElementById(tabName + '-tab').classList.add('text-blue-600', 'border-blue-500', 'dark:text-blue-400', 'dark:border-blue-400');
        }

        // Reset Password Modal Functions
        function openResetModal(userId, userName) {
            document.getElementById('reset-confirmation-text').textContent = 
                `Are you sure you want to reset the password for ${userName}? This action cannot be undone.`;
            document.getElementById('resetUserForm').action = `/admin/users/${userId}/reset-password`;
            document.getElementById('reset-user-modal').classList.remove('hidden');
            // Add animation classes
            setTimeout(() => {
                document.querySelector('#reset-user-modal > div').classList.add('scale-100');
                document.querySelector('#reset-user-modal > div').classList.remove('scale-95');
            }, 10);
        }

        function closeResetModal() {
            // Add exit animation
            document.querySelector('#reset-user-modal > div').classList.add('scale-95');
            document.querySelector('#reset-user-modal > div').classList.remove('scale-100');
            
            setTimeout(() => {
                document.getElementById('reset-user-modal').classList.add('hidden');
            }, 200);
        }
        
        // Filter change handlers
        document.getElementById('time-filter').addEventListener('change', function() {
            // Here you would typically fetch new data based on the selected filter
            console.log('Time filter changed to:', this.value);
        });
        
        document.getElementById('topics-filter').addEventListener('change', function() {
            // Here you would typically fetch new data based on the selected filter
            console.log('Topics filter changed to:', this.value);
        });
    </script>
</x-app-layout>