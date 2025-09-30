<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">✏️ Edit Student Academic History</h2>
            <a href="{{ route('student_academic_history.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 text-center bg-green-100">
                    <h3 class="text-lg font-semibold text-green-800">Edit Academic History</h3>
                </div>

                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('student_academic_history.update', $history->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Student</label>
                            <select name="student_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $history->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->student_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Student id -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Student id</label>
                            <select name="student_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $history->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->student_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Academic Year -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Academic Year</label>
                            <select name="academic_year_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Year</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id', $history->academic_year_id) == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Class -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Class</label>
                            <select name="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $history->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Section -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Section</label>
                            <select name="section_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ old('section_id', $history->section_id) == $section->id ? 'selected' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('section_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Roll Number -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Roll Number</label>
                            <input type="number" name="roll_number" value="{{ old('roll_number', $history->roll_number) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('roll_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Promotion Status -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Promotion Status</label>
                            <select name="promotion_status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Status</option>
                                <option value="promoted" {{ old('promotion_status', $history->promotion_status) == 'promoted' ? 'selected' : '' }}>Promoted</option>
                                <option value="failed" {{ old('promotion_status', $history->promotion_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="transferred" {{ old('promotion_status', $history->promotion_status) == 'transferred' ? 'selected' : '' }}>Transferred</option>
                            </select>
                            @error('promotion_status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('student_academic_history.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded text-sm transition shadow-sm">
                                Update
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
