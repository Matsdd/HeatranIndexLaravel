@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Discover Pokémon Cards</h2>

        @if(session('success'))
            <script>
                window.onload = function() {
                    alert("{{ session('success') }}");
                };
            </script>
        @endif

        <div class="relative inline-block text-left mb-4">
            <div>
                <button type="button" class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="true">
                    Filter Options
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="absolute right-0 z-10 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" id="filterMenu">
                <form method="GET" action="{{ route('cards.discover') }}" class="p-4">
                    <div class="form-group mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Filter by Type</label>
                        <input type="text" id="type" name="type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Fire, Water" value="{{ request('type') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="rarity" class="block text-sm font-medium text-gray-700">Filter by Rarity</label>
                        <input type="text" id="rarity" name="rarity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Rare, Common" value="{{ request('rarity') }}">
                    </div>
                    <!-- Add more filter options here -->
                    <button type="submit" class="mt-2 w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Filter</button>
                </form>
            </div>
        </div>

        <h3 class="text-xl font-semibold mt-4">Card Results</h3>
        @if($cards->isEmpty())
            <p>No cards found.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($cards as $card)
                    <div class="bg-gray-900 border rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-200">
                        <a href="#" class="block p-4 card-link" data-card-id="{{ $card->id }}">
                            <strong class="block text-lg text-white">{{ $card->name }}</strong>
                            <span class="block text-sm text-gray-400">{{ $card->Rarity }}</span>
                            <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->name }}" class="w-full h-auto mt-2">
                        </a>
                    </div>
                @endforeach
            </div>


        @endif

        <!-- Card Detail Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="cardDetailModal">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg w-11/12 md:w-1/2">
                <div class="flex justify-between items-center p-4 border-b">
                    <h5 class="text-lg font-bold" id="cardTitle"></h5>
                    <button type="button" class="text-gray-600 hover:text-gray-800" onclick="closeModal()">&times;</button>
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

                // Toggle the dropdown menu
                document.getElementById('options-menu').addEventListener('click', function () {
                    const filterMenu = document.getElementById('filterMenu');
                    filterMenu.classList.toggle('hidden');
                });
            });
        </script>
    </div>
@endsection
