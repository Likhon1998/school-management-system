<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Fee Payments
            </h2>
            <a href="{{ route('fee_payments.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('fee_payments.updateMultiple', ['student' => $student['id'] ?? $student->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Student -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Student</label>
                        <input type="text" value="{{ $student['student_name'] ?? $student->student_name }}" readonly
                               class="w-full border-gray-300 rounded bg-gray-100">
                    </div>

                    <!-- Payment Rows -->
                    <div class="space-y-4" id="payments-container">
                        @foreach($studentPayments as $payment)
                        @php
                            $paymentAmount = is_array($payment) ? ($payment['amount_paid'] ?? 0) : ($payment->amount_paid ?? 0);
                            $feeStructure = is_array($payment) ? ($payment['fee_structure'] ?? []) : ($payment->feeStructure ?? null);
                            $feeAmount = $feeStructure['amount'] ?? ($feeStructure->amount ?? 0);
                            $monthExam = ($feeStructure['month'] ?? ($feeStructure->month ?? '')) . ' ' . ($feeStructure['exam_name'] ?? ($feeStructure->exam_name ?? ''));
                            $description = $feeStructure['description'] ?? ($feeStructure->description ?? '');
                            $feeId = $feeStructure['id'] ?? ($feeStructure->id ?? '');
                        @endphp

                        <div class="payment-row grid grid-cols-1 md:grid-cols-7 gap-4 items-end border p-4 rounded">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Fee Structure</label>
                                <select name="fee_structure_ids[]" class="fee-select w-full border-gray-300 rounded" required>
                                    <option value="">Select Fee Structure</option>
                                    @foreach($feeStructures as $structure)
                                        <option value="{{ $structure['id'] ?? $structure->id }}"
                                            data-month="{{ $structure['month'] ?? $structure->month ?? '' }}"
                                            data-exam="{{ $structure['exam_name'] ?? $structure->exam_name ?? '' }}"
                                            data-description="{{ $structure['description'] ?? $structure->description ?? '' }}"
                                            data-amount="{{ $structure['amount'] ?? $structure->amount ?? 0 }}"
                                            {{ $feeId == ($structure['id'] ?? $structure->id) ? 'selected' : '' }}>
                                            {{ ucfirst($structure['fee_type'] ?? $structure->fee_type) }} - {{ $structure['month'] ?? $structure->month ?? '-' }} {{ $structure['exam_name'] ?? $structure->exam_name ?? '' }} - {{ number_format($structure['amount'] ?? $structure->amount ?? 0, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Amount Due</label>
                                <input type="number" name="amount_dues[]" class="amount-due w-full border-gray-300 rounded bg-gray-100" value="{{ $feeAmount }}" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Month / Exam</label>
                                <input type="text" name="month_exams[]" class="month-exam w-full border-gray-300 rounded bg-gray-100" value="{{ $monthExam }}" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Description</label>
                                <input type="text" name="descriptions[]" class="description w-full border-gray-300 rounded bg-gray-100" value="{{ $description }}" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Amount Paid</label>
                                <input type="number" step="0.01" name="amount_paids[]" class="amount-paid w-full border-gray-300 rounded" value="{{ $paymentAmount }}" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Remaining Dues</label>
                                <input type="number" name="remaining_dues[]" class="remaining-dues w-full border-gray-300 rounded bg-gray-100" value="{{ $feeAmount - $paymentAmount }}" readonly>
                            </div>

                            <div class="flex gap-2">
                                <button type="button" class="add-row px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">+</button>
                                <button type="button" class="remove-row px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">−</button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Global Payment Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Payment Date</label>
                            <input type="date" name="payment_date_global" value="{{ is_array($studentPayments[0] ?? null) ? ($studentPayments[0]['payment_date'] ?? '') : ($studentPayments[0]->payment_date ?? '') }}" class="w-full border-gray-300 rounded" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Payment Method</label>
                            <select name="payment_method_global" class="w-full border-gray-300 rounded" required>
                                @foreach(['cash','bank','mobile_banking'] as $method)
                                    @php
                                        $currentMethod = is_array($studentPayments[0] ?? null) ? ($studentPayments[0]['payment_method'] ?? '') : ($studentPayments[0]->payment_method ?? '');
                                    @endphp
                                    <option value="{{ $method }}" {{ $currentMethod == $method ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ',$method)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Status</label>
                            <select name="status_global" class="w-full border-gray-300 rounded" required>
                                @foreach(['paid','partial','pending'] as $status)
                                    @php
                                        $currentStatus = is_array($studentPayments[0] ?? null) ? ($studentPayments[0]['status'] ?? '') : ($studentPayments[0]->status ?? '');
                                    @endphp
                                    <option value="{{ $status }}" {{ $currentStatus == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Update Payments
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('payments-container');

        // Add/Remove rows dynamically
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
                if(container.querySelectorAll('.payment-row').length > 1) {
                    e.target.closest('.payment-row').remove();
                }
            }
        });

        // Fill data and calculate remaining dues
        container.addEventListener('change', function(e) {
            if(e.target.classList.contains('fee-select') || e.target.classList.contains('amount-paid')) {
                const row = e.target.closest('.payment-row');
                const select = row.querySelector('.fee-select');
                const amountDueInput = row.querySelector('.amount-due');
                const amountPaidInput = row.querySelector('.amount-paid');
                const remainingInput = row.querySelector('.remaining-dues');
                const selectedOption = select.options[select.selectedIndex];

                const totalAmount = parseFloat(selectedOption.dataset.amount || 0);
                const paidAmount = parseFloat(amountPaidInput.value || 0);

                amountDueInput.value = totalAmount.toFixed(2);
                remainingInput.value = (totalAmount - paidAmount).toFixed(2);

                row.querySelector('.month-exam').value = `${selectedOption.dataset.month || ''} ${selectedOption.dataset.exam || ''}`.trim();
                row.querySelector('.description').value = selectedOption.dataset.description || '';
            }
        });

        // Recalculate dues live on amount paid input
        container.addEventListener('input', function(e) {
            if(e.target.classList.contains('amount-paid')) {
                const row = e.target.closest('.payment-row');
                const total = parseFloat(row.querySelector('.amount-due').value || 0);
                const paid = parseFloat(e.target.value || 0);
                row.querySelector('.remaining-dues').value = (total - paid).toFixed(2);
            }
        });
    </script>
</x-app-layout>
