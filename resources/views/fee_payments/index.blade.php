<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Fee Payments
            </h2>
            <a href="{{ route('fee_payments.create') }}" 
               class="px-3 py-1.5 bg-green-200 text-green-800 rounded hover:bg-green-300 text-sm font-medium shadow">
               + Add Payment
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-3 p-3 bg-green-100 text-green-800 rounded text-sm shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach(['#','Student','Fee Type','Month','Exam','Amount Due','Amount Paid','Remaining Dues','Status','Actions'] as $header)
                                    <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase truncate">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($feePayments as $payment)
                                @php
                                    $feeAmount = $payment->feeStructure->amount ?? 0;
                                    $amountPaid = $payment->amount_paid ?? 0;
                                    $due = $feeAmount - $amountPaid;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-2 truncate" title="{{ $payment->student->student_name ?? '-' }}">
                                        {{ $payment->student->student_name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 truncate" title="{{ $payment->feeStructure->fee_type ?? '-' }}">
                                        {{ ucfirst($payment->feeStructure->fee_type ?? '-') }}
                                    </td>
                                    <td class="px-3 py-2">{{ $payment->feeStructure->month ?? '-' }}</td>
                                    <td class="px-3 py-2 truncate" title="{{ $payment->feeStructure->exam_name ?? '-' }}">
                                        {{ $payment->feeStructure->exam_name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-right">{{ number_format($feeAmount, 2) }}</td>
                                    <td class="px-3 py-2 text-right">{{ number_format($amountPaid, 2) }}</td>
                                    <td class="px-3 py-2 text-right">{{ number_format($due, 2) }}</td>
                                    <td class="px-3 py-2">
                                        @if($due <= 0)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full font-semibold">Paid</span>
                                        @elseif($due > 0 && $amountPaid > 0)
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full font-semibold">Partial</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full font-semibold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-center space-x-1">
                                        <a href="{{ route('fee_payments.edit', $payment->id) }}" 
                                           class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">Edit</a>
                                        <form action="{{ route('fee_payments.destroy', $payment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Mobile view --}}
                                <tr class="bg-gray-50 lg:hidden">
                                    <td colspan="10" class="px-3 py-2 text-xs text-gray-600">
                                        <div class="grid grid-cols-2 gap-2">
                                            <div><strong>Student:</strong> {{ $payment->student->student_name ?? '-' }}</div>
                                            <div><strong>Fee Type:</strong> {{ ucfirst($payment->feeStructure->fee_type ?? '-') }}</div>
                                            <div><strong>Month:</strong> {{ $payment->feeStructure->month ?? '-' }}</div>
                                            <div><strong>Exam:</strong> {{ $payment->feeStructure->exam_name ?? '-' }}</div>
                                            <div><strong>Amount Due:</strong> {{ number_format($feeAmount, 2) }}</div>
                                            <div><strong>Amount Paid:</strong> {{ number_format($amountPaid, 2) }}</div>
                                            <div><strong>Remaining:</strong> {{ number_format($due, 2) }}</div>
                                            <div><strong>Status:</strong>
                                                @if($due <= 0)
                                                    Paid
                                                @elseif($due > 0 && $amountPaid > 0)
                                                    Partial
                                                @else
                                                    Pending
                                                @endif
                                            </div>
                                            <div><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</div>
                                            <div><strong>Method:</strong> {{ ucfirst($payment->payment_method) }}</div>
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

        </div>
    </div>
</x-app-layout>
