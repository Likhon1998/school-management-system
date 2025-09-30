<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gradient-to-r from-green-100 to-green-50 p-4 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold text-green-800 flex items-center gap-2">🛡️ Create Role</h2>
            <a href="{{ route('roles.index') }}" 
               class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-md transition">
               ← Back to Roles
            </a>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-10 px-4 flex justify-center">
        <div class="w-full max-w-4xl">

            <!-- Success / Error Messages -->
            <x-message></x-message>

            <!-- Form Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
                
                <div class="p-6 space-y-6">
                    <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Role Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Role Name"
                                   value="{{ old('name') }}"
                                   class="w-full md:w-1/2 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Permissions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Permissions</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                @foreach($permissions as $permission)
                                    <label class="inline-flex items-center gap-2 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs cursor-pointer hover:bg-green-200 transition">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                               class="text-green-600 rounded focus:ring-green-500"
                                               @if(old('permissions') && in_array($permission->name, old('permissions'))) checked @endif>
                                        {{ ucfirst($permission->name) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-start gap-4 pt-4">
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition">
                                Save
                            </button>
                            <a href="{{ route('roles.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium px-5 py-2 rounded-lg shadow-md transition">
                               Cancel
                            </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
