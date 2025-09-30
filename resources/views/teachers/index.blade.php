<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Teachers</h2>
            <a href="{{ route('teachers.create') }}" 
               class="bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ➕ Add Teacher
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">

                <!-- Table -->
                <table class="w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border px-3 py-2">ID</th>
                            <th class="border px-3 py-2">Photo</th>
                            <th class="border px-3 py-2">Name</th>
                            <th class="border px-3 py-2">Employee ID</th>
                            <th class="border px-3 py-2">Designation</th>
                            <th class="border px-3 py-2">Experience</th>
                            <th class="border px-3 py-2">Salary</th>
                            <th class="border px-3 py-2">Status</th>
                            <th class="border px-3 py-2">User</th>
                            <th class="border px-3 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-3 py-2">{{ $teacher->id }}</td>

                                <!-- Photo Thumbnail -->
                                <td class="border px-3 py-2">
                                    <div class="w-8 h-8 overflow-hidden rounded-full border border-gray-300 mx-auto">
                                        <img 
                                            src="{{ $teacher->photo ? asset('storage/' . $teacher->photo) : asset('images/default-profile.png') }}" 
                                            alt="Teacher Photo" 
                                            class="w-full h-full object-cover transition-transform duration-200 ease-in-out hover:scale-105">
                                    </div>
                                </td>

                                <td class="border px-3 py-2">{{ $teacher->teacher_name }}</td>
                                <td class="border px-3 py-2">{{ $teacher->employee_id }}</td>
                                <td class="border px-3 py-2">{{ $teacher->designation }}</td>
                                <td class="border px-3 py-2">{{ $teacher->experience }} yrs</td>
                                <td class="border px-3 py-2">{{ number_format($teacher->salary, 2) }}</td>
                                <td class="border px-3 py-2 capitalize">{{ $teacher->status }}</td>
                                <td class="border px-3 py-2">{{ $teacher->user?->username ?? 'N/A' }}</td>

                                <!-- Actions -->
                                <td class="border px-3 py-2 flex gap-2">
                                    <a href="{{ route('teachers.edit', $teacher->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs transition">
                                       Edit
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="border px-3 py-2 text-center text-gray-500">
                                    No teachers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $teachers->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
