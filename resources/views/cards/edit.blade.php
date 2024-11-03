@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Card</h2>

        <form method="POST" action="{{ route('cards.update', $card) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $card->name) }}" required>
            </div>

            <div class="form-group">
                <label for="Rarity">Rarity</label>
                <input id="Rarity" type="text" class="form-control" name="Rarity" value="{{ old('Rarity', $card->Rarity) }}" required>
            </div>

            <div class="form-group">
                <label for="Era">Era</label>
                <input id="Era" type="text" class="form-control" name="Era" value="{{ old('Era', $card->Era) }}" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input id="type" type="text" class="form-control" name="type" value="{{ old('type', $card->type) }}" required>
            </div>

            <div class="form-group">
                <label for="Language">Language</label>
                <input id="Language" type="text" class="form-control" name="Language" value="{{ old('Language', $card->Language) }}" required>
            </div>

            <div class="form-group">
                <label for="Stamped">Stamped</label>
                <input id="Stamped" type="text" class="form-control" name="Stamped" value="{{ old('Stamped', $card->Stamped) }}" required>
            </div>

            <div class="form-group">
                <label for="CardMarketLink">Card Market Link</label>
                <input id="CardMarketLink" type="text" class="form-control" name="CardMarketLink" value="{{ old('CardMarketLink', $card->CardMarketLink) }}" required>
            </div>

            <div class="form-group">
                <label for="image">Upload New Image (optional)</label>
                <input id="image" type="file" class="form-control" name="image">
                @if ($card->image_path)
                    <img src="{{ Storage::url($card->image_path) }}" alt="{{ $card->name }}" class="mt-2" width="100">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Card</button>
        </form>
    </div>
@endsection
