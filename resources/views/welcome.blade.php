<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="shortcut icon" href="{{  asset('storage/isa.png') }}" type="image/png">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-isa">
            <nav class="fixed top-0 h-16 p-6 z-20 flex items-center justify-between bg-blue-900 shadow-lg w-full rounded-b-2xl">
                <div class="flex gap-4">
                    <img src="{{ asset('storage/um.png') }}" alt="UM" class="h-10">
                    <img src="{{ asset('storage/oia.png') }}" alt="OIA" class="h-10">
                    <img src="{{ asset('storage/isa.png') }}" alt="UM Intl Student Association" class="h-10">
                </div>

                @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm dark:text-gray-200 underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm dark:text-gray-200 underline">Log in</a>
    
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm dark:text-gray-200 underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>

            <livewire:statistics />

            @livewireScripts
        </div>
    </body>
</html>
