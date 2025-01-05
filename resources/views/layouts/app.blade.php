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
        <ul class="flex items-center justify-between text-gray-200 font-semibold text-lg">
            <!-- Left side of the navbar -->
            <div class="flex space-x-8">
                @auth
                    <li>
                        <a href="{{ route('profile') }}" class="px-10 py-4 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                            Binder
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cards.create') }}" class="px-10 py-4 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                            Create
                        </a>
                    </li>
                    <!-- Admin Button, visible only for admin users -->
                    @if(auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.users') }}" class="px-10 py-4 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                                Admin
                            </a>
                        </li>
                    @endif
                @endauth
            </div>

            <!-- Centered Pokéball icon -->
            <li class="flex justify-center">
                <a href="{{ route('cards.discover') }}">
                    <img src="{{ asset('images/PokeBall.png') }}" alt="Discover" class="w-20 h-20">
                </a>
            </li>

            <!-- Right side of the navbar -->
            <div class="flex items-center space-x-8">
                @auth
                    <li class="flex items-center space-x-4">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ route('profile.picture', ['filename' => auth()->user()->profile_picture]) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
                        @endif
                        <span class="text-white">Welcome, {{ auth()->user()->name }}!</span>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-10 py-4 bg-gray-800 border border-black rounded hover:border-white transition-colors duration-200">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <!-- Show Login and Register links if not authenticated -->
                    <li>
                        <a href="{{ route('login') }}" class="px-10 py-4 border border-black rounded hover:border-white transition-colors duration-200">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="px-10 py-4 border border-black rounded hover:border-white transition-colors duration-200">
                            Register
                        </a>
                    </li>
                @endauth
            </div>
        </ul>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
