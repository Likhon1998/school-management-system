<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Edit Fee Payments
            </h2>
            <a href="{{ route('fee_payments.index') }}"
               class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm font-medium">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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
                <form action="{{ route('fee_payments.updateMultiple', ['student' => $student->id]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Student (readonly) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                        <input type="text" value="{{ $student->student_name }}" readonly
                               class="w-full border-gray-300 rounded bg-gray-100 text-sm">
                    </div>

                    <!-- Payment Rows -->
                    <div id="payments-container" class="space-y-2">
                        @foreach($studentPayments as $payment)
                        @php
                            $fee = $payment['fee_structure'];
                            $paid = $payment['paid'];
                            $due = $payment['due'];
                            $description = $fee->description ?? '';
                        @endphp
                        <div class="payment-row grid grid-cols-1 md:grid-cols-7 gap-2 items-end border p-3 rounded text-sm">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Fee Structure</label>
                                <select name="fee_structure_ids[]" class="fee-select w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                                    <option value="">Select Fee Structure</option>
                                    @foreach($feeStructures as $structure)
                                        <option value="{{ $structure->id }}"
                                            data-month="{{ $structure->month }}"
                                            data-exam="{{ $structure->exam_name }}"
                                            data-description="{{ $structure->description }}"
                                            data-amount="{{ $structure->amount }}"
                                            {{ $structure->id == $fee->id ? 'selected' : '' }}>
                                            {{ ucfirst($structure->fee_type) }} - {{ $structure->month }} {{ $structure->exam_name }} - {{ number_format($structure->amount, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Amount Due</label>
                                <input type="number" name="amount_dues[]" class="amount-due w-full border-gray-300 rounded bg-gray-100 text-sm" value="{{ $due }}" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Month / Exam</label>
                                <input type="text" name="month_exams[]" class="month-exam w-full border-gray-300 rounded bg-gray-100 text-sm" value="{{ $fee->month }} {{ $fee->exam_name }}" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Description</label>
                                <input type="text" name="descriptions[]" class="description w-full border-gray-300 rounded bg-gray-100 text-sm" value="{{ $description }}" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Amount Paid</label>
                                <input type="number" step="0.01" name="amount_paids[]" class="amount-paid w-full border-gray-300 rounded text-sm" value="{{ $due }}" required readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Remaining Dues</label>
                                <input type="number" name="remaining_dues[]" class="remaining-dues w-full border-gray-300 rounded bg-gray-100 text-sm" value="0" readonly>
                            </div>

                            <div class="flex gap-2">
                                <button type="button" class="add-row px-3 py-1.5 bg-green-200 text-green-800 rounded hover:bg-green-300 text-sm font-medium">+</button>
                                <button type="button" class="remove-row px-3 py-1.5 bg-red-200 text-red-800 rounded hover:bg-red-300 text-sm font-medium">−</button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Global Payment Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Payment Date</label>
                            <input type="date" name="payment_date_global" value="{{ $studentPayments[0]['payment_record']->payment_date ?? '' }}" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Payment Method</label>
                            <select name="payment_method_global" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                                @foreach(['cash','bank','mobile_banking'] as $method)
                                    @php
                                        $currentMethod = $studentPayments[0]['payment_record']->payment_method ?? '';
                                    @endphp
                                    <option value="{{ $method }}" {{ $currentMethod == $method ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ',$method)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Status</label>
                            <select name="status_global" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                                <option value="paid" selected>Paid</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-6 py-2 bg-green-200 text-green-800 rounded hover:bg-green-300 text-sm font-medium">
                            Update Payments
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('payments-container');

        // Add/Remove rows
        container.addEventListener('click', function(e) {
            if(e.target.classList.contains('add-row')) {
                const row = e.target.closest('.payment-row');
                const clone = row.cloneNode(true);
                clone.querySelectorAll('select, input').forEach(input => {
                    if(input.tagName === 'SELECT') input.selectedIndex = 0;
                    else input.value = '';
                });
                container.appendChild(clone);
            }
            if(e.target.classList.contains('remove-row')) {
                if(container.querySelectorAll('.payment-row').length > 1) e.target.closest('.payment-row').remove();
            }
        });

        // Fill amount due and enforce full payment
        container.addEventListener('change', function(e) {
            if(e.target.classList.contains('fee-select')) {
                const row = e.target.closest('.payment-row');
                const select = row.querySelector('.fee-select');
                const amountDueInput = row.querySelector('.amount-due');
                const amountPaidInput = row.querySelector('.amount-paid');
                const remainingInput = row.querySelector('.remaining-dues');
                const selectedOption = select.options[select.selectedIndex];

                let totalAmount = parseFloat(selectedOption.dataset.amount || 0);

                // Full payment only
                amountDueInput.value = totalAmount.toFixed(2);
                amountPaidInput.value = totalAmount.toFixed(2);
                row.querySelector('.month-exam').value = `${selectedOption.dataset.month || ''} ${selectedOption.dataset.exam || ''}`;
                row.querySelector('.description').value = selectedOption.dataset.description || '';
                remainingInput.value = 0;
            }
        });
    </script>
</x-app-layout>
