<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Edit Fee Payment - {{ $student->student_name }}
            </h2>
            <a href="{{ route('fee_payments.index') }}"
               class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm font-medium">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-3 p-3 bg-red-100 text-red-700 rounded text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg p-4 sm:p-6">
                <form action="{{ route('fee_payments.updateMultiple', $student->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Total Dues Display -->
                    @php
                        $totalDue = $studentPayments->sum('due');
                    @endphp
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Dues</label>
                        <input type="number" id="total-dues" value="{{ $totalDue }}" class="w-full border-gray-300 rounded bg-gray-100 text-sm" readonly>
                    </div>

                    <!-- Payment Input -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Enter Payment Amount</label>
                        <input type="number" name="amount_paids[]" id="payment-input" step="0.01" min="0" max="{{ $totalDue }}" value="{{ $totalDue }}" class="w-full border-gray-300 rounded text-sm" required>
                        <input type="hidden" name="fee_structure_ids[]" value="0"> <!-- dummy id for total dues -->
                    </div>

                    <!-- Global Payment Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Payment Date</label>
                            <input type="date" name="payment_date_global" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Payment Method</label>
                            <select name="payment_method_global" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                                @foreach(['cash','bank','mobile_banking'] as $method)
                                    <option value="{{ $method }}">{{ ucfirst(str_replace('_',' ',$method)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-6 py-2 bg-green-200 text-green-800 rounded hover:bg-green-300 text-sm font-medium">
                            Update Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
