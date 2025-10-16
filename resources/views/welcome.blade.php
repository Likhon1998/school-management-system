<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased bg-gray-50">

    <!-- Navigation -->
    <header class="bg-gradient-to-r from-green-400 via-green-300 to-green-200 shadow">
        <div class="container mx-auto flex justify-between items-center p-6">
            <div class="text-2xl font-bold text-gray-900">School Management System</div>
            <div class="space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-white text-green-600 font-semibold px-4 py-2 rounded shadow hover:bg-gray-100 transition duration-300">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-green-600 font-semibold px-4 py-2 rounded shadow hover:bg-gray-100 transition duration-300">Login</a>

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-white text-green-600 font-semibold px-4 py-2 rounded shadow hover:bg-gray-100 transition duration-300">Register</a>
                        @endif --}}
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-green-300 via-green-200 to-green-100 py-36 relative overflow-hidden">
        <div class="container mx-auto text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 text-gray-900 animate-fadeIn">Welcome to Our School</h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-800 animate-fadeIn delay-200">Empowering students with knowledge, creativity, and discipline.</p>
            <a href="#about" class="bg-green-600 text-white font-semibold px-6 py-3 rounded shadow hover:bg-green-700 transition duration-300 animate-fadeIn delay-400">Learn More</a>
        </div>

        <!-- Decorative Shapes -->
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-green-200 rounded-full opacity-30 animate-pulse-slow"></div>
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-green-300 rounded-full opacity-20 animate-pulse-slow"></div>
    </section>

    <!-- Features Section -->
    <section id="about" class="py-20 bg-gray-100">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-center mb-12 text-gray-900">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded shadow text-center hover:shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Students</h3>
                    <p class="text-gray-700">Manage student enrollment, profiles, and progress easily.</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center hover:shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Teachers</h3>
                    <p class="text-gray-700">Maintain teacher profiles, schedules, and performance records.</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center hover:shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Classes</h3>
                    <p class="text-gray-700">Organize classes, subjects, and timetables efficiently.</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center hover:shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Library</h3>
                    <p class="text-gray-700">Manage books, resources, and student borrowing records.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-400 via-green-300 to-green-200 text-gray-900 py-6 mt-12">
        <div class="container mx-auto text-center">
            &copy; 2025 School Management System. All rights reserved.
        </div>
    </footer>

    <style>
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 1s forwards; }
        .animate-fadeIn.delay-200 { animation-delay: 0.2s; }
        .animate-fadeIn.delay-400 { animation-delay: 0.4s; }

        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }
        .animate-pulse-slow { animation: pulse-slow 8s ease-in-out infinite; }
    </style>

</body>
</html>
