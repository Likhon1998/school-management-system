<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                Permissions / Edit
            </h2>
            <a href="{{ route('permissions.index') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium px-4 py-2 rounded shadow transition">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 bg-gray-50 flex justify-center min-h-screen">
        <div class="w-full max-w-md">

            <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-200 bg-purple-50">
                    <h3 class="text-lg font-semibold text-purple-800">Edit Permission</h3>
                </div>

                <!-- Form -->
                <div class="px-6 py-6">
                    <form action="{{ route('permissions.update', $OurPermission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-medium mb-1">Permission Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter permission name"
                                   value="{{ old('name', $OurPermission->name) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md shadow transition">
                            Update Permission
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
