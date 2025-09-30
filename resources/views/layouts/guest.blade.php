<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>School Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-b from-indigo-100 via-white to-pink-100 min-h-screen">

    <!-- Header -->
        <header class="w-full bg-green-200 shadow-md py-4">
            <div class="max-w-7xl mx-auto px-6 flex justify-center">
                <h1 class="text-green-800 text-2xl font-bold">School Management System</h1>
            </div>
        </header>

    <!-- Main Content -->
    <main >
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-10 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} School Management System. All rights reserved.
    </footer>

</body>
</html>
