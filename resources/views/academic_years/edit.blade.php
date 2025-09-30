<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">📅 Edit Academic Year</h2>
            <a href="{{ route('academic_years.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                <!-- Card Header with soft color -->
                <div class="px-6 py-4 text-center border-b border-gray-200 bg-green-50">
                    <h3 class="text-lg font-medium text-green-800">Edit Academic Year</h3>
                </div>

                <!-- Form Section -->
                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('academic_years.update', $academicYear->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Year Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Year Name</label>
                            <input type="text" 
                                   name="year_name" 
                                   value="{{ old('year_name', $academicYear->year_name) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('year_name') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Start Date</label>
                                <input type="date" 
                                       name="start_date" 
                                       value="{{ old('start_date', $academicYear->start_date) }}"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('start_date') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">End Date</label>
                                <input type="date" 
                                       name="end_date" 
                                       value="{{ old('end_date', $academicYear->end_date) }}"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                @error('end_date') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                            <select name="status" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="active" {{ old('status', $academicYear->status)=='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ old('status', $academicYear->status)=='inactive'?'selected':'' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('academic_years.index') }}" 
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
