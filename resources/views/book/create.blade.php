@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Book</h2>
        <form action="{{ route('book.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="title">Name:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <hr/>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
