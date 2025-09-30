<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-green-50">

        <!-- Main Content -->
        <main class="flex flex-1 w-full h-screen">

            <!-- Left Side: Motivation (Optional, can be blank or simple image) -->
            <div class="w-2/5 bg-green-100 flex flex-col items-center justify-center p-12 text-center">
                <h1 class="text-5xl font-extrabold text-green-800 mb-6">Reset Password</h1>
            </div>

            <!-- Right Side: Reset Form -->
            <div class="w-3/5 flex items-center justify-center p-12 overflow-hidden">
                <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-xl space-y-5">
                    @csrf

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" class="flex items-center">
                            <span class="text-red-600 mr-1">*</span> Email
                        </x-input-label>
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            placeholder="Enter your email"
                            class="w-full border-green-300 focus:ring-green-400 focus:border-green-400 placeholder-green-400"/>
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    <!-- Submit & Back to Login -->
                    <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                        <a class="text-sm text-green-700 hover:underline transition" href="{{ route('login') }}">
                            Back to Login
                        </a>
                        <x-primary-button class="px-8 py-2 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-2xl w-full md:w-auto">
                            Send Reset Link
                        </x-primary-button>
                    </div>

                </form>
            </div>

        </main>
    </div>
</x-guest-layout>
