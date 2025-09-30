<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">User Profile</h2>
            <a href="{{ route('users.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-10 px-4 bg-gray-50 min-h-[calc(100vh-4rem)] flex justify-center">
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

            <!-- Header -->
            <div class="px-6 py-4 bg-blue-50 border-b border-gray-200 flex items-center gap-4">
                <div class="w-24 h-24">
                    <img 
                        src="{{ $user->profile && $user->profile->photo ? asset('storage/profiles/' . $user->profile->photo) : asset('images/default-avatar.png') }}" 
                        alt="Profile Photo" 
                        class="w-full h-full object-cover rounded-full border border-gray-300 shadow-sm">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $user->profile ? $user->profile->first_name . ' ' . $user->profile->last_name : 'N/A' }}</h1>
                    <p class="text-gray-500 capitalize">{{ $user->role }}</p>
                    <span class="mt-1 inline-block px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ ucfirst($user->status) }}</span>
                </div>
            </div>

            <!-- Details Section -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Username</span>
                        <span class="text-gray-900">{{ $user->username }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Email</span>
                        <span class="text-gray-900">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Phone</span>
                        <span class="text-gray-900">{{ $user->profile ? $user->profile->phone : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Date of Birth</span>
                        <span class="text-gray-900">{{ $user->profile ? $user->profile->date_of_birth : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Gender</span>
                        <span class="text-gray-900">{{ $user->profile ? ucfirst($user->profile->gender) : 'N/A' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">National ID</span>
                        <span class="text-gray-900">{{ $user->profile ? $user->profile->national_id : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Address</span>
                        <span class="text-gray-900">{{ $user->profile ? $user->profile->address : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Created At</span>
                        <span class="text-gray-900">{{ $user->created_at->format('d M, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Role</span>
                        <span class="text-gray-900 capitalize">{{ $user->role }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-600 font-medium">Status</span>
                        <span class="text-gray-900 capitalize">{{ $user->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
