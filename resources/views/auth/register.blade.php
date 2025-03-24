<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
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
                <option value="Admin">Admin</option>
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

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4">{{ __('Register') }}</x-primary-button>
        </div>
    </form>

    <!-- JavaScript to Toggle Fields Based on Role -->
    <script>
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
    </script>
</x-guest-layout>
