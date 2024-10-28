import './bootstrap.js';

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

            // Change button visibility based on favorite status
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

            document.getElementById('cardDetailModal').style.display = 'block'; // Show the modal
        })
        .catch(error => console.error('Error fetching card details:', error));
}

function closeModal() {
    document.getElementById('cardDetailModal').style.display = 'none'; // Hide the modal
}

window.onclick = function(event) {
    const modal = document.getElementById('cardDetailModal');
    if (event.target === modal) {
        closeModal();
    }
}
