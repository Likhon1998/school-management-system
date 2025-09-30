<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Add Exam Result</h2>
            <a href="{{ route('exam_results.index') }}" 
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
                    <h3 class="text-lg font-medium text-blue-800">Add Exam Result</h3>
                </div>

                <!-- Form -->
                <div class="px-6 py-6 space-y-4">
                    <form action="{{ route('exam_results.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Student -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Student</label>
                            <select name="student_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->student_name }} ({{ $student->student_id }})</option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Examination -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Examination</label>
                            <select name="examination_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                                <option value="">Select Examination</option>
                                @foreach($examinations as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->exam_name }} ({{ ucfirst($exam->exam_type) }})</option>
                                @endforeach
                            </select>
                            @error('examination_id')
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

                        <!-- Obtained Marks -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Obtained Marks</label>
                            <input type="number" step="0.01" name="obtained_marks" value="{{ old('obtained_marks') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            @error('obtained_marks')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Full Marks -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Full Marks</label>
                            <input type="number" step="0.01" name="full_marks" value="{{ old('full_marks') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            @error('full_marks')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grade -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Grade</label>
                            <input type="text" name="grade" value="{{ old('grade') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            @error('grade')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- GPA -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">GPA</label>
                            <input type="number" step="0.01" name="gpa" value="{{ old('gpa') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            @error('gpa')
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

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('exam_results.index') }}"
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
