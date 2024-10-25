@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create New Pokémon Card</h2>

        <form method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Card Name -->
            <div class="form-group">
                <label for="name">Card Name</label>
                <input type="text" id="name" name="name" class="form-control" required placeholder="Enter card name" value="{{ old('name') }}">
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Rarity -->
            <div class="form-group">
                <label for="Rarity">Rarity</label>
                <input type="text" id="Rarity" name="Rarity" class="form-control" required placeholder="e.g., Common, Rare, Ultra Rare" value="{{ old('Rarity') }}">
                @error('Rarity')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Era -->
            <div class="form-group">
                <label for="Era">Era</label>
                <input type="text" id="Era" name="Era" class="form-control" required placeholder="e.g., Base Set, Neo, EX, Sun & Moon" value="{{ old('Era') }}">
                @error('Era')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Type -->
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" id="type" name="type" class="form-control" required placeholder="e.g., Fire, Water, Psychic" value="{{ old('type') }}">
                @error('type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Language -->
            <div class="form-group">
                <label for="Language">Language</label>
                <input type="text" id="Language" name="Language" class="form-control" required placeholder="e.g., English, Japanese" value="{{ old('Language') }}">
                @error('Language')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Stamped -->
            <div class="form-group">
                <label for="Stamped">Stamped</label>
                <select id="Stamped" name="Stamped" class="form-control" required>
                    <option value="No" {{ old('Stamped') == 'No' ? 'selected' : '' }}>No</option>
                    <option value="Yes" {{ old('Stamped') == 'Yes' ? 'selected' : '' }}>Yes</option>
                </select>
                @error('Stamped')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- CardMarket Link -->
            <div class="form-group">
                <label for="CardMarketLink">CardMarket Link</label>
                <input type="url" id="CardMarketLink" name="CardMarketLink" class="form-control" placeholder="https://www.cardmarket.com/en/Pokemon/... (optional)" value="{{ old('CardMarketLink') }}">
                @error('CardMarketLink')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="form-group">
                <label for="image">Card Image</label>
                <input type="file" id="image" name="image" class="form-control-file" required>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-3">Create Card</button>
        </form>
    </div>
@endsection
