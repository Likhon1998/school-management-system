<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">🎓 Students</h2>
            <a href="{{ route('students.create') }}" 
               class="bg-green-700 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
               + Add New
            </a>
        </div>
    </x-slot>

    <div x-data="{ showIdCard: false, student: {} }" class="min-h-screen bg-gray-50 py-10 px-4">

        <!-- Main Content (Blur when modal opens) -->
        <div :class="{ 'filter blur-sm transition-all duration-300': showIdCard }">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-3 bg-green-100 text-green-800 text-sm rounded shadow text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Students Table -->
            <div class="w-full max-w-6xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-indigo-50 text-indigo-700 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-center">SL</th>
                            <th class="px-6 py-3">Student ID</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Class</th>
                            <th class="px-6 py-3">Section</th>
                            <th class="px-6 py-3">Academic Year</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($students as $index => $student)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 text-center font-medium text-gray-600">
                                {{ $index + 1 + ($students->currentPage()-1)*$students->perPage() }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $student->student_id }}</td>
                            <td class="px-6 py-4">{{ $student->student_name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $student->class->class_name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $student->section->section_name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $student->academicYear->year_name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $student->status=='active' ? 'bg-green-100 text-green-800' : ($student->status=='inactive' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <a href="{{ route('students.edit', $student->id) }}" 
                                   class="text-green-700 font-semibold px-2 py-1 rounded hover:bg-green-100 transition">
                                   Edit
                                </a>
                                <a href="{{ route('students.show', $student->id) }}" 
                                   class="text-blue-700 font-semibold px-2 py-1 rounded hover:bg-blue-100 transition">
                                   View
                                </a>

                                <!-- ID Card Preview Button -->
                                <button @click="student={{ json_encode($student) }}; showIdCard = true" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1 rounded transition shadow-sm">
                                    ID Card
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1 rounded transition shadow-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-500 text-sm">
                                No students found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $students->withQueryString()->links() }}
            </div>

        </div>

        <!-- ID Card Modal -->
        <div x-show="showIdCard" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
             x-transition.opacity
             style="display: none;">
            <div class="bg-white rounded-xl shadow-2xl w-[360px] h-[220px] relative flex flex-col" @click.away="showIdCard = false">
                <button @click="showIdCard = false" 
                        class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 font-bold text-xl">&times;</button>

                <!-- ID Card Content -->
                <div class="flex flex-col h-full w-full rounded-xl overflow-hidden border border-gray-300 shadow-lg" style="background: linear-gradient(145deg, #e0f7fa, #ffffff);">
                    
                    <!-- Header -->
                    <div class="bg-green-700 text-white px-3 py-1 flex justify-between items-center">
                        <span class="font-bold text-sm">SCHOOL NAME</span>
                        <span class="text-xs font-semibold">STUDENT ID CARD</span>
                    </div>

                    <!-- Body -->
                    <div class="flex flex-1 p-3 gap-3">
                        <div class="flex-shrink-0">
                            <img :src="student.photo ? '/storage/' + student.photo : '/images/default-avatar.png'" 
                                 class="w-24 h-24 rounded border-2 border-green-700 object-cover" alt="Student Photo">
                        </div>
                        <div class="flex-1 text-xs flex flex-col justify-center space-y-1">
                            <p><span class="font-semibold">Name:</span> <span x-text="student.student_name"></span></p>
                            <p><span class="font-semibold">ID:</span> <span x-text="student.student_id"></span></p>
                            <p><span class="font-semibold">Gov ID:</span> <span x-text="student.government_id || '-'"></span></p>
                            <p><span class="font-semibold">Class:</span> <span x-text="student.class ? student.class.class_name : '-'"></span></p>
                            <p><span class="font-semibold">Section:</span> <span x-text="student.section ? student.section.section_name : '-'"></span></p>
                            <p><span class="font-semibold">Year:</span> <span x-text="student.academicYear ? student.academicYear.year_name : '-'"></span></p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-2 flex justify-center border-t border-gray-200">
                        <a :href="`/students/${student.id}/id-card/download`" 
                           class="inline-block bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded shadow-sm text-xs font-semibold">
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        feather.replace()
    </script>
</x-app-layout>
