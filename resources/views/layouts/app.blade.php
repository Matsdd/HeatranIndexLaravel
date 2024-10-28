<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-800 text-white">
<div id="app">
    <nav class="bg-gray-900 p-4 border-b border-white">
        <ul class="flex justify-center space-x-8 text-gray-200 font-semibold text-lg">
            @auth
                <li>
                    <a href="{{ route('profile') }}" class="px-4 py-2 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                        Binder
                    </a>
                </li>
                <li>
                    <a href="{{ route('cards.create') }}" class="px-4 py-2 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                        Create
                    </a>
                </li>
                <li>
                    <a href="{{ route('cards.discover') }}" class="px-4 py-2 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                        Discover
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}" class="px-4 py-2 border border-black rounded hover:border-white transition-colors duration-200">
                        Login
                    </a>
                </li>
            @endauth
        </ul>
    </nav>



    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
