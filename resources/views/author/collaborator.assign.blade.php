@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Edit Book</h2>
        <form action="{{ route('book.update', $book->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <a href="{{ route('sections.create') }}" class="btn btn-primary mb-3">Create Section</a>

    </div>
@endsection
