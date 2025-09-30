<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                Expenses
            </h2>
            <a href="{{ route('expenses.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-700 transition">
               + Add Expense
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approved By</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $loop->iteration + ($expenses->currentPage()-1) * $expenses->perPage() }}</td>
                                <td class="px-6 py-3">{{ $expense->expense_category }}</td>
                                <td class="px-6 py-3">{{ number_format($expense->amount, 2) }}</td>
                                <td class="px-6 py-3">{{ \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') }}</td>
                                <td class="px-6 py-3">{{ $expense->receipt_number ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $expense->approver->username ?? '-' }}</td>
                                <td class="px-6 py-3 text-center space-x-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('expenses.edit', $expense->id) }}" 
                                       class="px-3 py-1 bg-green-600 text-white font-semibold rounded shadow hover:bg-green-700 transition">
                                       Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-600 text-white font-semibold rounded shadow hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No expenses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4 px-6">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
