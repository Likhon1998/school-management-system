<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Users</h2>
            <a href="{{ route('users.create') }}" 
               class="bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium px-3 py-1.5 rounded shadow transition">
               ➕ Add User
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border px-3 py-2">ID</th>
                            <th class="border px-3 py-2">Photo</th>
                            <th class="border px-3 py-2">Username</th>
                            <th class="border px-3 py-2">Email</th>
                            <th class="border px-3 py-2">Role</th>
                            <th class="border px-3 py-2">Status</th>
                            <th class="border px-3 py-2">Full Name</th>
                            <th class="border px-3 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="border px-3 py-2">{{ $user->id }}</td>
                            <td class="border px-3 py-2">
                                <img 
                                    src="{{ optional($user->profile)->photo 
                                        ? asset('storage/' . ltrim(optional($user->profile)->photo, '/')) 
                                        : asset('images/default-profile.png') }}" 
                                    alt="Profile Photo" 
                                    class="w-10 h-10 rounded-full object-cover border border-gray-300">
                            </td>
                            <td class="border px-3 py-2">{{ $user->username }}</td>
                            <td class="border px-3 py-2">{{ $user->email }}</td>
                            <td class="border px-3 py-2 capitalize">{{ $user->role }}</td>
                            <td class="border px-3 py-2 capitalize">{{ $user->status }}</td>
                            <td class="border px-3 py-2">
                                {{ optional($user->profile)->first_name ?? '-' }} {{ optional($user->profile)->last_name ?? '' }}
                            </td>
                            <td class="border px-3 py-2 flex gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">Delete</button>
                                </form>
                                <a href="{{ route('users.show', $user->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 rounded text-xs">Show</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
