<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100">
<div id="app">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center">
            <a class="text-lg font-semibold text-gray-800" href="{{ url('/discover') }}">
                Discover
            </a>
            <a class="text-lg font-semibold text-gray-800" href="{{ url('/login') }}">
                Login
            </a>
            <a class="text-lg font-semibold text-gray-800" href="{{ url('/profile') }}">
                Binder
            </a>
            <a class="text-lg font-semibold text-gray-800" href="{{ url('/create') }}">
                Create
            </a>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
