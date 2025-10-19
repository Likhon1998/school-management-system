<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Fee Payment History
            </h2>
            <a href="{{ url()->previous() }}" 
               class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm transition">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">

            @if(session('success'))
                <div class="mb-3 p-3 bg-green-100 text-green-800 rounded shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Student</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Class</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Fee Type</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Month</th>
                                <th class="px-3 py-2 text-right font-medium text-gray-700 uppercase tracking-wider">Amount Paid</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-700 uppercase tracking-wider">Payment Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalPaid = 0;
                            @endphp

                            @forelse($payments as $payment)
                                @php
                                    $studentName = optional($payment->student)->student_name ?? 'N/A';
                                    $className = optional($payment->student->class)->class_name ?? 'N/A';
                                    $feeType = ucfirst(optional($payment->feeStructure)->fee_type ?? 'N/A');
                                    $feeMonth = optional($payment->feeStructure)->month ?? '-';
                                    $amountPaid = $payment->amount_paid ?? 0;
                                    $paymentDate = $payment->payment_date 
                                        ? \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') 
                                        : '-';
                                    $totalPaid += $amountPaid;
                                @endphp

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-3 py-1">{{ $studentName }}</td>
                                    <td class="px-3 py-1">{{ $className }}</td>
                                    <td class="px-3 py-1">{{ $feeType }}</td>
                                    <td class="px-3 py-1">{{ $feeMonth }}</td>
                                    <td class="px-3 py-1 text-right text-green-700 font-medium">${{ number_format($amountPaid, 2) }}</td>
                                    <td class="px-3 py-1">{{ $paymentDate }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-2 text-center text-gray-500">
                                        No payment history available.
                                    </td>
                                </tr>
                            @endforelse

                            @if($totalPaid > 0)
                                <tr class="bg-gray-50 font-semibold">
                                    <td colspan="4" class="px-3 py-2 text-right">Total Paid:</td>
                                    <td class="px-3 py-2 text-right text-green-800">${{ number_format($totalPaid, 2) }}</td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 px-3 py-2 bg-gray-50 flex justify-end">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
