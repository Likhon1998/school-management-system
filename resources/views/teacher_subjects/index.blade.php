<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Teacher Subjects</h2>
            <a href="{{ route('teacher_subjects.create') }}" 
               class="bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ➕ Add Assignment
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border px-3 py-2">#</th>
                        <th class="border px-3 py-2">Teacher Name</th>
                        <th class="border px-3 py-2">Subject</th>
                        <th class="border px-3 py-2">Class</th>
                        <th class="border px-3 py-2">Section</th>
                        <th class="border px-3 py-2">Academic Year</th>
                        <th class="border px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teacherSubjects as $index => $assignment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-3 py-2">{{ $index + 1 + ($teacherSubjects->currentPage() - 1) * $teacherSubjects->perPage() }}</td>
                            <td class="border px-3 py-2">{{ $assignment->teacher->teacher_name ?? $assignment->teacher_name }}</td>
                            <td class="border px-3 py-2">{{ $assignment->subject->subject_name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $assignment->class->class_name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $assignment->section->section_name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $assignment->academicYear->year_name ?? '-' }}</td>
                            <td class="border px-3 py-2 flex gap-2">
                                <a href="{{ route('teacher_subjects.edit', $assignment->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">Edit</a>
                                <form action="{{ route('teacher_subjects.destroy', $assignment->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-6 py-10 text-gray-500">No teacher subjects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="p-4">
                {{ $teacherSubjects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
