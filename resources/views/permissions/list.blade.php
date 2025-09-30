<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gradient-to-r from-purple-200 to-purple-50 p-3 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold text-purple-900 flex items-center gap-2">🔐 Permissions</h2>
            @can('create permissions')
                <a href="{{ route('permissions.create') }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-3 py-1.5 rounded shadow transition text-sm">
                   + Create Permission
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6 px-4 bg-gray-50 flex justify-center">
        <div class="w-full max-w-6xl">

            <!-- Messages -->
            <x-message></x-message>

            <!-- Search Form -->
            <form action="{{ route('permissions.index') }}" method="GET" class="flex justify-end mb-4 gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name"
                       class="border rounded px-3 py-2 shadow-sm w-64 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded shadow">
                    Search
                </button>
            </form>

            <!-- Permissions Table -->
            <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-purple-100 text-purple-900 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-4 py-2 text-center">ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Created</th>
                                <th class="px-4 py-2">Updated</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($permissions as $permission)
                                <tr class="hover:bg-purple-50 transition">
                                    <td class="px-4 py-2 text-center text-gray-700 font-medium">{{ $permission->id }}</td>
                                    <td class="px-4 py-2 font-semibold text-gray-900">{{ $permission->name }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse($permission->created_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse($permission->updated_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-2 text-center flex justify-center gap-1">
                                        @can('edit permissions')
                                        <a href="{{ route('permissions.edit', $permission->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded shadow transition flex items-center gap-1">
                                           ✏️
                                        </a>
                                        @endcan

                                        @can('delete permissions')
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1 rounded shadow transition flex items-center gap-1">
                                                    🗑️
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        No permissions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 flex justify-center border-t border-gray-200">
                    {{ $permissions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
