<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registrationForm">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contact -->
        <div class="mt-4">
            <x-input-label for="contact" :value="__('Contact')" />
            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')" required />
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role_name" :value="__('Role')" />
            <select id="role_name" name="role_name" class="block mt-1 w-full" required onchange="toggleFields()">
                <option value="">Select Role</option>
                <!-- <option value="Admin">Admin</option> -->
                <option value="Faculty">Faculty</option>
                <option value="Staff">Staff</option>
                <option value="Student">Student</option>
                <option value="Others">Others</option>
            </select>
            <x-input-error :messages="$errors->get('role_name')" class="mt-2" />
        </div>

        <!-- Dynamic Fields -->
        <div id="extraFields" class="mt-4"></div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions Checkbox -->
        <div class="mt-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" required
                           class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-800 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                </div>
                <div class="ms-3">
                    <label for="terms" class="text-sm text-gray-600 dark:text-neutral-300">
                        I agree to the <button type="button" onclick="HSOverlay.open('#terms-modal')" class="text-blue-600 hover:underline dark:text-blue-400">Terms and Conditions</button>
                    </label>
                    <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-neutral-300 dark:hover:text-neutral-100" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4">{{ __('Register') }}</x-primary-button>
        </div>
    </form>

    <!-- Terms and Conditions Modal -->
    <div id="terms-modal" class="hs-overlay hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="relative bg-white dark:bg-neutral-800 rounded-xl shadow-xl max-h-[90vh] overflow-hidden border dark:border-neutral-700">
                <!-- Modal Header -->
                <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        CoursePriva Terms and Conditions
                    </h3>
                    <button type="button" class="size-7 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" data-hs-overlay="#terms-modal">
                        <span class="sr-only">Close</span>
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-4 overflow-y-auto max-h-[60vh]">
                    <div class="text-gray-700 dark:text-neutral-300 space-y-4">
                        <h4 class="font-normal"><span class="font-semibold">Effective Date:</span> {{ date('F j, Y') }}</h4>
                        <p>Welcome to CoursePriva! These Terms and Conditions govern your access to and use of the CoursePriva Learning 
                          Management System (LMS). By accessing or using CoursePriva, you agree to comply with these terms. 
                          If you do not agree, you must not use the platform.</p>
                        
                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">1. Definitions</h4>
                        <p>1.1 "<span class="font-bold">CoursePriva</span>" refers to the Learning Management System provided by Office of Data Privacy, 
                          Central Mindanao University.</p>
                        <p>1.2 "<span class="font-bold">User</span>" refers to any individual accessing or using the platform, including but not limited 
                          to learners, instructors, and administrators.</p>
                        <p>1.3 "<span class="font-bold">Content</span>" includes any materials, such as text, images, videos, or documents, uploaded 
                          or shared on CoursePriva.</p>
                        <p>1.4 "<span class="font-bold">Personal Data</span>" refers to any information that can identify a user, as defined by the 
                          Data Privacy Act of 2012 (RA 10173).</p>  

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">2. User Accounts</h4>
                        <p>2.1 <span class="font-bold">Account Creation</span>: Users must provide accurate and complete information during registration.</p>
                        <p>2.2 <span class="font-bold">Account Security</span>: Users are responsible for maintaining the confidentiality of their login credentials and must 
                          notify CoursePriva immediately of unauthorized access.</p>
                        <p>2.3 <span class="font-bold">Account Termination</span>: CoursePriva reserves the right to suspend or terminate accounts that violate these terms.</p>

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">3. Acceptable Use</h4>
                        <p>3.1 Users agree to use CoursePriva for lawful purposes and in compliance with all applicable laws, including RA 10173.</p>
                        <p>3.2 Prohibited activities include:</p>
                        <ul class="list-disc pl-5 space-y-1">
                          <li>Uploading or sharing harmful, defamatory, or illegal content.</li>
                          <li>Engaging in unauthorized data collection or data scraping.</li>
                          <li>Attempting to disrupt or compromise the platform's security.</li>
                        </ul>

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>
                        
                        <h4 class="font-semibold">4. Content Ownership and Usage</h4>
                        <p>4.1 Users retain ownership of the content they upload to the platform.</p>
                        <p>4.2 By uploading content, users grant CoursePriva a non-exclusive license to use 
                          the material for educational purposes within the platform.</p>
                        <p>4.3 Users must ensure that any content uploaded complies with copyright laws and does not infringe on third-party rights.</p>
                        
                        
                        <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">5. Privacy and Data Protection</h4>
                        <p>5.1 CoursePriva is committed to protecting users' personal data in compliance with RA 10173 (Data Privacy Act of 2012).</p>
                        <p>5.2 <span class="font-bold">Data Collection</span>: CoursePriva collects only necessary personal data for account creation 
                          and platform functionality.</p>
                        <p>5.3 <span class="font-bold">Data Use</span>: Personal data will not be shared with third parties without user consent unless required by law.
                          and platform functionality.</p>  
                        <p>5.4 <span class="font-bold">User Rights</span>: Users may access, update, or request the deletion of their personal data by contacting our support team at dpo@cmu.edu.ph.</p>  
                      
                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">6. Intellectual Property</h4>
                        <p>6.1 The CoursePriva platform and its design, software, and branding are the intellectual property of Office of Data Privacy, Central Mindanao University.</p>
                        <p>6.2 Users may not reproduce, distribute, or modify CoursePriva's proprietary materials without prior written consent.</p>

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">7. Limitation of Liability</h4>
                        <p>7.1 CoursePriva provides the platform "as-is" and does not guarantee uninterrupted or error-free access.</p>
                        <p>7.2 CoursePriva shall not be liable for indirect, incidental, or consequential damages arising from platform use, including data loss or system downtime.</p>

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">8. Modifications to Terms</h4>
                        <p>8.1 CoursePriva reserves the right to update these Terms and Conditions. Users will be notified of changes through the platform or email. Continued use of 
                          CoursePriva constitutes acceptance of updated terms.</p>

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">9. Governing Law</h4>
                        <p>9.1 These Terms and Conditions are governed by the laws of the Republic of the Philippines, including RA 10173 (Data Privacy Act of 2012).</p>

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">10. Contact Information</h4>
                        <p>For questions or concerns regarding these terms, please contact us at:</p>
                        <p><span class="font-bold">Email</span>: dpo@cmu.edu.ph</p>
                        <p><span class="font-bold">Address</span>: Office of Data Privacy, Central Mindanao University, University Town, Musuan, Maramag, Bukidnon, Philippines.</p>  

                          <!-- Horizontal separator line -->
                        <div class="border-t border-gray-300 my-4"></div>

                        <h4 class="font-semibold">Acknowledgment</h4>
                        <p>By using CoursePriva, you acknowledge that you have read, understood, and agreed to these Terms and Conditions.</p>
                    </div>
                </div>
                <!-- Modal Footer with Accept Button -->
                <div class="bg-gray-50 px-4 py-3 border-t dark:border-neutral-700 dark:bg-neutral-700 flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-neutral-600 dark:text-white dark:border-neutral-500 dark:hover:bg-neutral-500" data-hs-overlay="#terms-modal">
                        Close
                    </button>
                    <button type="button" onclick="acceptTerms()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Accept Terms
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle fields based on role (your existing function)
        function toggleFields() {
            let role = document.getElementById('role_name').value;
            let extraFields = document.getElementById('extraFields');
            extraFields.innerHTML = '';

            if (role === "Faculty" || role === "Staff") {
                extraFields.innerHTML += `
                    <div class='mt-4'>
                        <x-input-label for="employeeID" :value="__('Employee ID')" />
                        <x-text-input id="employeeID" class="block mt-1 w-full" type="text" name="employeeID" />
                    </div>
                `;
            }
            if (role === "Faculty") {
                extraFields.innerHTML += `
                    <div class='mt-4'>
                        <x-input-label for="college_department" :value="__('College/Department')" />
                        <x-text-input id="college_department" class="block mt-1 w-full" type="text" name="college_department" />
                    </div>
                `;
            }
            if (role === "Staff") {
                extraFields.innerHTML += `
                    <div class='mt-4'>
                        <x-input-label for="office_unit" :value="__('Office/Unit')" />
                        <x-text-input id="office_unit" class="block mt-1 w-full" type="text" name="office_unit" />
                    </div>
                `;
            }
            if (role === "Student") {
                extraFields.innerHTML += `
                    <div class="mt-4">
                        <x-input-label for="studentID" :value="__('Student ID')" />
                        <x-text-input id="studentID" class="block mt-1 w-full" type="text" name="studentID" required />
                        <x-input-error :messages="$errors->get('studentID')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="college_department" :value="__('College/Department')" />
                        <x-text-input id="college_department" class="block mt-1 w-full" type="text" name="college_department" required />
                        <x-input-error :messages="$errors->get('college_department')" class="mt-2" />
                    </div>
                `;
            }
            if (role === "Others") {
                extraFields.innerHTML += `
                    <div class='mt-4'>
                        <x-input-label for="stake_holder" :value="__('Stakeholder')" />
                        <x-text-input id="stake_holder" class="block mt-1 w-full" type="text" name="stake_holder" />
                    </div>
                `;
            }
        }

        // Accept Terms function
        function acceptTerms() {
            document.getElementById('terms').checked = true;
            HSOverlay.close('#terms-modal');
        }

        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('You must accept the Terms and Conditions to register.');
                HSOverlay.open('#terms-modal');
            }
        });
    </script>
</x-guest-layout>