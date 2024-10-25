@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Uploaded Cards (Admin View)</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Uploader</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cards as $card)
                <tr>
                    <td>{{ $card->name }}</td>
                    <td>{{ $card->type }}</td>
                    <td>{{ $card->user->name }}</td>
                    <td>
                        <form action="{{ route('cards.destroy', $card) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
