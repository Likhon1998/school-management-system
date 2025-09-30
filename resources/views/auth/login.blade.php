<x-guest-layout>
    <div class="min-h-screen flex bg-green-50">

        <!-- Left Side: Greeting / Motivation -->
        <div class="w-2/5 bg-green-100 flex flex-col items-center justify-center p-12 text-center">
            <h1 class="text-5xl font-extrabold text-green-800 mb-6">Welcome Back!</h1>
            <p class="text-green-700 text-lg max-w-xs leading-relaxed">
                Manage your academic tasks efficiently, track progress, and collaborate easily with teachers, students, and parents.
            </p>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-3/5 flex items-center justify-center p-12">
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md space-y-5">
                @csrf

                <h2 class="text-4xl font-bold text-gray-800 text-center mb-2">Login</h2>
                <p class="text-gray-500 text-center mb-6">Use your email or username to login</p>

                <!-- Email / Username -->
                <div>
                    <x-input-label for="login" class="flex items-center">
                        <span class="text-red-600 mr-1">*</span> Email or Username
                    </x-input-label>
                    <x-text-input id="login" type="text" name="login" :value="old('login')" required placeholder="Enter email or username" class="w-full border-green-300 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                    <x-input-error :messages="$errors->get('login')" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" class="flex items-center">
                        <span class="text-red-600 mr-1">*</span> Password
                    </x-input-label>
                    <x-text-input id="password" type="password" name="password" required placeholder="Enter your password" class="w-full border-green-300 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mt-2">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-green-700 shadow-sm focus:ring-green-400">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <!-- Forgot Password & Submit -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-green-700 hover:underline transition" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                    <x-primary-button class="px-8 py-2 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-2xl w-full md:w-auto">
                        Login
                    </x-primary-button>
                </div>

                <!-- Optional: Register Link -->
                <p class="text-center text-gray-500 mt-4">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-green-700 hover:underline">Register here</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
