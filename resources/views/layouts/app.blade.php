<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
       @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-100 to-blue-100">
        <div class="p-4">
            <!-- Page Content with Sidebar -->
            <div class="flex gap-4 max-w-full">
                @include('layouts.sidebar')
                <main class="flex-1 p-6 bg-white rounded shadow">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
