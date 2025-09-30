<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">✏️ Edit User</h2>
            <a href="{{ route('users.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-3xl">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 text-center border-b border-gray-200 bg-green-50">
                    <h3 class="text-lg font-medium text-green-800">Edit User Details</h3>
                </div>

                <div class="px-6 py-6">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @csrf
                        @method('PUT')

                        <!-- Username -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password (optional) -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">New Password (leave blank to keep current)</label>
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
                            <select name="role"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @foreach(['admin','principal','teacher','student','parent','accountant'] as $role)
                                    <option value="{{ $role }}" {{ old('role', $user->role)==$role?'selected':'' }}>{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                            @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                            <select name="status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="active" {{ old('status', $user->status)=='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status)=='inactive'?'selected':'' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- First Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->profile->first_name ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->profile->last_name ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->profile->date_of_birth ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Gender</label>
                            <select name="gender"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @foreach(['male','female','other'] as $gender)
                                    <option value="{{ $gender }}" {{ old('gender', $user->profile->gender ?? '')==$gender?'selected':'' }}>{{ ucfirst($gender) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- National ID -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">National ID</label>
                            <input type="text" name="national_id" value="{{ old('national_id', $user->profile->national_id ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                        </div>

                        <!-- Address -->
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-medium mb-1">Address</label>
                            <textarea name="address" rows="2"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">{{ old('address', $user->profile->address ?? '') }}</textarea>
                        </div>

                        <!-- Photo -->
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-medium mb-1">Photo</label>
                            <input type="file" name="photo"
                                   class="w-full text-sm text-gray-700 border border-gray-300 rounded-md px-3 py-2">
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-span-2 flex justify-end gap-3 mt-4">
                            <a href="{{ route('users.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded text-sm transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded text-sm transition shadow-sm">
                                Update
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
