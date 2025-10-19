<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Add Fee Payment
            </h2>
            <a href="{{ route('fee_payments.index') }}"
               class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm font-medium">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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
                <form action="{{ route('fee_payments.storeTotal') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Select Student -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                        <select id="student-select" name="student_id" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->student_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Total Due Display -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Due</label>
                        <input type="text" id="total-due" class="w-full border-gray-300 rounded bg-gray-100 text-sm" value="0" readonly>
                    </div>

                    <!-- Payment Amount -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pay Amount</label>
                        <input type="number" name="amount_paid" id="amount-paid" step="0.01" min="0" class="w-full border-gray-300 rounded text-sm" required>
                    </div>

                    <!-- Payment Date -->
                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-1">Payment Date</label>
                        <input type="date" name="payment_date" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <!-- Payment Method -->
                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                            @foreach(['cash','bank','mobile_banking'] as $method)
                                <option value="{{ $method }}">{{ ucfirst(str_replace('_',' ',$method)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Remarks -->
                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-1">Remarks</label>
                        <textarea name="remarks" class="w-full border-gray-300 rounded text-sm" rows="2"></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-6 py-2 bg-green-200 text-green-800 rounded hover:bg-green-300 text-sm font-medium">
                            Add Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- AJAX to fetch total dues -->
    <script>
        const studentSelect = document.getElementById('student-select');
        const totalDueInput = document.getElementById('total-due');
        const amountPaidInput = document.getElementById('amount-paid');

        studentSelect.addEventListener('change', function() {
            const studentId = this.value;

            if (!studentId) {
                totalDueInput.value = 0;
                amountPaidInput.value = '';
                return;
            }

            fetch(`/fee_payments/student-dues/${studentId}`)
                .then(res => res.json())
                .then(data => {
                    totalDueInput.value = data.total_due.toFixed(2);
                    amountPaidInput.max = data.total_due;
                    amountPaidInput.value = data.total_due; // default full payment
                })
                .catch(err => console.error(err));
        });
    </script>
</x-app-layout>
