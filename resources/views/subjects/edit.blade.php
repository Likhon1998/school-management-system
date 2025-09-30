<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">✏️ Edit Subject</h2>
            <a href="{{ route('subjects.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 text-center bg-yellow-100">
                    <h3 class="text-lg font-semibold text-yellow-800">Edit Subject</h3>
                </div>

                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('subjects.update', $subject->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Subject Name</label>
                            <input type="text" name="subject_name" value="{{ old('subject_name', $subject->subject_name) }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-yellow-400 focus:outline-none">
                            @error('subject_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Subject Code</label>
                            <input type="text" name="subject_code" value="{{ old('subject_code', $subject->subject_code) }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-yellow-400 focus:outline-none">
                            @error('subject_code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Class</label>
                            <select name="class_id" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-yellow-400 focus:outline-none">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $subject->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Is Compulsory</label>
                            <select name="is_compulsory" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-yellow-400 focus:outline-none">
                                <option value="1" {{ old('is_compulsory', $subject->is_compulsory) == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_compulsory', $subject->is_compulsory) == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('subjects.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded text-sm transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-yellow-600 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded text-sm transition shadow-sm">
                                Update
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
