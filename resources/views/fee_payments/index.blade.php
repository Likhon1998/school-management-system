<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-800">
                💰 Fee Payments
            </h2>
            <a href="{{ route('fee_payments.create') }}" 
               class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-md shadow hover:bg-green-700 transition">
                + Add Payment
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">

            {{-- ✅ Flash message --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 text-sm rounded-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ Table Container --}}
            <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold uppercase text-gray-600 text-xs">#</th>
                                <th class="px-4 py-2 text-left font-semibold uppercase text-gray-600 text-xs">Student</th>
                                <th class="px-4 py-2 text-left font-semibold uppercase text-gray-600 text-xs">Fee Type</th>
                                <th class="px-4 py-2 text-left font-semibold uppercase text-gray-600 text-xs">Month</th>
                                <th class="px-4 py-2 text-left font-semibold uppercase text-gray-600 text-xs">Exam</th>
                                <th class="px-4 py-2 text-right font-semibold uppercase text-gray-600 text-xs">Amount</th>
                                <th class="px-4 py-2 text-right font-semibold uppercase text-gray-600 text-xs">Paid</th>
                                <th class="px-4 py-2 text-right font-semibold uppercase text-gray-600 text-xs">Remaining</th>
                                <th class="px-4 py-2 text-center font-semibold uppercase text-gray-600 text-xs">Status</th>
                                <th class="px-4 py-2 text-center font-semibold uppercase text-gray-600 text-xs">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @php $counter = 1; @endphp

                            @forelse($feePayments as $group)
                                @php
                                    $payment = $group->first();
                                    $feeAmount = $payment->feeStructure->amount ?? 0;
                                    $totalPaid = $group->sum('amount_paid');
                                    $remaining = max($feeAmount - $totalPaid, 0);
                                    $status = $remaining <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'pending');
                                @endphp

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 text-gray-700">{{ $counter++ }}</td>

                                    <td class="px-4 py-2 font-medium text-gray-800">
                                        {{ $payment->student->student_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 capitalize">
                                        {{ $payment->feeStructure->fee_type ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2">
                                        {{ $payment->feeStructure->month ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2">
                                        {{ $payment->feeStructure->exam_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 text-right font-medium text-gray-800">
                                        {{ number_format($feeAmount, 2) }}
                                    </td>

                                    <td class="px-4 py-2 text-right text-green-700">
                                        {{ number_format($totalPaid, 2) }}
                                    </td>

                                    <td class="px-4 py-2 text-right text-red-700">
                                        {{ number_format($remaining, 2) }}
                                    </td>

                                    <td class="px-4 py-2 text-center">
                                        @if($status === 'paid')
                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[11px] font-semibold rounded-full">
                                                Paid
                                            </span>
                                        @elseif($status === 'partial')
                                            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-[11px] font-semibold rounded-full">
                                                Partial
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[11px] font-semibold rounded-full">
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            {{-- <a href="{{ route('fee_payments.editMultiple', $payment->student->id) }}" 
                                               class="px-2 py-0.5 bg-blue-600 text-white text-[11px] rounded hover:bg-blue-700 transition">
                                                Edit
                                            </a> --}}

                                            <form action="{{ route('fee_payments.destroy', $payment->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-2 py-0.5 bg-red-600 text-white text-[11px] rounded hover:bg-red-700 transition"
                                                        onclick="return confirm('Are you sure you want to delete this payment?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-6 text-center text-gray-500 font-medium">
                                        No fee payments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ✅ Pagination --}}
            @if (method_exists($feePayments, 'links'))
                <div class="mt-4">
                    {{ $feePayments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
