<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                Edit Expense
            </h2>
            <a href="{{ route('expenses.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded shadow hover:bg-gray-300 transition">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Expense Category -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Category</label>
                        <input type="text" name="expense_category" value="{{ old('expense_category', $expense->expense_category) }}" 
                               class="w-full border-gray-300 rounded px-3 py-2" placeholder="e.g., Salary, Utilities">
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Amount</label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount', $expense->amount) }}" 
                               class="w-full border-gray-300 rounded px-3 py-2" placeholder="Enter amount">
                    </div>

                    <!-- Expense Date -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Date</label>
                        <input type="date" name="expense_date" value="{{ old('expense_date', $expense->expense_date) }}" 
                               class="w-full border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- Receipt Number -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Receipt / Voucher Number (Optional)</label>
                        <input type="text" name="receipt_number" value="{{ old('receipt_number', $expense->receipt_number) }}" 
                               class="w-full border-gray-300 rounded px-3 py-2" placeholder="Enter receipt number">
                    </div>

                    <!-- Approved By -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Approved By</label>
                        <select name="approved_by" class="w-full border-gray-300 rounded px-3 py-2">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ old('approved_by', $expense->approved_by) == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-700 transition">
                            Update
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
