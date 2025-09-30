<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Add Teacher</h2>
            <a href="{{ route('teachers.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">

            <!-- ✅ Add enctype for file upload -->
            <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Teacher Name -->
                    <div>
                        <label class="block text-gray-700 font-medium">Teacher Name</label>
                        <input type="text" name="teacher_name" value="{{ old('teacher_name') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('teacher_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employee ID -->
                    <div>
                        <label class="block text-gray-700 font-medium">Employee ID</label>
                        <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('employee_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Joining Date -->
                    <div>
                        <label class="block text-gray-700 font-medium">Joining Date</label>
                        <input type="date" name="joining_date" value="{{ old('joining_date') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('joining_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Designation -->
                    <div>
                        <label class="block text-gray-700 font-medium">Designation</label>
                        <input type="text" name="designation" value="{{ old('designation') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('designation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Qualification -->
                    <div>
                        <label class="block text-gray-700 font-medium">Qualification</label>
                        <input type="text" name="qualification" value="{{ old('qualification') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('qualification')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience -->
                    <div>
                        <label class="block text-gray-700 font-medium">Experience (yrs)</label>
                        <input type="number" name="experience" value="{{ old('experience') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div>
                        <label class="block text-gray-700 font-medium">Salary</label>
                        <input type="number" step="0.01" name="salary" value="{{ old('salary') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('salary')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 font-medium">Status</label>
                        <select name="status" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="resigned" {{ old('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assign User -->
                    <div>
                        <label class="block text-gray-700 font-medium">Assign User</label>
                        <select name="user_id" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photo -->
                    <div>
                        <label class="block text-gray-700 font-medium">Photo</label>
                        <input type="file" name="photo" accept="image/*"
                               class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('photo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-4 flex justify-end gap-3">
                    <a href="{{ route('teachers.index') }}"
                       class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-800 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 rounded bg-blue-500 hover:bg-blue-600 text-white font-semibold transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
