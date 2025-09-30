<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">➕ Add Section</h2>
            <a href="{{ route('sections.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 text-center bg-green-100">
                    <h3 class="text-lg font-semibold text-green-800">Add New Section</h3>
                </div>

                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('sections.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Class Select -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Class</label>
                            <select name="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Section Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Section Name</label>
                            <input type="text" name="section_name" value="{{ old('section_name') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('section_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Capacity</label>
                            <input type="number" name="capacity" value="{{ old('capacity') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('capacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Room Number -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Room Number</label>
                            <input type="text" name="room_number" value="{{ old('room_number') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('room_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('sections.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded text-sm transition shadow-sm">
                                Save
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
