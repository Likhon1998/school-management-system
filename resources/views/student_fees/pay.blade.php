<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pay Fee
            </h2>
            <a href="{{ route('student_fees.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">
                    {{ $studentFee->student->student_name }} - {{ ucfirst($studentFee->fee_type) }}
                </h3>

                <table class="w-full mb-6 border border-gray-200 rounded">
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Total Amount</th>
                        <th class="px-4 py-2 text-left">Paid</th>
                        <th class="px-4 py-2 text-left">Due</th>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">{{ number_format($studentFee->amount_due,2) }}</td>
                        <td class="px-4 py-2">{{ number_format($studentFee->amount_paid,2) }}</td>
                        <td class="px-4 py-2">{{ number_format($studentFee->amount_due - $studentFee->amount_paid,2) }}</td>
                    </tr>
                </table>

                <form action="{{ route('student_fee.pay', $studentFee->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Amount to Pay</label>
                        <input type="number" name="amount_paid" step="0.01" max="{{ $studentFee->amount_due - $studentFee->amount_paid }}" 
                               class="w-full border-gray-300 rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Payment Method</label>
                        <select name="payment_method" class="w-full border-gray-300 rounded px-3 py-2" required>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="mobile_banking">Mobile Banking</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Payment Date</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" 
                               class="w-full border-gray-300 rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Receipt Number</label>
                        <input type="text" name="receipt_number" 
                               class="w-full border-gray-300 rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Pay Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
