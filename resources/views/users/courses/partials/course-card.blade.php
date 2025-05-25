<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col h-full">
    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
        {{ $course->course_name }}
        @if($isAssigned ?? false)
            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded ml-2">Assigned</span>
        @endif
        @if($isEnrolled ?? false)
            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded ml-2">Enrolled</span>
        @endif
    </h3>
     
    <p class="text-gray-600 dark:text-gray-400 mb-4 flex-grow">
        {{ Str::limit($course->course_desc, 120) }}
    </p>
     
    <div class="flex space-x-2">
        @if($isEnrolled ?? false)
            <a href="{{ route('users.courses.show', encrypt($course->id)) }}"
                class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                View
            </a>
        @endif
                 
        @if(!($isEnrolled ?? false))
            <form action="{{ route('users.courses.enroll', encrypt($course->id)) }}" method="POST">
                @csrf
                <button type="submit"
                         class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Enroll
                </button>
            </form>
        @elseif(!($isAssigned ?? false))
            <form action="{{ route('users.courses.unenroll', encrypt($course->id)) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                         class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Unenroll
                </button>
            </form>
        @endif
    </div>
</div>