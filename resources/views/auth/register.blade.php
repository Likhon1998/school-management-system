<x-guest-layout>
    <div class="min-h-screen flex bg-green-50">

        <!-- Left Panel: Motivation -->
        <div class="w-2/5 bg-green-100 flex flex-col items-center justify-center p-12 text-center">
            <h1 class="text-5xl font-extrabold text-green-800 mb-4">Hello!</h1>
            <p class="text-green-700 text-lg max-w-xs leading-relaxed">
                Welcome to the School Management System.<br>
                Manage academic tasks efficiently, track progress, and collaborate easily with teachers, students, and parents.
            </p>
        </div>

        <!-- Right Panel: Registration Form -->
        <div class="w-3/5 flex flex-col items-center justify-center p-12">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="w-full max-w-xl space-y-6 bg-green-50">
                @csrf

                <h2 class="text-4xl font-bold text-gray-800 text-center mb-2">Create Your Account</h2>
                <p class="text-gray-500 text-center mb-6">Fill in your details to register</p>

                <!-- Email -->
                <div>
                    <x-input-label for="email" class="flex items-center">
                        <span class="text-red-600 mr-1">*</span>Email
                    </x-input-label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required placeholder="Enter your email" 
                        class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Username -->
                <div>
                    <x-input-label for="username" class="flex items-center">
                        <span class="text-red-600 mr-1">*</span>Username
                    </x-input-label>
                    <x-text-input id="username" type="text" name="username" :value="old('username')" required placeholder="Suggested from email" 
                        class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                    <x-input-error :messages="$errors->get('username')" />
                    <p class="text-sm text-gray-500 mt-1">Username will be suggested based on your email.</p>
                </div>

                <!-- Password & Confirm Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="password" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Password
                        </x-input-label>
                        <x-text-input id="password" type="password" name="password" required placeholder="Enter password" 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Confirm Password
                        </x-input-label>
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm password" 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>

                <!-- Role & Gender -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="role" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Role
                        </x-input-label>
                        <select id="role" name="role" class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400">
                            <option value="">Select Role</option>
                            <option value="principal">Principal</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                            <option value="parent">Parent</option>
                            <option value="accountant">Accountant</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" />
                    </div>
                    <div>
                        <x-input-label for="gender" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Gender
                        </x-input-label>
                        <select id="gender" name="gender" class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" />
                    </div>
                </div>

                <!-- Names -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="first_name" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>First Name
                        </x-input-label>
                        <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required placeholder="Enter first name" 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('first_name')" />
                    </div>
                    <div>
                        <x-input-label for="last_name" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Last Name
                        </x-input-label>
                        <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required placeholder="Enter last name" 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('last_name')" />
                    </div>
                </div>

                <!-- Phone & National ID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="phone" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Phone
                        </x-input-label>
                        <x-text-input id="phone" type="text" name="phone" :value="old('phone')" required placeholder="Enter phone number" 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>
                    <div>
                        <x-input-label for="national_id" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>National ID
                        </x-input-label>
                        <x-text-input id="national_id" type="text" name="national_id" :value="old('national_id')" required placeholder="Enter national ID" 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('national_id')" />
                    </div>
                </div>

                <!-- Address & Date of Birth -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="address" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Address
                        </x-input-label>
                        <x-text-input id="address" type="text" name="address" :value="old('address')" required placeholder="Enter address" 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                    <div>
                        <x-input-label for="date_of_birth" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span>Date of Birth
                        </x-input-label>
                        <x-text-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth')" required 
                            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('date_of_birth')" />
                    </div>
                </div>

                <!-- Profile Photo -->
                <div class="flex items-center gap-4">
                    <label class="cursor-pointer bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition">
                        Upload Photo
                        <input type="file" name="photo" id="photo" class="hidden" onchange="displayFileName()">
                    </label>
                    <span id="file-name" class="text-gray-600">No file chosen</span>
                </div>

                <!-- Submit & Login Link -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-4">
                    <a class="text-sm text-green-700 hover:underline transition" href="{{ route('login') }}">
                        Already registered? Login
                    </a>
                    <x-primary-button class="px-8 py-2 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-2xl w-full md:w-auto">
                        Register
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Auto-suggest username from email
        const emailInput = document.getElementById('email');
        const usernameInput = document.getElementById('username');
        emailInput.addEventListener('input', function() {
            if (!usernameInput.dataset.touched) {
                usernameInput.value = this.value.split('@')[0];
            }
        });
        usernameInput.addEventListener('input', function() {
            this.dataset.touched = true;
        });

        // Show selected file name
        function displayFileName() {
            const fileInput = document.getElementById('photo');
            const fileNameSpan = document.getElementById('file-name');
            if (fileInput.files.length > 0) {
                fileNameSpan.textContent = fileInput.files[0].name;
            } else {
                fileNameSpan.textContent = 'No file chosen';
            }
        }
    </script>
</x-guest-layout>
