@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Author Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}! You're viewing the author dashboard.</p>
        <a href="{{ route('book.create') }}" class="btn btn-primary mb-3">Add Book</a>
        <h2>Authored Books</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->description }}</td>

                    <td>
                        <a href="{{ route('book.show', $book->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('book.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('users.destroy', $book->id) }}" method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>s
@endsection
