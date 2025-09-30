<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Mark Student Attendance</h2>
            <a href="{{ route('student_attendance.index') }}" 
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
                    <h3 class="text-lg font-medium text-blue-800">Mark Attendance</h3>
                </div>

                <!-- Form -->
                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('student_attendance.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Student -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Student</label>
                            <select name="student_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->student_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                            <select name="status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Status</option>
                                <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                                <option value="half_day" {{ old('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Remarks</label>
                            <textarea name="remarks" rows="2" 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none"
                                      placeholder="Optional">{{ old('remarks') }}</textarea>
                        </div>

                        <!-- Marked By -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Marked By (Teacher)</label>
                            <select name="marked_by"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('marked_by') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->teacher_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marked_by')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('student_attendance.index') }}"
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
