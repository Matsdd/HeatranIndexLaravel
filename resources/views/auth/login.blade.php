@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gray-800 text-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Login</h2>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-200 mb-2">Email</label>
                <input id="email" type="email" class="form-control w-full p-3 border border-gray-300 rounded-md text-black" name="email" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-200 mb-2">Password</label>
                <input id="password" type="password" class="form-control w-full p-3 border border-gray-300 rounded-md text-black" name="password" required>
            </div>
            <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors duration-200">
                Login
            </button>
        </form>
    </div>
@endsection
