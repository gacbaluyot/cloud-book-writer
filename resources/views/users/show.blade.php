@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>User Details</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role->name }}</p>

        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
    </div>

@endsection
