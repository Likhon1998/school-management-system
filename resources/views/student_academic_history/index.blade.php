<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">🎓 Student Academic History</h2>
            <a href="{{ route('student_academic_history.create') }}"
               class="bg-green-700 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded shadow transition">
               + Add History
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 px-4 flex justify-center">
        <div class="w-full max-w-6xl">

            @if(session('success'))
                <div class="mb-6 p-3 bg-green-100 text-green-800 rounded shadow text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-indigo-50 text-indigo-700 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-center">SL</th>
                            <th class="px-6 py-3">Student Name</th>
                            <th class="px-6 py-3">Student id</th>
                            <th class="px-6 py-3">Academic Year</th>
                            <th class="px-6 py-3">Class</th>
                            <th class="px-6 py-3">Section</th>
                            <th class="px-6 py-3">Roll Number</th>
                            <th class="px-6 py-3">Promotion Status</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($histories as $index => $history)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center">{{ $index+1 + ($histories->currentPage()-1)*$histories->perPage() }}</td>
                            <td class="px-6 py-4">{{ $history->student->student_name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $history->academicYear->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $history->class->class_name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $history->section->section_name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $history->roll_number ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded 
                                    {{ $history->promotion_status == 'promoted' ? 'bg-green-100 text-green-600' : ($history->promotion_status == 'failed' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($history->promotion_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <a href="{{ route('student_academic_history.edit', $history->id) }}" 
                                   class="text-green-700 font-semibold px-2 py-1 rounded hover:bg-green-100 transition">
                                   Edit
                                </a>
                                <form action="{{ route('student_academic_history.destroy', $history->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1 rounded shadow-sm transition">
                                            Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                No academic history found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $histories->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
