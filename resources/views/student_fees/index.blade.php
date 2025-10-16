<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Student Fees
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('fee_structures.index') }}" 
                   class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
                   ← Back to Fee Structures
                </a>
                <a href="{{ route('student_fees.index') }}" 
                   class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                   Payment History
                </a>
            </div>
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
                            <tr>
                                <td class="px-4 py-2">{{ $fee->student->student_name }}</td>
                                <td class="px-4 py-2">{{ $fee->student->class->class_name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($fee->feeStructure->fee_type) }} 
                                    @if($fee->feeStructure->month) ({{ $fee->feeStructure->month }}) @endif
                                </td>
                                <td class="px-4 py-2">${{ number_format($fee->amount, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($fee->amount_paid, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($fee->amount - $fee->amount_paid, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-2 text-center text-gray-500">
                                    No student fees found.
                                </td>
                            </tr>
                        @endforelse

                        <!-- Total Row -->
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="3" class="px-4 py-2 text-right">Total:</td>
                            <td class="px-4 py-2">${{ number_format($studentFees->sum('amount'), 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($studentFees->sum('amount_paid'), 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($studentFees->sum(function($fee) { return $fee->amount - $fee->amount_paid; }), 2) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $studentFees->links() }} <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
