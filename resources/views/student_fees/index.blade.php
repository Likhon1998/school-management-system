<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Fees
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach(['#','Fee Type','Month/Exam','Description','Amount','Paid','Due','Status','Action'] as $header)
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase truncate">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $total_due = 0; @endphp
                        @forelse($studentFees as $fee)
                            @php
                                $paid = $fee->payments->sum('amount_paid');
                                $due = $fee->amount - $paid;
                                $total_due += $due;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2">{{ ucfirst($fee->fee_type) }}</td>
                                <td class="px-3 py-2">{{ $fee->month ?? '-' }}/{{ $fee->exam_name ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $fee->description ?? '-' }}</td>
                                <td class="px-3 py-2">{{ number_format($fee->amount,2) }}</td>
                                <td class="px-3 py-2">{{ number_format($paid,2) }}</td>
                                <td class="px-3 py-2">{{ number_format($due,2) }}</td>
                                <td class="px-3 py-2">
                                    @if($due == 0)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full font-semibold">Paid</span>
                                    @elseif($due < $fee->amount)
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full font-semibold">Partial</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    @if($due > 0)
                                        <a href="{{ route('student_fee.pay', $fee->id) }}"
                                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">
                                           Pay
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-6 text-center text-gray-500 font-medium">
                                    No fees assigned yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="6" class="px-3 py-2 text-right">Total Due:</td>
                            <td class="px-3 py-2">{{ number_format($total_due,2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
