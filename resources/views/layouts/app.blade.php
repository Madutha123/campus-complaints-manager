<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CampusTrack') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900 flex flex-col min-h-[100vh]">
    <!-- Top Navbar -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand -->
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-900">CampusTrack</span>
                </div>

                <!-- User Nav -->
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800 transition">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-grow flex flex-col w-full">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
