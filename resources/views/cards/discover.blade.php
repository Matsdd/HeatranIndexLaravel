@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Discover Pokémon Cards</h2>

        @if(session('success'))
            <script>
                window.onload = function() {
                    alert("{{ session('success') }}");
                };
            </script>
        @endif

        <form method="GET" action="{{ route('cards.discover') }}">
            <div class="form-group">
                <label for="type">Filter by Type</label>
                <input type="text" id="type" name="type" class="form-control" placeholder="e.g., Fire, Water" value="{{ request('type') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <h3 class="mt-4">Card Results</h3>
        @if($cards->isEmpty())
            <p>No cards found.</p>
        @else
            <ul>
                @foreach($cards as $card)
                    <li>
                        <a href="#" class="card-link" data-card-id="{{ $card->id }}">
                            <strong>{{ $card->name }}</strong> ({{ $card->Rarity }})
                            <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->name }}" class="card-image">
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Card Detail Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="cardDetailModal">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg w-11/12 md:w-1/2">
                <div class="flex justify-between items-center p-4 border-b">
                    <h5 class="text-lg font-bold" id="cardTitle"></h5>
                    <button type="button" class="text-gray-600 hover:text-gray-800" onclick="closeModal()">
                        &times;
                    </button>
                </div>
                <div class="p-4">
                    <p id="cardDetails" class="mb-4"></p>
                    <img id="cardImage" src="" alt="" class="w-full h-auto mb-4">
                    <div class="flex justify-between">
                        <button id="favoriteButton" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Favorite</button>
                        <button id="unfavoriteButton" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 hidden">Unfavorite</button>
                    </div>
                </div>
            </div>
        </div>



        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cardLinks = document.querySelectorAll('.card-link');
            const modal = document.getElementById('cardDetailModal');

            cardLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const cardId = this.getAttribute('data-card-id');
                    fetchCardDetails(cardId);
                });
            });

            function fetchCardDetails(cardId) {
                fetch(`/cards/${cardId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('cardTitle').innerText = data.name;
                        document.getElementById('cardDetails').innerText = `Rarity: ${data.Rarity}, Type: ${data.type}, Language: ${data.Language}, Era: ${data.Era}`;
                        document.getElementById('cardImage').src = `/storage/cards/${data.image_path}`;

                        // Set up favorite and unfavorite buttons
                        const favoriteButton = document.getElementById('favoriteButton');
                        const unfavoriteButton = document.getElementById('unfavoriteButton');

                        // Change button visibility based on favorite status (optional)
                        if (data.is_favorited) {
                            favoriteButton.style.display = 'none';
                            unfavoriteButton.style.display = 'block';
                        } else {
                            favoriteButton.style.display = 'block';
                            unfavoriteButton.style.display = 'none';
                        }

                        favoriteButton.onclick = function () {
                            fetch(`/cards/${cardId}/favorite`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                                .then(response => {
                                    if (response.ok) {
                                        alert('Card added to favorites!');
                                        favoriteButton.style.display = 'none';
                                        unfavoriteButton.style.display = 'block';
                                    }
                                });
                        };

                        unfavoriteButton.onclick = function () {
                            fetch(`/cards/${cardId}/unfavorite`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                                .then(response => {
                                    if (response.ok) {
                                        alert('Card removed from favorites.');
                                        favoriteButton.style.display = 'block';
                                        unfavoriteButton.style.display = 'none';
                                    }
                                });
                        };

                        modal.style.display = 'block'; // Show the modal
                    })
                    .catch(error => console.error('Error fetching card details:', error));
            }

            // Optional: Add an event listener to close the modal when clicking outside of it
            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
@endsection
