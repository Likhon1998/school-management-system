<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="font-semibold text-lg text-gray-700 leading-tight">
                Add Fee Structure
            </h2>
            <a href="{{ route('fee_structures.index') }}" 
               class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
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

            <div class="bg-white shadow rounded-lg p-4 sm:p-6">
                <form action="{{ route('fee_structures.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                            <select name="class_id" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Academic Year</label>
                            <select name="academic_year_id" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                                <option value="">Select Year</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fee Type</label>
                            <select name="fee_type" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" required>
                                <option value="">Select Fee Type</option>
                                @foreach(['monthly','admission','exam','annual'] as $type)
                                    <option value="{{ $type }}" {{ old('fee_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                            <select name="month" class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none">
                                <option value="">Select Month</option>
                                @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $month)
                                    <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Exam Name</label>
                            <input type="text" name="exam_name" value="{{ old('exam_name') }}" 
                                   class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" 
                                   placeholder="Optional exam name">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="description" value="{{ old('description') }}" 
                                   class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none" 
                                   placeholder="Optional description">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                                   class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                            <input type="date" name="due_date" value="{{ old('due_date') }}"
                                   class="w-full border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-300 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" 
                                class="px-6 py-2 bg-green-200 text-green-800 rounded hover:bg-green-300 text-sm font-medium">
                            Save Fee Structure
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
