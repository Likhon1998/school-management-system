<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Add Student Academic History</h2>
            <a href="{{ route('student_academic_history.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                <!-- Card Header -->
                <div class="px-6 py-4 text-center border-b border-gray-200 bg-green-50">
                    <h3 class="text-lg font-medium text-green-800">Add New Academic History</h3>
                </div>

                <!-- Form Section -->
                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('student_academic_history.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Student ID -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Student ID</label>
                            <select id="student_id" name="student_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Student ID</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->student_id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Student Name (auto-filled) -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Student Name</label>
                            <input type="text" id="student_name" name="student_name"
                                   value="{{ old('student_name') }}"
                                   placeholder="Auto-filled from Student ID"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none bg-gray-100"
                                   readonly>
                            @error('student_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Academic Year -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Academic Year</label>
                            <select name="academic_year_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
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

                        <!-- Class -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Class</label>
                            <select name="class_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Section -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Section</label>
                            <select name="section_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('section_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Roll Number -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Roll Number</label>
                            <input type="number" name="roll_number" value="{{ old('roll_number') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                            @error('roll_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Promotion Status -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Promotion Status</label>
                            <select name="promotion_status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-green-400 focus:outline-none">
                                <option value="">Select Status</option>
                                <option value="promoted" {{ old('promotion_status') == 'promoted' ? 'selected' : '' }}>Promoted</option>
                                <option value="failed" {{ old('promotion_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="transferred" {{ old('promotion_status') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                            </select>
                            @error('promotion_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('student_academic_history.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded text-sm transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded text-sm transition shadow-sm">
                                Save
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Student Auto-fill Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentsMap = @json($students->pluck('student_name', 'id'));
            const studentSelect = document.getElementById('student_id');
            const studentNameInput = document.getElementById('student_name');

            function updateStudentName() {
                const id = studentSelect.value;
                studentNameInput.value = studentsMap[id] || '';
            }

            studentSelect.addEventListener('change', updateStudentName);
            updateStudentName(); // fill on page load if old value exists
        });
    </script>
</x-app-layout>
