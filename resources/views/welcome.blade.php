<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IoT LED Controller</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 dark:bg-zinc-900 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-2xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">IoT LED Controller</h1>
            <p class="text-gray-600 dark:text-gray-400">Control your ESP8266 LED from anywhere</p>
        </div>

        <!-- LED Control Component -->
        @livewire('led-control')

        <!-- Auth Links -->
        @if (Route::has('login'))
            <div class="mt-8 text-center">
                <nav class="flex items-center justify-center gap-4 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        @endif
    </div>
    @livewireScripts
</body>
</html>
