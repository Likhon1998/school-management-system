<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <h1 class="text-3xl font-bold text-gray-800">🌟 School Name 🌟</h1>
        </div>
    </x-slot>

    <div class="min-h-screen flex justify-center py-10 px-4">
        <div class="w-full max-w-3xl bg-white shadow-2xl rounded-2xl border border-gray-200 p-6 relative">

            <!-- Top Section: Photo and Name -->
            <div class="flex justify-between items-center mb-6">
                <!-- Student Name and ID -->
                <div>
                    <p class="text-xl font-semibold">Student Name: <span class="font-normal">{{ $student->student_name }}</span></p>
                    <p class="text-lg font-semibold">Student ID: <span class="font-normal">{{ $student->student_id }}</span></p>
                </div>

                <!-- Student Photo -->
                <div class="w-32 h-40 border border-gray-300 rounded-lg overflow-hidden">
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400 text-sm">
                            No Photo
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <p><span class="font-semibold">Government ID:</span> {{ $student->government_id ?? '-' }}</p>
                <p><span class="font-semibold">Admission Number:</span> {{ $student->admission_number }}</p>
                <p><span class="font-semibold">Admission Date:</span> {{ $student->admission_date }}</p>
                <p><span class="font-semibold">Class:</span> {{ $student->class->class_name ?? '-' }}</p>
                <p><span class="font-semibold">Section:</span> {{ $student->section->section_name ?? '-' }}</p>
                <p><span class="font-semibold">Academic Year:</span> {{ $student->academicYear->year_name ?? '-' }}</p>
                <p><span class="font-semibold">Roll Number:</span> {{ $student->roll_number ?? '-' }}</p>
                <p><span class="font-semibold">Blood Group:</span> {{ $student->blood_group ?? '-' }}</p>
                <p><span class="font-semibold">Religion:</span> {{ $student->religion ?? '-' }}</p>
                <p><span class="font-semibold">Nationality:</span> {{ $student->nationality ?? '-' }}</p>
                <p><span class="font-semibold">Date of Birth:</span> {{ $student->date_of_birth ?? '-' }}</p>
                <p><span class="font-semibold">Gender:</span> {{ ucfirst($student->gender ?? '-') }}</p>
                <p class="md:col-span-2"><span class="font-semibold">Address:</span> {{ $student->address ?? '-' }}</p>
                <p><span class="font-semibold">Email:</span> {{ $student->email ?? '-' }}</p>
                <p><span class="font-semibold">Parent Email:</span> {{ $student->parent_email ?? '-' }}</p>
                <p><span class="font-semibold">Emergency Contact:</span> {{ $student->emergency_contact ?? '-' }}</p>
                <p class="md:col-span-2"><span class="font-semibold">Medical Info:</span> {{ $student->medical_info ?? '-' }}</p>
                <p><span class="font-semibold">Father Name:</span> {{ $student->father_name ?? '-' }}</p>
                <p><span class="font-semibold">Father Phone:</span> {{ $student->father_phone ?? '-' }}</p>
                <p><span class="font-semibold">Father Occupation:</span> {{ $student->father_occupation ?? '-' }}</p>
                <p><span class="font-semibold">Mother Name:</span> {{ $student->mother_name ?? '-' }}</p>
                <p><span class="font-semibold">Mother Phone:</span> {{ $student->mother_phone ?? '-' }}</p>
                <p><span class="font-semibold">Guardian Name:</span> {{ $student->guardian_name ?? '-' }}</p>
                <p><span class="font-semibold">Guardian Phone:</span> {{ $student->guardian_phone ?? '-' }}</p>
                <p><span class="font-semibold">Status:</span> {{ ucfirst($student->status) }}</p>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('students.index') }}" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg text-sm shadow">Back</a>
                <a href="{{ route('students.student_info', $student->id) }}" target="_blank"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm shadow">
                    Preview / Download PDF
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
