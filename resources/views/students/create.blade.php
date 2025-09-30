<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Add Student</h2>
            <a href="{{ route('students.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg shadow transition">
               ⬅ Back
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 px-4 flex justify-center">
        <div class="w-full max-w-5xl">

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-800 text-sm rounded shadow">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card -->
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200">
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Student Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Student Name</label>
                            <input type="text" name="student_name" value="{{ old('student_name') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm">
                        </div>

                        <!-- Student ID (auto/manual) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Student ID</label>
                            <input type="text" name="student_id" value="{{ old('student_id') }}" 
                            placeholder="Auto-generated or manual" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm">
                            <small class="text-gray-500 text-xs">Auto-generated on page load</small>
                        </div>
                      

                        <!-- Government ID -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Government ID</label>
                            <input type="text" name="government_id" value="{{ old('government_id') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Admission Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Admission Number</label>
                            <input type="text" name="admission_number" value="{{ old('admission_number') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm" required>
                        </div>

                        <!-- Admission Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Admission Date</label>
                            <input type="date" name="admission_date" value="{{ old('admission_date') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm" required>
                        </div>

                        <!-- Class -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Class</label>
                            <select name="class_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" required>
                                <option value="">-- Select Class --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Section</label>
                            <select name="section_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" required>
                                <option value="">-- Select Section --</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Academic Year -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Academic Year</label>
                            <select name="academic_year_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" required>
                                <option value="">-- Select Academic Year --</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Roll Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Roll Number</label>
                            <input type="number" name="roll_number" value="{{ old('roll_number') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm">
                        </div>

                        <!-- Blood Group -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Blood Group</label>
                            <input type="text" name="blood_group" value="{{ old('blood_group') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm">
                        </div>

                        <!-- Religion -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Religion</label>
                            <input type="text" name="religion" value="{{ old('religion') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm">
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 text-sm">
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Gender</label>
                            <select name="gender" class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                                <option value="">-- Select Gender --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                            <textarea name="address" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" rows="2">{{ old('address') }}</textarea>
                        </div>

                        <!-- Photo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Photo</label>
                            <input type="file" name="photo" accept="image/*" class="w-full text-sm">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Student Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Parent Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Parent Email</label>
                            <input type="email" name="parent_email" value="{{ old('parent_email') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Emergency Contact</label>
                            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Medical Info -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Medical Information</label>
                            <textarea name="medical_info" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" rows="2">{{ old('medical_info') }}</textarea>
                        </div>

                        <!-- Father's Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Father's Name</label>
                            <input type="text" name="father_name" value="{{ old('father_name') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Father Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Father's Phone</label>
                            <input type="text" name="father_phone" value="{{ old('father_phone') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Mother Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Mother's Name</label>
                            <input type="text" name="mother_name" value="{{ old('mother_name') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Mother Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Mother's Phone</label>
                            <input type="text" name="mother_phone" value="{{ old('mother_phone') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Guardian Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Guardian Name</label>
                            <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Guardian Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Guardian Phone</label>
                            <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                        </div>

                        <!-- Created By -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Created By</label>
                            <select name="user_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" required>
                                <option value="">-- Select Creator --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->username }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="transferred" {{ old('status') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                            </select>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('students.index') }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg shadow text-sm">
                           Cancel
                        </a>
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow text-sm">
                            Save
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch next student ID via AJAX
        fetch("{{ route('students.nextId') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('student_id').value = data.student_id;
            })
            .catch(error => console.error('Error fetching Student ID:', error));
    });
</script>
@endpush

</x-app-layout>
