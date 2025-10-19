<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-800 tracking-tight">
                👥 Manage Users
            </h2>
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md shadow transition">
                ➕ Add User
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-300 text-green-800 text-sm px-4 py-2 rounded-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="border-b px-4 py-2 text-left">#</th>
                                <th class="border-b px-4 py-2 text-left">Photo</th>
                                <th class="border-b px-4 py-2 text-left">Username</th>
                                <th class="border-b px-4 py-2 text-left">Email</th>
                                <th class="border-b px-4 py-2 text-left">Role</th>
                                <th class="border-b px-4 py-2 text-left">Status</th>
                                <th class="border-b px-4 py-2 text-left">Full Name</th>
                                <th class="border-b px-4 py-2 text-center w-40">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition border-b">
                                    <td class="px-4 py-2 align-middle">{{ $user->id }}</td>
                                    <td class="px-4 py-2 align-middle">
                                        <img 
                                            src="{{ optional($user->profile)->photo 
                                                ? asset('storage/profiles/' . optional($user->profile)->photo)
                                                : asset('images/default-profile.png') }}"
                                            alt="Profile"
                                            class="w-10 h-10 rounded-full border border-gray-300 object-cover mx-auto">
                                    </td>
                                    <td class="px-4 py-2 align-middle font-medium text-gray-800">{{ $user->username }}</td>
                                    <td class="px-4 py-2 align-middle text-gray-600">{{ $user->email }}</td>
                                    <td class="px-4 py-2 align-middle capitalize">{{ $user->role }}</td>
                                    <td class="px-4 py-2 align-middle">
                                        @if($user->status === 'active')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 align-middle">
                                        {{ optional($user->profile)->first_name ?? '-' }} {{ optional($user->profile)->last_name ?? '' }}
                                    </td>
                                    <td class="px-4 py-2 align-middle text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('users.show', $user->id) }}" 
                                               class="px-2 py-1 bg-gray-500 hover:bg-gray-600 text-white text-xs rounded shadow-sm transition">
                                                View
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}" 
                                               class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded shadow-sm transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded shadow-sm transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t bg-gray-50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
