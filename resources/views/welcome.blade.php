<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoursePriva - Transform Your Learning Journey</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- logo -->
    <link rel="icon" href="{{ asset('assets/img/logo_cmu.png') }}?v=1" type="image/png" sizes="128x128">
    <link rel="icon" href="{{ asset('assets/img/ODP-Logo.png') }}?v=1" type="image/png" sizes="128x128">
    

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 fixed w-full z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <img class="h-16 w-auto" src="{{ asset('assets/img/logo_cmu.png') }}" alt="CoursePriva Logo">
                    <img class="h-16 w-auto" src="{{ asset('assets/img/ODP-Logo.png') }}" alt="CoursePriva Logo">
                    <span class="ml-0 text-xl font-bold text-gray-900 dark:text-white">CoursePriva</span>
                </div>

                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400 font-medium">Home</a>
                    <a href="#about" class="text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400 font-medium">About</a>
                    <a href="#contact" class="text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400 font-medium">Contact</a>
                    <a href="#developer" class="text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400 font-medium">Developer</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400 font-medium">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400 font-medium">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition duration-300">Register</a>
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
        <div class="absolute inset-0 bg-gradient-to-br from-green-50 via-white to-yellow-100 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center md:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                        Start your journey with 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-yellow-500">CoursePriva</span>
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 dark:text-gray-300 max-w-2xl">
                        Your Learning, Your Data, Your Control
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition duration-300 shadow-lg shadow-green-500/20">
                            Get started
                            <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Right Content - Illustration -->
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="/assets/img/cmu.jpg" alt="CMU" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
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
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">New Ideas</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Learn from todays information and get ahead of the curve.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

    <!-- About Section -->
    <section id="about" class="py-12 sm:py-16 lg:py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl lg:text-5xl">
                    About CoursePriva
                </h2>
                <p class="mt-4 max-w-3xl mx-auto text-xl text-gray-600 dark:text-gray-300">
                    Empowering learners with cutting-edge knowledge and skills for the modern world.
                </p>
            </div>
            
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2">
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-sm">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Description</h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        CoursePriva is a self-paced advanced Learning Management System (LMS) that ensures compliance with the Data Privacy Act of 2012 and its
                         Implementing Rules and Regulations. It provides mandatory training for employess handling personal information, equipping then with the knowledge 
                         to process data securely and responsibly. CoursePriva also enhances data privacy awareness for students, prepairing them to protect personal information 
                         during internships, on-the-job training, practicum teaching, and clinical exposure. This initiative equips them with essential skills to navigate 
                         the digital world with confidence and responsibility.
                    </p>
                </div>
                
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-sm">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Purpose</h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        CoursePriva aims to ensure compliance with the Data Privacy Act of 2012 by providing structured training for employees and students. It enhances data privacy awareness, 
                        promotes responsible data handling, and mitigates risks associated with data breaches within the university.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl lg:text-5xl">
                    Contact Us
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-300">
                    Have questions? We're here to help!
                </p>
            </div>
            
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Get in Touch</h3>
                    <div class="mt-6 space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-green-600 dark:text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="ml-3 text-base text-gray-600 dark:text-gray-400">
                                dpo@cmu.edu.ph.
                            </p>
                        </div>
                        <!-- <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-green-600 dark:text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <p class="ml-3 text-base text-gray-600 dark:text-gray-400">
                                +1 (555) 123-4567
                            </p>
                        </div> -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-green-600 dark:text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="ml-3 text-base text-gray-600 dark:text-gray-400">
                                Office of Data Privacy, Central Mindanao University, University Town, Musuan,
                                Maramag, Bukidnon, Philippines.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Send Us a Message</h3>
                    <form method="POST" action="{{ route('contact.submit') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                            <textarea id="message" name="message" rows="4" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Developer Section -->
    <section id="developer" class="py-12 sm:py-16 lg:py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl lg:text-5xl">
                    Meet the Developer
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-300">
                    The mind behind CoursePriva
                </p>
            </div>
            
            <div class="mt-12 flex flex-col items-center">
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-sm max-w-2xl text-center">
                    <div class="mx-auto h-32 w-32 rounded-full overflow-hidden border-4 border-green-500">
                        <img src="/assets/img/developer.jpg" alt="Developer" class="h-full w-full object-cover">
                    </div>
                    <h3 class="mt-6 text-2xl font-semibold text-gray-900 dark:text-white">Paul Juan</h3>
                    <p class="text-green-600 dark:text-green-400">Lead Developer</p>
                    
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Paul created CoursePriva to revolutionize online learning. His passion for accessible education and technical expertise come together in this platform.
                    </p>
                    
                    <div class="mt-6 flex justify-center space-x-4">
                        <a href="https://github.com/PaulJuan08" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-green-600 dark:hover:text-green-400">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/x_p_a_ul_x?igsh=MWpjc21kOGVzZDhyNA==" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-green-600 dark:hover:text-green-400">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/in/elishaphat-paul-juan-148930349/" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-green-600 dark:hover:text-green-400">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FOOTER ========== -->
    <!-- <footer class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-green-800 to-yellow-600 p-2 z-30"> -->
    <footer class="fixed bottom-0 left-0 right-0 bg-green-800 p-2 z-30">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="text-white text-sm font-semibold">CoursePriva</span>
                    <span class="text-gray-200 text-xs ml-2">&copy; {{ date('Y') }} All rights reserved.</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    @if($terms = \App\Models\Utility::getPublished('terms'))
                        <a href="#" class="text-white hover:text-yellow-300 text-sm transition" data-hs-overlay="#terms-modal">
                            Terms
                        </a>
                    @endif
                    @if($privacy = \App\Models\Utility::getPublished('privacy'))
                        <a href="#" class="text-white hover:text-yellow-300 text-sm transition" data-hs-overlay="#privacy-modal">
                            Privacy
                        </a>
                    @endif
                    @if($cookies = \App\Models\Utility::getPublished('cookies'))
                        <a href="#" class="text-white hover:text-yellow-300 text-sm transition" data-hs-overlay="#cookies-modal">
                            Cookies
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Terms and Conditions Modal -->
    <div id="terms-modal" class="hs-overlay hidden fixed inset-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#006400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        {{ $terms->title ?? 'Terms and Conditions' }}
                    </h3>
                    <!-- <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#terms-modal">
                        <span class="sr-only">Close</span>
                        <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                        </svg>
                    </button> -->
                </div>
                <div class="p-4 overflow-y-auto">
                    <div class="text-gray-700 dark:text-gray-300 space-y-4">
                        @if($terms)
                            {!! $terms->content !!}
                        @else
                            <p>No terms and conditions available.</p>
                        @endif
                    </div>
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-700">
                    <!-- <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#terms-modal">
                        Close
                    </button> -->
                    <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-green-700 text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-800 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" id="accept-terms">
                        Accept
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacy-modal" class="hs-overlay hidden fixed inset-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#006400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        {{ $privacy->title ?? 'Privacy Policy' }}
                    </h3>
                    <!-- <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#privacy-modal">
                        <span class="sr-only">Close</span>
                        <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                        </svg>
                    </button> -->
                </div>
                <div class="p-4 overflow-y-auto">
                    <div class="text-gray-700 dark:text-gray-300 space-y-4">
                        @if($privacy)
                            {!! $privacy->content !!}
                        @else
                            <p>No privacy policy available.</p>
                        @endif
                    </div>
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-700">
                    <!-- <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#privacy-modal">
                        Close
                    </button> -->
                    <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-green-700 text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-800 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" id="accept-privacy">
                        Accept
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookies Policy Modal -->
    <div id="cookies-modal" class="hs-overlay hidden fixed inset-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#006400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="8" cy="9" r="1"></circle>
                            <circle cx="15" cy="9" r="1"></circle>
                            <path d="M9 15a3 3 0 0 0 6 0"></path>
                        </svg>
                        {{ $cookies->title ?? 'Cookies Policy' }}
                    </h3>
                    <!-- <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#cookies-modal">
                        <span class="sr-only">Close</span>
                        <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                        </svg>
                    </button> -->
                </div>
                <div class="p-4 overflow-y-auto">
                    <div class="text-gray-700 dark:text-gray-300 space-y-4">
                        @if($cookies)
                            {!! $cookies->content !!}
                        @else
                            <p>No cookies policy available.</p>
                        @endif
                    </div>
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-700">
                    <!-- <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#cookies-modal">
                        Close
                    </button> -->
                    <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-green-700 text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-800 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" id="accept-cookies">
                        Accept
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookies Banner - Fixed at bottom, only shown if cookies not accepted -->
    <div id="cookie-banner" class="fixed bottom-14 left-0 right-0 hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow-xl border dark:bg-gray-800 dark:border-gray-700 p-4">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-1">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">We use cookies</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.
                        </p>
                    </div>
                    <div class="flex flex-shrink-0 gap-2">
                        <!-- <button type="button" id="cookie-settings-btn" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#cookies-modal">
                            Cookie Settings
                        </button> -->
                        <button type="button" id="cookie-accept-all" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-green-700 text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-800 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                            Accept All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Cookie Management -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Helper functions for cookie management
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Lax";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
            }
            return null;
        }

        // Check if cookies have been accepted
        function areAllCookiesAccepted() {
            return getCookie('terms_accepted') === 'true' && 
                getCookie('privacy_accepted') === 'true' && 
                getCookie('cookies_accepted') === 'true';
        }
        
        function isCookieAccepted(name) {
            return getCookie(name + '_accepted') === 'true';
        }

        // Get modal elements
        const termsModal = document.getElementById('terms-modal');
        const privacyModal = document.getElementById('privacy-modal');
        const cookiesModal = document.getElementById('cookies-modal');
        const cookieBanner = document.getElementById('cookie-banner');
        
        // Accept buttons
        const acceptTermsBtn = document.getElementById('accept-terms');
        const acceptPrivacyBtn = document.getElementById('accept-privacy');
        const acceptCookiesBtn = document.getElementById('accept-cookies');
        const acceptAllCookiesBtn = document.getElementById('cookie-accept-all');
        const cookieSettingsBtn = document.getElementById('cookie-settings-btn');
        
        // Function to accept a specific policy
        function acceptPolicy(name) {
            setCookie(name + '_accepted', 'true', 365);
        }
        
        // Function to accept all policies
        function acceptAllPolicies() {
            acceptPolicy('terms');
            acceptPolicy('privacy');
            acceptPolicy('cookies');
            
            // Hide cookie banner
            if (cookieBanner) {
                cookieBanner.classList.add('hidden');
            }
        }
        
        // Show cookie banner if any cookie is not accepted
        if (!areAllCookiesAccepted() && cookieBanner) {
            cookieBanner.classList.remove('hidden');
        }
        
        // Show modals in sequence when the page loads if policies are not accepted
        // Wait a bit to let the page load first
        setTimeout(function() {
            if (!isCookieAccepted('terms') && termsModal) {
                // Using Preline's API to show the modal
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.open(termsModal);
                } else {
                    termsModal.classList.remove('hidden');
                }
            }
        }, 1000);
        
        // Handle accept button clicks
        if (acceptTermsBtn) {
            acceptTermsBtn.addEventListener('click', function() {
                acceptPolicy('terms');
                
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close(termsModal);
                } else {
                    termsModal.classList.add('hidden');
                }
                
                // Show privacy modal next if not accepted
                if (!isCookieAccepted('privacy') && privacyModal) {
                    setTimeout(function() {
                        if (typeof HSOverlay !== 'undefined') {
                            HSOverlay.open(privacyModal);
                        } else {
                            privacyModal.classList.remove('hidden');
                        }
                    }, 300);
                }
            });
        }
        
        if (acceptPrivacyBtn) {
            acceptPrivacyBtn.addEventListener('click', function() {
                acceptPolicy('privacy');
                
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close(privacyModal);
                } else {
                    privacyModal.classList.add('hidden');
                }
                
                // Show cookies modal next if not accepted
                if (!isCookieAccepted('cookies') && cookiesModal) {
                    setTimeout(function() {
                        if (typeof HSOverlay !== 'undefined') {
                            HSOverlay.open(cookiesModal);
                        } else {
                            cookiesModal.classList.remove('hidden');
                        }
                    }, 300);
                }
            });
        }
        
        if (acceptCookiesBtn) {
            acceptCookiesBtn.addEventListener('click', function() {
                acceptPolicy('cookies');
                
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close(cookiesModal);
                } else {
                    cookiesModal.classList.add('hidden');
                }
                
                // Hide cookie banner since all cookies are now accepted
                if (cookieBanner) {
                    cookieBanner.classList.add('hidden');
                }
            });
        }
        
        // Accept all cookies button
        if (acceptAllCookiesBtn) {
            acceptAllCookiesBtn.addEventListener('click', function() {
                acceptAllPolicies();
            });
        }
        
        // Cookie settings button
        if (cookieSettingsBtn) {
            cookieSettingsBtn.addEventListener('click', function() {
                if (cookiesModal) {
                    if (typeof HSOverlay !== 'undefined') {
                        HSOverlay.open(cookiesModal);
                    } else {
                        cookiesModal.classList.remove('hidden');
                    }
                }
            });
        }
        
        // Handle clicking on policy links in the footer
        document.querySelectorAll('[data-hs-overlay]').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('data-hs-overlay');
                const modal = document.querySelector(target);
                
                if (modal) {
                    if (typeof HSOverlay !== 'undefined') {
                        HSOverlay.open(modal);
                    } else {
                        modal.classList.remove('hidden');
                    }
                }
            });
        });
        
        // Close buttons in modals
        document.querySelectorAll('[data-hs-overlay="#terms-modal"], [data-hs-overlay="#privacy-modal"], [data-hs-overlay="#cookies-modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-hs-overlay');
                const modal = document.querySelector(modalId);
                
                if (modal) {
                    if (typeof HSOverlay !== 'undefined') {
                        HSOverlay.close(modal);
                    } else {
                        modal.classList.add('hidden');
                    }
                }
            });
        });
        
        // Initialize Preline components if available
        if (typeof HSOverlay !== 'undefined') {
            HSOverlay.autoInit();
        }
    });
    </script>

</body>
</html>