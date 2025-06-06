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
                            <button type="button" onclick="openResetModal('{{ Crypt::encrypt($user->id) }}', '{{ $user->name }}')" 
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
                                    <p class="mt-1 text-sm font-mono bg-gray-100 dark:bg-neutral-800 p-2 rounded-md overflow-x-auto">••••••••••••</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-neutral-700 pb-2">Additional Information</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @if($user->employee_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Employee ID</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $user->employee_id }}</p>
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

                                @if($user->student_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Student ID</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $user->student_id }}</p>
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
                            
                            <!-- Quiz Score -->
                            <div class="bg-white dark:bg-neutral-800 rounded-lg border border-gray-200 dark:border-neutral-700 p-4 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Quiz Score</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ $metrics['avgQuizScore'] }}%
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $metrics['totalCorrectAnswers'] ?? 0 }}/{{ $metrics['totalQuestions'] ?? 0 }} correct answers
                                        </p>
                                    </div>
                                    <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $metrics['avgQuizScore'] }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Based on {{ $metrics['completedTopics'] }} topics ({{ $metrics['totalQuestions'] }} questions)
                                    </p>
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
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
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
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">• {{ $course->topics_count }} Topics</div>
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
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $course->progress == 100 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 
                                                        ($course->progress > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' : 
                                                        'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200') }}">
                                                        {{ $course->progress == 100 ? 'Completed' : ($course->progress > 0 ? 'In Progress' : 'Not Started') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($course->progress == 100)
                                                        <a href="{{ route('admin.users.certificate.print', [
                                                            'encryptedUser' => Crypt::encrypt($user->id),
                                                            'encryptedCourse' => Crypt::encrypt($course->id)
                                                        ]) }}" 
                                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                            </svg>
                                                            Print Certificate
                                                        </a>
                                                    @else
                                                        <span class="text-gray-500 dark:text-gray-400 text-sm">Not yet completed</span>
                                                    @endif
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

                    <!-- Certificate Modal -->
                    <div id="certificate-modal" class="hs-overlay hidden size-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                            <!-- Backdrop -->
                            <div class="fixed inset-0 bg-gray-900/50 dark:bg-neutral-950/50"></div>
                            
                            <!-- Modal Content -->
                            <div class="flex items-center justify-center min-h-screen">
                                <div class="relative bg-white dark:bg-neutral-800 rounded-xl shadow-xl w-full max-h-[90vh] overflow-hidden border dark:border-neutral-700">
                                    <!-- Modal Header -->
                                    <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                            Certificate Status
                                        </h3>
                                        @if(isset($course) && $course)
                                            <button type="button" 
                                                    onclick="checkCertificateStatus({{ $course->id }}, {{ $course->progress }})"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Print Certificate
                                            </button>
                                        @else
                                            <button type="button" 
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-gray-400 cursor-not-allowed dark:bg-gray-600"
                                                    disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                No Certificate Available
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <!-- Modal Body -->
                                    <div class="p-4 overflow-y-auto max-h-[60vh]">
                                        <div id="certificate-message" class="text-gray-700 dark:text-neutral-300 space-y-4">
                                            <!-- Message will be inserted here -->
                                        </div>
                                    </div>
                                    
                                    <!-- Modal Footer -->
                                    <div class="p-4 border-t dark:border-neutral-700 flex justify-end">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-hs-overlay="#certificate-modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recently Completed Topics -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recently Completed Topics</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($recentTopics as $topic)
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
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100">
                                                Completed
                                            </span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $topic->pivot->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400">No recently completed topics found</p>
                                </div>
                            @endforelse
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
                    <a href="{{ route('admin.users.edit', Crypt::encrypt($user->id)) }}" 
                        class="flex-1 flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit User
                    </a>
                    <button type="button" onclick="openResetModal('{{ Crypt::encrypt($user->id) }}', '{{ $user->name }}')" 
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
                    Are you sure you want to reset the password for this user? A new secure password will be generated and emailed to them.
                </p>
                <div id="reset-success-message" class="hidden mt-4 p-3 bg-green-50 rounded-md dark:bg-green-900/30">
                    <p class="text-sm text-green-700 dark:text-green-300 text-center"></p>
                </div>
            </div>
            
            <form id="resetUserForm" method="POST">
                @csrf
                <input type="hidden" id="resetUserId" name="user_id">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeResetModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:border-neutral-600 dark:text-gray-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit" id="resetSubmitBtn"
                        class="px-4 py-2 bg-orange-600 text-white rounded-md text-sm font-medium hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize variables at the top
        let currentResetUser = null;

        // Password generator function
        function generateStrongPassword() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
            let password = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }
            return password;
        }

        // Reset modal functions
        function openResetModal(userId, userName) {
            currentResetUser = { 
                id: userId, 
                name: userName 
            };
            
            document.getElementById('reset-confirmation-text').textContent = 
                `Are you sure you want to reset the password for ${userName}? A new secure password will be generated and emailed to them.`;
            document.getElementById('resetUserId').value = userId;
            document.getElementById('reset-success-message').classList.add('hidden');
            document.getElementById('reset-user-modal').classList.remove('hidden');
        }

        function closeResetModal() {
            document.getElementById('reset-user-modal').classList.add('hidden');
            currentResetUser = null;
        }

        // Form submission handler
        document.addEventListener('DOMContentLoaded', function () {
            const resetForm = document.getElementById('resetUserForm');

            if (resetForm) {
                resetForm.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    if (!currentResetUser) {
                        console.error('No user selected for password reset');
                        return;
                    }

                    const submitBtn = document.getElementById('resetSubmitBtn');
                    const originalBtnText = submitBtn.innerHTML;
                    const successMessage = document.getElementById('reset-success-message');

                    // Generate a strong password
                    const newPassword = generateStrongPassword();

                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Resetting...
                    `;

                    try {
                        // Construct the URL dynamically
                        const resetUrl = `/admin/users/${currentResetUser.id}/reset-password`;

                        const response = await fetch(resetUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                password: newPassword
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Failed to reset password');
                        }

                        // Show success message
                        successMessage.querySelector('p').textContent =
                            `Password reset successfully! A new password has been emailed to ${currentResetUser.name}.`;
                        successMessage.classList.remove('hidden');

                        // Close modal after delay
                        setTimeout(() => {
                            closeResetModal();
                        }, 3000);

                    } catch (error) {
                        console.error('Error:', error);
                        alert(`Error: ${error.message}`);
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                });
            }
        });

        // Make functions available globally for button onclick handlers
        window.openResetModal = openResetModal;
        window.closeResetModal = closeResetModal;

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
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.print-certificate').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                
                const button = this;
                const originalText = button.innerHTML;
                
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
                
                try {
                    const response = await fetch(button.href, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    if (response.ok) {
                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `certificate-${button.dataset.courseId}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    } else {
                        const error = await response.json();
                        throw new Error(error.message);
                    }
                } catch (error) {
                    // Show error in modal instead of alert
                    const modal = document.getElementById('certificate-modal');
                    const messageDiv = document.getElementById('certificate-message');
                    
                    messageDiv.innerHTML = `
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-2">Certificate Error</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                ${error.message}
                            </p>
                        </div>
                    `;
                    
                    const modalInstance = HSOverlay.getInstance(modal);
                    modalInstance.open();
                } finally {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            });
        });
    });
    </script>
</x-app-layout>