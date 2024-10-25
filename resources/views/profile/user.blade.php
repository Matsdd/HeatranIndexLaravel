@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $user->name }}'s Profile</h2>
        <h3>Profile Picture</h3>
        @if($user->profile_picture)
            <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}" class="img-fluid">
        @else
            <p>No profile picture uploaded</p>
        @endif

        <h3>Favorite Cards</h3>
        <ul>
            @forelse ($user->favoriteCards as $card)
                    <li>
                        <a href="#" class="card-link" data-card-id="{{ $card->id }}">
                            <strong>{{ $card->name }}</strong> ({{ $card->Rarity }})
                            <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->name }}" class="card-image">
                        </a>
                    </li>
            @empty
                <li>No favorite cards yet.</li>
            @endforelse
        </ul>
    </div>
@endsection
