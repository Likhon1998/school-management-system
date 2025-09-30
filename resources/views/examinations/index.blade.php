<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Examinations</h2>
            <a href="{{ route('examinations.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-1.5 rounded shadow transition">
               ➕ Add Examination
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-medium text-blue-800">Examination List</h3>
                </div>

                <!-- Table -->
                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto border-collapse text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-200 px-3 py-2 text-left">#</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Exam Name</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Type</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Academic Year</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Start Date</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">End Date</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Status</th>
                                <th class="border border-gray-200 px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($examinations as $examination)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-3 py-2">{{ $loop->iteration + ($examinations->currentPage()-1) * $examinations->perPage() }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $examination->exam_name }}</td>
                                    <td class="border border-gray-200 px-3 py-2 capitalize">{{ $examination->exam_type }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $examination->academicYear->year_name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $examination->start_date }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $examination->end_date }}</td>
                                    <td class="border border-gray-200 px-3 py-2 capitalize">{{ $examination->status }}</td>

                                    <td class="border border-gray-200 px-3 py-2 text-center flex justify-center gap-2">
                                        <a href="{{ route('examinations.edit', $examination->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                           Edit
                                        </a>

                                        <form action="{{ route('examinations.destroy', $examination->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                                    <td colspan="8" class="text-center py-4 text-gray-500">No examinations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $examinations->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
