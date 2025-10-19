<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Student Fees History (Paid)
            </h2>
            <a href="{{ route('student_fees.index') }}" 
               class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
               ← Back to Current Dues
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-4 sm:p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Student</th>
                            <th class="px-4 py-2">Class</th>
                            <th class="px-4 py-2">Fee Type</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Paid</th>
                            <th class="px-4 py-2">Paid Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($paidFees as $fee)
                            <tr>
                                <td class="px-4 py-2">{{ $fee->student->student_name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $fee->student->class->class_name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ ucfirst($fee->feeStructure->fee_type ?? 'N/A') }}
                                    @if(!empty($fee->feeStructure->month))
                                        ({{ $fee->feeStructure->month }})
                                    @endif
                                </td>
                                <td class="px-4 py-2">${{ number_format($fee->amount, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($fee->amount_paid, 2) }}</td>
                                <td class="px-4 py-2">{{ $fee->updated_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                    No paid fees found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $paidFees->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
