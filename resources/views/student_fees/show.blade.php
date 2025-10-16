<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Fee Details
            </h2>
            <a href="{{ route('student.dashboardFees') }}" 
               class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
               ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-3 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-4 sm:p-6 space-y-4">

                <div>
                    <h3 class="text-gray-600 font-medium">Fee Type: <span class="text-gray-800">{{ ucfirst($studentFee->feeStructure->fee_type) }}</span></h3>
                    <h3 class="text-gray-600 font-medium">Month/Exam: <span class="text-gray-800">
                        @if($studentFee->feeStructure->month)
                            {{ $studentFee->feeStructure->month }}
                        @elseif($studentFee->feeStructure->exam_name)
                            {{ $studentFee->feeStructure->exam_name }}
                        @endif
                    </span></h3>
                    <h3 class="text-gray-600 font-medium">Amount: <span class="text-gray-800">${{ number_format($studentFee->amount, 2) }}</span></h3>
                    <h3 class="text-gray-600 font-medium">Paid: <span class="text-gray-800">${{ number_format($studentFee->amount_paid, 2) }}</span></h3>
                    <h3 class="text-gray-600 font-medium">Due: <span class="text-gray-800">${{ number_format($studentFee->amount - $studentFee->amount_paid, 2) }}</span></h3>
                    <h3 class="text-gray-600 font-medium">Status: 
                        @if($studentFee->status == 'pending')
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Pending</span>
                        @elseif($studentFee->status == 'partial')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Partial</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Paid</span>
                        @endif
                    </h3>
                </div>

                @if(auth()->user()->role === 'superadmin' && $studentFee->status != 'paid')
                    <form action="{{ route('student_fees.updatePayment', $studentFee->id) }}" method="POST" class="space-y-2">
                        @csrf
                        <label class="block text-gray-700 text-sm font-medium">Enter Payment Amount:</label>
                        <input type="number" name="amount_paid" step="0.01" min="0" max="{{ $studentFee->amount - $studentFee->amount_paid }}" 
                               class="w-full border-gray-300 rounded shadow-sm p-2" required>

                        <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            Add Payment
                        </button>
                    </form>
                @endif

                <div>
                    <h4 class="text-gray-700 font-medium mb-2">Payment History:</h4>
                    <ul class="space-y-1">
                        @forelse($studentFee->payments as $payment)
                            <li class="text-sm text-gray-600">
                                ${{ number_format($payment->amount, 2) }} on {{ $payment->created_at->format('d M Y') }}
                            </li>
                        @empty
                            <li class="text-sm text-gray-400">No payments made yet.</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
