<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gradient-to-b from-green-100 to-green-50 text-gray-800 flex-shrink-0 shadow-lg overflow-y-auto">
        <div class="p-6 flex flex-col h-full">

            {{-- Profile --}}
            <div class="flex flex-col items-center mb-6">
                <img 
                    src="{{ Auth::user()->profile && Auth::user()->profile->photo ? asset('storage/profiles/' . Auth::user()->profile->photo) : asset('images/default-avatar.png') }}" 
                    alt=""
                    class="w-16 h-16 rounded-full border-2 border-green-200 shadow-sm object-cover">
                <h2 class="text-md font-semibold text-gray-800 mt-2">{{ Auth::user()->username }}</h2>
                <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                <p class="text-xs uppercase mt-1 text-gray-500">{{ Auth::user()->role ?? 'User' }}</p>
            </div>

            <div class="my-4 border-t border-green-300"></div>

            {{-- Menu --}}
            <nav class="flex-1">
                <ul class="space-y-1">

                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="home" class="w-4 h-4"></i>
                            <span class="ml-2">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('roles.index') }}" 
                            class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('roles.*') ? 'bg-green-200 font-semibold' : '' }}">
                                <i data-feather="shield" class="w-4 h-4"></i>
                                <span class="ml-2">Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('permissions.index') }}" 
                            class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('permissions.*') ? 'bg-green-200 font-semibold' : '' }}">
                                <i data-feather="lock" class="w-4 h-4"></i>
                                <span class="ml-2">Permissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" 
                            class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('users.*') ? 'bg-green-200 font-semibold' : '' }}">
                                <i data-feather="user" class="w-4 h-4"></i>
                                <span class="ml-2">Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('students.index') }}" 
                            class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('students.*') ? 'bg-green-200 font-semibold' : '' }}">
                                <i data-feather="users" class="w-4 h-4"></i>
                                <span class="ml-2">Students</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student_academic_history.index') }}" 
                            class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('student_academic_history.*') ? 'bg-green-200 font-semibold' : '' }}">
                                <i data-feather="book" class="w-4 h-4"></i>
                                <span class="ml-2">Student History</span>
                        </a>
                    </li>

                    {{-- Teachers --}}
                    <li>
                        <a href="{{ route('teachers.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('teachers.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="user-check" class="w-4 h-4"></i>
                            <span class="ml-2">Teachers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('teacher_subjects.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('teacher_subjects.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="book-open" class="w-4 h-4"></i>
                            <span class="ml-2">Teacher Subjects</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('class_teachers.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('class_teachers.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="users" class="w-4 h-4"></i>
                            <span class="ml-2">Class Teachers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student_attendance.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('student_attendance.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="check-square" class="w-4 h-4"></i>
                            <span class="ml-2">Student Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('teacher_attendance.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('teacher_attendance.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="check-square" class="w-4 h-4"></i>
                            <span class="ml-2">Teacher Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('examinations.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('examinations.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="file-text" class="w-4 h-4"></i>
                            <span class="ml-2">Examinations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exam_schedules.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('exam_schedules.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                            <span class="ml-2">Exam Schedules</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exam_results.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('exam_results.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="award" class="w-4 h-4"></i>
                            <span class="ml-2">Exam Results</span>
                        </a>            
                    </li>
                    <li>
                        <a href="{{ route('fee_structures.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('fee_structures.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="dollar-sign" class="w-4 h-4"></i>
                            <span class="ml-2">Fee Structures</span>
                        </a>            
                    </li>
                    <li>
                        <a href="{{ route('fee_payments.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('fee_payments.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="credit-card" class="w-4 h-4"></i>
                            <span class="ml-2">Fee Payments</span>
                        </a>            
                    </li>
                    <li>
                        <a href="{{ route('student_fees.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('student_fees.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="dollar-sign" class="w-4 h-4"></i>
                            <span class="ml-2">Student Fees</span>
                        </a>            
                    </li>
                    <li>
                        <a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 {{ request()->routeIs('expenses.*') ? 'bg-green-200 font-semibold' : '' }}">
                            <i data-feather="archive" class="w-4 h-4"></i>
                            <span class="ml-2">Expenses</span>
                        </a>            
                    </li>


                    {{-- Academic Structure Dropdown --}}
                    <li x-data="{ open: {{ request()->routeIs('academic_years.*') || request()->routeIs('classes.*') || request()->routeIs('sections.*') || request()->routeIs('subjects.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 focus:outline-none">
                            <div class="flex items-center">
                                <i data-feather="layers" class="w-4 h-4"></i>
                                <span class="ml-2 font-medium">Academic Structure</span>
                            </div>
                            <i data-feather="chevron-right" :class="{'rotate-90': open}" class="w-4 h-4 transform transition-transform duration-200"></i>
                        </button>
                        <ul x-show="open" x-transition class="mt-1 space-y-1 pl-8">
                            <li>
                                <a href="{{ route('academic_years.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('academic_years.*') ? 'bg-green-200 font-semibold' : '' }}">
                                    <i data-feather="calendar" class="w-4 h-4"></i>
                                    <span class="ml-2">Academic Year</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('classes.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('classes.*') ? 'bg-green-200 font-semibold' : '' }}">
                                    <i data-feather="book" class="w-4 h-4"></i>
                                    <span class="ml-2">Classes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('sections.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('sections.*') ? 'bg-green-200 font-semibold' : '' }}">
                                    <i data-feather="grid" class="w-4 h-4"></i>
                                    <span class="ml-2">Sections</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('subjects.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-green-100 transition-colors duration-200 {{ request()->routeIs('subjects.*') ? 'bg-green-200 font-semibold' : '' }}">
                                    <i data-feather="file-text" class="w-4 h-4"></i>
                                    <span class="ml-2">Subjects</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-6">
                        @csrf
                        <button type="submit" class="w-full px-2 py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold text-white transition transform hover:scale-105 shadow-sm">
                            <i data-feather="log-out" class="w-4 h-4 inline-block mr-1"></i>
                            Logout
                        </button>
                    </form>

                </ul>
            </nav>

        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">

        {{-- Header --}}
        @if(isset($header))
        <header class="bg-white shadow-sm px-6 py-4">
            <h1 class="text-xl font-semibold text-gray-700">{{ $header }}</h1>
        </header>
        @endif

        {{-- Full-width Main Content --}}
        <main class="flex-1 p-6 overflow-auto bg-gray-50">
            <div class="w-full h-full">
                {{ $slot }}
            </div>
        </main>

    </div>

</div>

<script>
    feather.replace() 
</script>

</body>
</html>
