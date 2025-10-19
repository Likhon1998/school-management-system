<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-base text-gray-700 leading-tight">
                Fee Payments
            </h2>
            <a href="{{ route('fee_payments.create') }}" 
               class="px-3 py-1.5 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium shadow">
               + Add Payment
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">

            @if (session('success'))
                <div class="mb-3 p-2 bg-green-100 text-green-800 rounded shadow text-xs">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded border border-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach(['#','Student','Fee Type','Month','Exam','Amount Due','Paid','Remaining','Status','Actions'] as $header)
                                <th class="px-2 py-1 text-left font-semibold text-gray-600 uppercase whitespace-nowrap">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $counter = 1; @endphp
                        @forelse($feePayments as $group)
                            @php
                                $payment = $group->first(); // representative
                                $feeAmount = $payment->feeStructure->amount ?? 0;
                                $totalPaid = $group->sum('amount_paid');
                                $remaining = max($feeAmount - $totalPaid, 0);
                                $status = $remaining <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'pending');
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-2 py-1">{{ $counter++ }}</td>
                                <td class="px-2 py-1 truncate" title="{{ $payment->student->student_name ?? '-' }}">
                                    {{ $payment->student->student_name ?? '-' }}
                                </td>
                                <td class="px-2 py-1 truncate" title="{{ $payment->feeStructure->fee_type ?? '-' }}">
                                    {{ ucfirst($payment->feeStructure->fee_type ?? '-') }}
                                </td>
                                <td class="px-2 py-1">{{ $payment->feeStructure->month ?? '-' }}</td>
                                <td class="px-2 py-1 truncate" title="{{ $payment->feeStructure->exam_name ?? '-' }}">
                                    {{ $payment->feeStructure->exam_name ?? '-' }}
                                </td>
                                <td class="px-2 py-1 text-right">{{ number_format($feeAmount, 2) }}</td>
                                <td class="px-2 py-1 text-right">{{ number_format($totalPaid, 2) }}</td>
                                <td class="px-2 py-1 text-right">{{ number_format($remaining, 2) }}</td>
                                <td class="px-2 py-1">
                                    @if($status == 'paid')
                                        <span class="px-1 py-0.5 text-[10px] bg-green-100 text-green-800 rounded-full font-semibold">Paid</span>
                                    @elseif($status == 'partial')
                                        <span class="px-1 py-0.5 text-[10px] bg-yellow-100 text-yellow-800 rounded-full font-semibold">Partial</span>
                                    @else
                                        <span class="px-1 py-0.5 text-[10px] bg-red-100 text-red-800 rounded-full font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="px-2 py-1 text-center space-x-1">
                                    <a href="{{ route('fee_payments.editMultiple', $payment->student->id) }}" 
                                       class="px-2 py-0.5 bg-green-600 text-white rounded hover:bg-green-700 text-[10px]">Edit</a>
                                    <form action="{{ route('fee_payments.destroy', $payment->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-2 py-0.5 bg-red-600 text-white rounded hover:bg-red-700 text-[10px]"
                                                onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-2 py-4 text-center text-gray-500 font-medium text-xs">
                                    No fee payments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
