<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-800">
                Student Fees - Pending Dues
            </h2>

            <div class="flex gap-2">

                <a href="{{ route('student_fees.history') }}" 
                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z" />
                    </svg>
                    History
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6 space-y-3">

            {{-- ✅ Success Message --}}
            @if(session('success'))
                <div class="p-2 bg-green-100 text-green-800 rounded-md text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ Fee Table Card --}}
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Student</th>
                            <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Class</th>
                            <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Fee Type</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 uppercase tracking-wider">Amount</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 uppercase tracking-wider">Paid</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 uppercase tracking-wider">Due</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @php
                            $totalAmount = 0;
                            $totalPaid = 0;
                            $totalDue = 0;
                        @endphp

                        @forelse($studentFees as $fee)
                            @php
                                $studentName = optional($fee->student)->student_name ?? 'N/A';
                                $className = optional($fee->student->class)->class_name ?? 'N/A';
                                $feeType = ucfirst(optional($fee->feeStructure)->fee_type ?? 'N/A');
                                $feeMonth = optional($fee->feeStructure)->month;
                                $amount = $fee->amount ?? 0;
                                $paid = $fee->paid_amount ?? 0;
                                $due = $fee->due_amount ?? max($amount - $paid, 0);
                            @endphp

                            @if($due > 0)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-3 py-1 font-medium text-gray-800">{{ $studentName }}</td>
                                    <td class="px-3 py-1 text-gray-700">{{ $className }}</td>
                                    <td class="px-3 py-1 text-gray-700">
                                        {{ $feeType }}
                                        @if($feeMonth)
                                            <span class="text-gray-400 text-xs">({{ $feeMonth }})</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-right font-medium text-gray-800">${{ number_format($amount, 2) }}</td>
                                    <td class="px-3 py-1 text-right text-green-700 font-semibold">${{ number_format($paid, 2) }}</td>
                                    <td class="px-3 py-1 text-right text-red-700 font-semibold">${{ number_format($due, 2) }}</td>
                                </tr>

                                @php
                                    $totalAmount += $amount;
                                    $totalPaid += $paid;
                                    $totalDue += $due;
                                @endphp
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-2 text-center text-gray-500">
                                    No pending fees.
                                </td>
                            </tr>
                        @endforelse

                        @if($totalDue > 0)
                            <tr class="bg-gray-50 font-medium text-gray-800">
                                <td colspan="3" class="px-3 py-2 text-right">Total:</td>
                                <td class="px-3 py-2 text-right">${{ number_format($totalAmount, 2) }}</td>
                                <td class="px-3 py-2 text-right text-green-700">${{ number_format($totalPaid, 2) }}</td>
                                <td class="px-3 py-2 text-right text-red-700">${{ number_format($totalDue, 2) }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{-- ✅ Pagination --}}
                <div class="px-3 py-2 bg-gray-50 flex justify-end border-t border-gray-200">
                    {{ $studentFees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
