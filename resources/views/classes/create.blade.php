<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">➕ Add Class</h2>
            <a href="{{ route('classes.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 text-center bg-green-100">
                    <h3 class="text-lg font-semibold text-green-800">Add New Class</h3>
                </div>

                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Class Name</label>
                            <input type="text" name="class_name" value="{{ old('class_name') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('class_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Numeric Value</label>
                            <input type="number" name="class_numeric" value="{{ old('class_numeric') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="active" {{ old('status')=='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('classes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">Cancel</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded text-sm">Save</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
