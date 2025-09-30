<x-app-layout>
    <x-slot name="header">
        <div class="bg-green-100 shadow p-4 rounded-lg">
            <h2 class="font-semibold text-xl text-green-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>
    <div > 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->username }}!</h1>
                <p class="text-gray-700">This is your dashboard. You can manage your school data from the sidebar menu.</p>
            </div>
        </div>
    </div>
</x-app-layout>
