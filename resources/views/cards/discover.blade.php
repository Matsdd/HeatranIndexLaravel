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

        <!-- Filter Options (Button & Menu) -->
        <div class="relative inline-block text-left mb-4">
            <button type="button" class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" id="options-menu" aria-haspopup="true" aria-expanded="true">
                Filter Options
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div class="absolute right-0 z-10 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" id="filterMenu">
                <form method="GET" action="{{ route('cards.discover') }}" class="p-4">
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Filter by Type</label>
                        <select id="type" name="type" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="rarity" class="block text-sm font-medium text-gray-700">Filter by Rarity</label>
                        <select id="rarity" name="rarity" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                            <option value="">Select Rarity</option>
                            @foreach($rarities as $rarity)
                                <option value="{{ $rarity }}" {{ request('rarity') === $rarity ? 'selected' : '' }}>{{ $rarity }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="set" class="block text-sm font-medium text-gray-700">Filter by Set</label>
                        <select id="set" name="set" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                            <option value="">Select Set</option>
                            @foreach($sets as $set)
                                <option value="{{ $set }}" {{ request('set') === $set ? 'selected' : '' }}>{{ $set }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="stamped" class="form-checkbox text-black" {{ request('stamped') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Stamped</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Filter</button>
                </form>
            </div>
        </div>

        <!-- Card Results Grid -->
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
            <div class="bg-gray-800 border border-white rounded-lg shadow-lg w-11/12 md:w-1/2">
                <div class="flex justify-between items-center p-4 border-b border-gray-700">
                    <h5 class="text-lg font-bold text-white" id="cardTitle"></h5>
                    <button type="button" class="text-gray-300 hover:text-gray-500" onclick="closeModal()">&times;</button>
                </div>
                <div class="p-4 text-gray-200">
                    <p id="cardDetails" class="mb-4"></p>
                    <img id="cardImage" src="" alt="" class="w-full h-auto mb-4">
                    <div class="flex justify-between">
                        <button id="favoriteButton" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 hidden" data-card-id="">Favorite</button>
                        <button id="unfavoriteButton" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 hidden" data-card-id="">Unfavorite</button>
                        <button id="editButton" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 hidden">Edit</button>
                        <button id="deleteButton" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 hidden">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('cardDetailModal');
                const cardLinks = document.querySelectorAll('.card-link');
                const cardTitle = document.getElementById('cardTitle');
                const cardDetails = document.getElementById('cardDetails');
                const cardImage = document.getElementById('cardImage');
                const editButton = document.getElementById('editButton');
                const deleteButton = document.getElementById('deleteButton');
                const favoriteButton = document.getElementById('favoriteButton');
                const unfavoriteButton = document.getElementById('unfavoriteButton');
                const closeButton = document.querySelector('.text-gray-300'); // Close button in modal

                // Attach click events to open card details modal
                cardLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const cardId = this.getAttribute('data-card-id');
                        openCardModal(cardId);
                    });
                });

                // Function to open the modal and load card details
                function openCardModal(cardId) {
                    fetch(`/cards/${cardId}`)
                        .then(response => response.json())
                        .then(data => {
                            cardTitle.innerText = data.name;
                            cardDetails.innerText = `Rarity: ${data.Rarity}, Type: ${data.type}, Language: ${data.Language}, Era: ${data.Era}`;
                            cardImage.src = `/storage/cards/${data.image_path}`;

                            // Set card ID on buttons
                            favoriteButton.setAttribute('data-card-id', cardId);
                            unfavoriteButton.setAttribute('data-card-id', cardId);
                            deleteButton.setAttribute('data-card-id', cardId);

                            // Toggle favorite/unfavorite button visibility
                            if (data.is_favorited) {
                                favoriteButton.classList.add('hidden');
                                unfavoriteButton.classList.remove('hidden');
                            } else {
                                favoriteButton.classList.remove('hidden');
                                unfavoriteButton.classList.add('hidden');
                            }

                            // Show edit/delete button if current user is owner or admin
                            const isOwnerOrAdmin = data.user_id === {{ auth()->id() }} || {{ auth()->user()->role === 'admin' ? 'true' : 'false' }};
                            if (isOwnerOrAdmin) {
                                editButton.classList.remove('hidden');
                                deleteButton.classList.remove('hidden');
                                editButton.onclick = () => window.location.href = `/cards/${cardId}/edit`;
                                deleteButton.onclick = () => {
                                    if (confirm('Are you sure you want to delete this card?')) {
                                        deleteCard(cardId);
                                    }
                                };
                            } else {
                                editButton.classList.add('hidden');
                                deleteButton.classList.add('hidden');
                            }

                            // Show the modal
                            modal.classList.remove('hidden');
                        })
                        .catch(error => console.error('Error fetching card details:', error));
                }

                // Function to delete a card
                function deleteCard(cardId) {
                    fetch(`/cards/${cardId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                        .then(response => {
                            if (response.ok) {
                                closeModal();
                                alert('Card deleted successfully.');
                                location.reload(); // Reload to update card list
                            }
                        });
                }

                // Close modal and reset its state
                function closeModal() {
                    // Hide the modal
                    modal.classList.add('hidden');

                    // Reset modal content
                    cardTitle.innerText = '';
                    cardDetails.innerText = '';
                    cardImage.src = '';
                    favoriteButton.classList.add('hidden');
                    unfavoriteButton.classList.add('hidden');
                    editButton.classList.add('hidden');
                    deleteButton.classList.add('hidden');
                }

                // Close modal when clicking outside the modal content
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) closeModal();
                });

                // Close modal when clicking the close button
                closeButton.addEventListener('click', closeModal);

                // Toggle filter menu
                document.getElementById('options-menu').addEventListener('click', function () {
                    document.getElementById('filterMenu').classList.toggle('hidden');
                });
            });

        </script>
@endsection
