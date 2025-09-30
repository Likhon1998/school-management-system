<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gradient-to-r from-green-100 to-green-50 p-4 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold text-green-800 flex items-center gap-2">🛡️ Roles</h2>
            @can('create roles')
                <a href="{{ route('roles.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-md transition">
                   + Create Role
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="bg-gray-50 py-10 px-4 flex justify-center">
        <div class="w-full max-w-6xl">

            <!-- Success / Error Messages -->
            <x-message></x-message>

            <!-- Roles Table Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-green-100 text-green-800 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-center">ID</th>
                            <th class="px-6 py-3">Role Name</th>
                            <th class="px-6 py-3">Permissions</th>
                            <th class="px-6 py-3">Created</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($roles as $role)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-6 py-4 text-center font-medium text-gray-700">{{ $role->id }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $role->name }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                    {{ $role->permissions->pluck('name')->implode(', ') ?: '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ \Carbon\Carbon::parse($role->created_at)->format('F j, Y') }}
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-3">

                                @can('edit roles')
                                <a href="{{ route('roles.edit', $role->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg shadow transition">
                                   ✏️ Edit
                                </a>
                                @endcan

                                @can('delete roles')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-4 py-1.5 rounded-lg shadow transition">
                                            🗑️ Delete
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                No roles found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $roles->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
