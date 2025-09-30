<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Exam Results</h2>
            <a href="{{ route('exam_results.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-1.5 rounded shadow transition">
               ➕ Add Exam Result
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-medium text-blue-800">Exam Results Records</h3>
                </div>

                <!-- Table -->
                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto border-collapse text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-200 px-3 py-2 text-left">#</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Student</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Exam</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Subject</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Obtained Marks</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Full Marks</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Grade</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">GPA</th>
                                <th class="border border-gray-200 px-3 py-2 text-left">Remarks</th>
                                <th class="border border-gray-200 px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($examResults as $result)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-3 py-2">
                                        {{ $loop->iteration + ($examResults->currentPage()-1) * $examResults->perPage() }}
                                    </td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->student->student_name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->examination->exam_name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->subject->subject_name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->obtained_marks }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->full_marks }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->grade }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->gpa }}</td>
                                    <td class="border border-gray-200 px-3 py-2">{{ $result->remarks ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-center flex justify-center gap-2">
                                        <a href="{{ route('exam_results.edit', $result->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                           Edit
                                        </a>

                                        <form action="{{ route('exam_results.destroy', $result->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                                    <td colspan="10" class="text-center py-4 text-gray-500">No exam results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $examResults->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
