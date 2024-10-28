@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Create New Pokémon Card</h2>

        <form method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf

            <!-- Card Name -->
            <div class="mb-4">
                <label for="name" class="block text-white mb-2">Card Name</label>
                <input type="text" id="name" name="name" class="form-control bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" required placeholder="Enter card name" value="{{ old('name') }}">
                @error('name')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- Rarity -->
            <div class="mb-4">
                <label for="Rarity" class="block text-white mb-2">Rarity</label>
                <input type="text" id="Rarity" name="Rarity" class="form-control bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" required placeholder="e.g., Common, Rare, Ultra Rare" value="{{ old('Rarity') }}">
                @error('Rarity')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- Era -->
            <div class="mb-4">
                <label for="Era" class="block text-white mb-2">Era</label>
                <input type="text" id="Era" name="Era" class="form-control bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" required placeholder="e.g., Base Set, Neo, EX, Sun & Moon" value="{{ old('Era') }}">
                @error('Era')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label for="type" class="block text-white mb-2">Type</label>
                <input type="text" id="type" name="type" class="form-control bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" required placeholder="e.g., Fire, Water, Psychic" value="{{ old('type') }}">
                @error('type')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- Language -->
            <div class="mb-4">
                <label for="Language" class="block text-white mb-2">Language</label>
                <input type="text" id="Language" name="Language" class="form-control bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" required placeholder="e.g., English, Japanese" value="{{ old('Language') }}">
                @error('Language')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- Stamped -->
            <div class="mb-4">
                <label for="Stamped" class="block text-white mb-2">Stamped</label>
                <select id="Stamped" name="Stamped" class="form-control bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" required>
                    <option value="No" {{ old('Stamped') == 'No' ? 'selected' : '' }}>No</option>
                    <option value="Yes" {{ old('Stamped') == 'Yes' ? 'selected' : '' }}>Yes</option>
                </select>
                @error('Stamped')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- CardMarket Link -->
            <div class="mb-4">
                <label for="CardMarketLink" class="block text-white mb-2">CardMarket Link</label>
                <input type="url" id="CardMarketLink" name="CardMarketLink" class="form-control bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" placeholder="https://www.cardmarket.com/en/Pokemon/... (optional)" value="{{ old('CardMarketLink') }}">
                @error('CardMarketLink')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-white mb-2">Card Image</label>
                <input type="file" id="image" name="image" class="form-control-file bg-gray-700 text-white border border-gray-600 rounded-lg p-2 w-full" required>
                @error('image')
                <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 mt-3">Create Card</button>
        </form>
    </div>
@endsection
