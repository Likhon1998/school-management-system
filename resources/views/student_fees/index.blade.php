<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Student Fees (Pending Dues)
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-3 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-4 sm:p-6">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Student</th>
                            <th class="px-4 py-2 text-left">Class</th>
                            <th class="px-4 py-2 text-left">Fee Type</th>
                            <th class="px-4 py-2 text-left">Amount</th>
                            <th class="px-4 py-2 text-left">Paid</th>
                            <th class="px-4 py-2 text-left">Due</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($studentFees as $fee)
                            @if($fee->due_amount > 0)
                            <tr>
                                <td class="px-4 py-2">{{ $fee->student->student_name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $fee->student->class->class_name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    {{ ucfirst($fee->feeStructure->fee_type ?? 'N/A') }}
                                    @if(!empty($fee->feeStructure->month))
                                        ({{ $fee->feeStructure->month }})
                                    @endif
                                </td>
                                <td class="px-4 py-2">${{ number_format($fee->amount, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($fee->paid_amount, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($fee->due_amount, 2) }}</td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                    No pending fees.
                                </td>
                            </tr>
                        @endforelse

                        <!-- Total Row -->
                        @if($studentFees->where('due_amount', '>', 0)->count() > 0)
                            <tr class="bg-gray-100 font-semibold">
                                <td colspan="3" class="px-4 py-2 text-right">Total:</td>
                                <td class="px-4 py-2">${{ number_format($totalAmount, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($totalPaid, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($totalDue, 2) }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $studentFees->links() }} <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
