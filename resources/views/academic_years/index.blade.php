<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                📅 Academic Years
            </h2>
            <a href="{{ route('academic_years.create') }}" 
               class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105">
               + Add New
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 px-4 flex justify-center">
        <div class="w-full max-w-6xl">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-800 text-sm rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Card Table -->
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-200">

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-center">SL</th>
                                <th class="px-6 py-3">Year Name</th>
                                <th class="px-6 py-3">Start Date</th>
                                <th class="px-6 py-3">End Date</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($years as $index => $year)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-center font-medium text-gray-600">{{ $index + 1 + ($years->currentPage()-1)*$years->perPage() }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $year->year_name }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($year->start_date)->format('d M, Y') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($year->end_date)->format('d M, Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm
                                        {{ $year->status=='active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($year->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center flex justify-center gap-3">
                                    <!-- Edit Button -->
                                    <a href="{{ route('academic_years.edit', $year->id) }}" 
                                       class="flex items-center gap-1 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold px-3 py-1 rounded-lg shadow-md transition transform hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('academic_years.destroy', $year->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1 rounded-lg shadow-md transition transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-sm">
                                    No academic years found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $years->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
