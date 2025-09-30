<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Add New User</h2>
            <a href="{{ route('users.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-5xl">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 text-center border-b border-gray-200 bg-green-50">
                    <h3 class="text-lg font-medium text-green-800">Add New User</h3>
                </div>

                <div class="px-6 py-6">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Username -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Username</label>
                                <input type="text" name="username"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                                <input type="email" name="email"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Password</label>
                                <input type="password" name="password"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            </div>
                            <!-- Role -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Role</label>
                                <select name="role" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                    <option value="">Select Role</option>
                                    @foreach(['admin','principal','teacher','student','parent','accountant'] as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- First Name -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">First Name</label>
                                <input type="text" name="first_name"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Last Name</label>
                                <input type="text" name="last_name"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Phone</label>
                                <input type="text" name="phone"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Date of Birth</label>
                                <input type="date" name="date_of_birth"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Address (full width) -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-medium mb-1">Address</label>
                                <textarea name="address" rows="2"
                                          class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none"></textarea>
                                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Gender</label>
                                <select name="gender" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                    <option value="">Select Gender</option>
                                    @foreach(['male','female','other'] as $gender)
                                        <option value="{{ $gender }}">{{ ucfirst($gender) }}</option>
                                    @endforeach
                                </select>
                                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- National ID -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">National ID</label>
                                <input type="text" name="national_id"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('national_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Photo -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-medium mb-1">Photo</label>
                                <input type="file" name="photo"
                                       class="w-full text-sm text-gray-700 border border-gray-300 rounded-md px-3 py-2">
                                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('users.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded text-sm transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded text-sm transition shadow-sm">
                                Save
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
