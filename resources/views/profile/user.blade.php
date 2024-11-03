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

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="cardDetailModal">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2">
            <div class="flex justify-between items-center p-4 border-b">
                <h5 class="text-lg font-bold" id="cardTitle"></h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" onclick="closeModal()">&times;</button>
            </div>
            <div class="p-4 text-black">
                <p id="cardDetails" class="mb-4"></p>
                <img id="cardImage" src="" alt="" class="w-full h-auto mb-4">
                <div class="flex justify-end">
                    <button id="unfavoriteButton" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Unfavorite</button>
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
            const unfavoriteButton = document.getElementById('unfavoriteButton');

            cardLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const cardId = this.getAttribute('data-card-id');
                    openCardModal(cardId);
                });
            });

            function openCardModal(cardId) {
                fetch(`/cards/${cardId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate modal with card data
                        cardTitle.innerText = data.name;
                        cardDetails.innerText = `Rarity: ${data.Rarity}, Type: ${data.type}, Language: ${data.Language}, Era: ${data.Era}`;
                        cardImage.src = `/storage/cards/${data.image_path}`;

                        // Set the card ID on the unfavorite button for future reference
                        unfavoriteButton.setAttribute('data-card-id', cardId);

                        // Show the modal
                        modal.style.display = 'flex';
                    })
                    .catch(error => console.error('Error fetching card details:', error));
            }

            unfavoriteButton.onclick = function () {
                const cardId = unfavoriteButton.getAttribute('data-card-id');
                fetch(`/cards/${cardId}/unfavorite`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                    .then(response => {
                        if (response.ok) {
                            alert('Card removed from favorites.');
                            closeModal();
                            location.reload();
                        } else {
                            closeModal();
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error unfavoriting card:', error));
            };

            function closeModal() {
                modal.style.display = 'none';
            }

            window.addEventListener('click', function (event) {
                if (event.target === modal) closeModal();
            });
        });
    </script>
@endsection
