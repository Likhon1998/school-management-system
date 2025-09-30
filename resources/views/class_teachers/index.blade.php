<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Class Teachers List</h2>
            <a href="{{ route('class_teachers.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-1.5 rounded shadow transition">
               ➕ Assign Class Teacher
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-medium text-blue-800">Class Teachers</h3>
                </div>

                <!-- Table -->
                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto border-collapse text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-200 px-3 py-2 text-left">#</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Photo</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Teacher Name</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Class</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Section</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Academic Year</th>
                                <th class="border border-gray-200 px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classTeachers as $classTeacher)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-3 py-2">{{ $loop->iteration + ($classTeachers->currentPage()-1) * $classTeachers->perPage() }}</td>

                                    <!-- Photo -->
                                    <td class="border border-gray-200 px-3 py-2">
                                        <div class="w-8 h-8 rounded-full overflow-hidden border border-gray-300">
                                            <img src="{{ $classTeacher->teacher && $classTeacher->teacher->photo 
                                                        ? asset('storage/' . $classTeacher->teacher->photo) 
                                                        : asset('images/default-profile.png') }}" 
                                                 alt="Teacher Photo" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                    </td>

                                    <td class="border border-gray-200 px-3 py-2">{{ $classTeacher->teacher_name }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $classTeacher->class->class_name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $classTeacher->section->section_name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $classTeacher->academicYear->year_name ?? '-' }}</td>
                                    
                                    <!-- Actions -->
                                    <td class="border border-gray-200 px-3 py-2 text-center flex justify-center gap-2">
                                        <a href="{{ route('class_teachers.edit', $classTeacher->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                           Edit
                                        </a>

                                        <form action="{{ route('class_teachers.destroy', $classTeacher->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">No Class Teachers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $classTeachers->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
