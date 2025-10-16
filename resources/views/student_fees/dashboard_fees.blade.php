<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Fees
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($studentFees->isEmpty())
                        <p class="text-gray-500">No fees found.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left">Fee Type</th>
                                    <th class="px-4 py-2 text-left">Amount</th>
                                    <th class="px-4 py-2 text-left">Paid</th>
                                    <th class="px-4 py-2 text-left">Due</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($studentFees as $fee)
                                    <tr>
                                        <td class="px-4 py-2">{{ ucfirst($fee->feeStructure->fee_type) }}</td>
                                        <td class="px-4 py-2">${{ number_format($fee->amount, 2) }}</td>
                                        <td class="px-4 py-2">${{ number_format($fee->amount_paid, 2) }}</td>
                                        <td class="px-4 py-2">${{ number_format($fee->amount - $fee->amount_paid, 2) }}</td>
                                        <td class="px-4 py-2">
                                            @if($fee->status == 'pending')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Pending</span>
                                            @elseif($fee->status == 'partial')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Partial</span>
                                            @else
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Paid</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="{{ route('student_fees.show', $fee->id) }}" 
                                               class="px-2 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 text-xs">
                                               View / Pay
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $studentFees->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
