@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">{{ $user->name }}'s Profile</h2>

        <h3 class="text-xl font-semibold mb-2">Profile Picture</h3>
        @if($user->profile_picture)
            <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}" class="rounded-full w-32 h-32 object-cover mb-4">
        @else
            <p class="text-gray-400">No profile picture uploaded</p>
        @endif

        <h3 class="text-xl font-semibold mb-2">Favorite Cards</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($user->favoriteCards as $card)
                <div class="bg-gray-900 border rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-200">
                    <a href="#" class="block p-4 card-link" data-card-id="{{ $card->id }}">
                        <strong class="block text-lg text-white">{{ $card->name }}</strong>
                        <span class="block text-sm text-gray-300">{{ $card->Rarity }}</span>
                        <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->name }}" class="w-full h-auto mt-2">
                    </a>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center text-gray-400">
                    No favorite cards yet.
                </div>
            @endforelse
        </div>
    </div>
@endsection
