<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Add New Examination</h2>
            <a href="{{ route('examinations.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                <!-- Card Header -->
                <div class="px-6 py-4 text-center border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-medium text-blue-800">Add Examination</h3>
                </div>

                <!-- Form -->
                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('examinations.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Exam Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Exam Name</label>
                            <input type="text" name="exam_name" value="{{ old('exam_name') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none"
                                   placeholder="Enter exam name">
                            @error('exam_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Exam Type -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Exam Type</label>
                            <select name="exam_type" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Exam Type</option>
                                <option value="test" {{ old('exam_type') == 'test' ? 'selected' : '' }}>Test</option>
                                <option value="half_yearly" {{ old('exam_type') == 'half_yearly' ? 'selected' : '' }}>Half Yearly</option>
                                <option value="annual" {{ old('exam_type') == 'annual' ? 'selected' : '' }}>Annual</option>
                            </select>
                            @error('exam_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Academic Year -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Academic Year</label>
                            <select name="academic_year_id" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Academic Year</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Start Date</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            @error('start_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">End Date</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            @error('end_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                            <select name="status" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Status</option>
                                <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('examinations.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded text-sm transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded text-sm transition shadow-sm">
                                Save
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
