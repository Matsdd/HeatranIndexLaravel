@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Admin - User Management</h2>

        <table class="min-w-full bg-gray-800 text-white">
            <thead>
            <tr>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
