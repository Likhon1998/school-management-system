<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">📚 Subjects</h2>
            <a href="{{ route('subjects.create') }}" 
               class="bg-green-700 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
               + Add New
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 px-4 flex justify-center">
        <div class="w-full max-w-5xl">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-3 bg-green-100 text-green-800 text-sm rounded shadow text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Card Table -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
                
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-indigo-50 text-indigo-700 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-center">SL</th>
                            <th class="px-6 py-3">Subject Name</th>
                            <th class="px-6 py-3">Code</th>
                            <th class="px-6 py-3">Class</th>
                            <th class="px-6 py-3 text-center">Compulsory</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($subjects as $index => $subject)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 text-center font-medium text-gray-600">
                                {{ $index + 1 + ($subjects->currentPage()-1)*$subjects->perPage() }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $subject->subject_name }}</td>
                            <td class="px-6 py-4">{{ $subject->subject_code }}</td>
                            <td class="px-6 py-4">{{ $subject->classModel->class_name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $subject->is_compulsory ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $subject->is_compulsory ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <a href="{{ route('subjects.edit', $subject->id) }}" 
                                   class="text-green-700 font-semibold px-2 py-1 rounded hover:bg-green-100 transition">
                                   Edit
                                </a>

                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" 
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
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-sm">
                                No subjects found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $subjects->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
