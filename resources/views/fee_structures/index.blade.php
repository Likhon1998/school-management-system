<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Fee Structures
            </h2>
            <a href="{{ route('fee_structures.create') }}" 
               class="px-3 py-1.5 bg-green-200 text-green-800 font-medium rounded shadow hover:bg-green-300 transition text-sm">
                + Add Fee Structure
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-3 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">Class</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">Academic Year</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">Fee Type</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">Month</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">Exam</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">Description</th>
                            <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase">Amount</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase">Due Date</th>
                            <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($feeStructures as $index => $fee)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 whitespace-normal">{{ $index + 1 }}</td>
                            <td class="px-3 py-2 whitespace-normal">{{ $fee->class->class_name ?? '-' }}</td>
                            <td class="px-3 py-2 whitespace-normal">{{ $fee->academicYear->year_name ?? '-' }}</td>
                            <td class="px-3 py-2 whitespace-normal capitalize">{{ $fee->fee_type }}</td>
                            <td class="px-3 py-2 whitespace-normal">{{ $fee->month ?? '-' }}</td>
                            <td class="px-3 py-2 whitespace-normal">{{ $fee->exam_name ?? '-' }}</td>
                            <td class="px-3 py-2 whitespace-normal">{{ $fee->description ?? '-' }}</td>
                            <td class="px-3 py-2 text-right whitespace-normal">{{ number_format($fee->amount, 2) }}</td>
                            <td class="px-3 py-2 whitespace-normal">{{ $fee->due_date ? $fee->due_date->format('d-m-Y') : '-' }}</td>
                            <td class="px-3 py-2 text-center space-x-2">
                                <a href="{{ route('fee_structures.edit', $fee->id) }}" 
                                   class="text-green-600 hover:text-green-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('fee_structures.destroy', $fee->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-3 py-4 text-center text-gray-500 text-sm">No fee structures found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
