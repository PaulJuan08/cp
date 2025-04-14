<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoursePriva - Transform Your Learning Journey</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 fixed w-full z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <svg class="h-8 w-auto text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 24C18.6274 24 24 18.6274 24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24Z" fill="currentColor"/>
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="white"/>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900 dark:text-white">CoursePriva</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- <a href="#" class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Features</a>
                    <a href="#" class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Courses</a>
                    <a href="#" class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Pricing</a>
                    <a href="#" class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">About</a> -->
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition duration-300">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-24 pb-12 sm:pt-32 sm:pb-16 lg:pt-40 lg:pb-20">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-blue-100 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center md:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                        Start your journey with 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-400">CoursePriva</span>
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 dark:text-gray-300 max-w-2xl">
                        Hand-picked professionals and expertly crafted components, designed for any kind of entrepreneur.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-300 shadow-lg shadow-indigo-500/20">
                            Get started
                            <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="#" class="px-8 py-3 bg-white text-gray-900 font-medium rounded-lg hover:bg-gray-50 transition duration-300 shadow-lg shadow-gray-500/10 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                            Contact sales team
                        </a>
                    </div>
                </div>
                
                <!-- Right Content - Illustration -->
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80" alt="Learning illustration" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <!-- <h3 class="text-xl font-bold">Join 50,000+ learners</h3>
                            <p class="mt-1 text-sm opacity-90">Start your free trial today</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl lg:text-5xl">
                    Everything you need to succeed
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-300">
                    Our platform provides all the tools for your learning journey
                </p>
            </div>
            
            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Expert Instructors</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Learn from industry professionals with years of experience in their fields.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Comprehensive Curriculum</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Structured learning paths designed to take you from beginner to expert.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Flexible Scheduling</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Learn at your own pace with 24/7 access to all course materials.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Column 1 -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">Product</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Features</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Pricing</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Courses</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Updates</a></li>
                    </ul>
                </div>
                
                <!-- Column 2 -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">Company</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Careers</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Blog</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Press</a></li>
                    </ul>
                </div>
                
                <!-- Column 3 -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">Resources</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Documentation</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Community</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Webinars</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Support</a></li>
                    </ul>
                </div>
                
                <!-- Column 4 -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">Legal</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Privacy</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Terms</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Cookie Policy</a></li>
                        <li><a href="#" class="text-base text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Licenses</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800 flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center">
                    <svg class="h-6 w-auto text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 24C18.6274 24 24 18.6274 24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24Z" fill="currentColor"/>
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="white"/>
                    </svg>
                    <span class="ml-2 text-lg font-bold text-gray-900 dark:text-white">CoursePriva</span>
                </div>
                <p class="mt-4 md:mt-0 text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} CoursePriva. All rights reserved.
                    <span class="block md:inline mt-1 md:mt-0 md:ml-4">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</span>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>