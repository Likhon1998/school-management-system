<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Assign Teacher Subject</h2>
            <a href="{{ route('teacher_subjects.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-4rem)] flex items-start justify-center bg-gray-50 py-10 px-4">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                <div class="px-6 py-4 text-center border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-medium text-blue-800">Assign Teacher Subject</h3>
                </div>

                <div class="px-6 py-6 space-y-4" x-data="teacherForm()">
                    <form action="{{ route('teacher_subjects.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Teacher ID -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Teacher ID</label>
                            <select name="teacher_id" x-model="teacher_id" @change="updateTeacherName"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Teacher ID</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" data-name="{{ $teacher->teacher_name }}">
                                        {{ $teacher->id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teacher Name (auto-fill) -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Teacher Name</label>
                            <input type="text" name="teacher_name" x-model="teacher_name"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-gray-100" readonly>
                            @error('teacher_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Subject</label>
                            <select name="subject_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Class -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Class</label>
                            <select name="class_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
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
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                            @error('section_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Academic Year -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Academic Year</label>
                            <select name="academic_year_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Academic Year</option>
                                @foreach($academic_years as $year)
                                    <option value="{{ $year->id }}">{{ $year->year_name }}</option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('teacher_subjects.index') }}"
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

    <script>
        function teacherForm() {
            return {
                teacher_id: '',
                teacher_name: '',
                updateTeacherName() {
                    const select = document.querySelector('select[name="teacher_id"]');
                    const option = select.options[select.selectedIndex];
                    this.teacher_name = option.dataset.name || '';
                }
            }
        }
    </script>
</x-app-layout>
