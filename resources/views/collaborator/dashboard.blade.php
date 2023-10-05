@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Collaborator Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}! You're viewing the collaborator dashboard.</p>
        <h2>Co-Authored Books</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->book->title }}</td>
                    <td>{{ $book->book->author->name }}</td>
                    <td>
                        <a href="{{ route('collaborator.edit', $book->book->id) }}" class="btn btn-info">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>s
@endsection
