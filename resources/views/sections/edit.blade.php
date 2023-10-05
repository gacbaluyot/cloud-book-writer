@extends('layouts.app')

@section('title', 'Edit Section')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <h3>Edit Section</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sections.update', $section->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="book_id" class="form-label">Book:</label>
                        <select name="book_id" id="book_id" class="form-select">
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ $book->id === $section->book_id ? 'selected' : '' }}>{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="parent_section_id" class="form-label">Parent Section (Optional):</label>
                        <select name="parent_section_id" id="parent_section_id" class="form-control">
                            <option value="">-- None --</option>
                            @foreach($sections as $optionSection)
                                <!-- Check if the current option is the parent of the section -->
                                <option value="{{ $optionSection->id }}"
                                    {{ ($section->parentSection && $optionSection->id === $section->parentSection->id) ? 'selected' : '' }}>
                                    {{ $optionSection->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Section Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $section->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Section Content:</label>
                        <textarea name="content" id="content" rows="5" class="form-control">{{ $section->content }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Section</button>
                </form>
            </div>
        </div>
    </div>
@endsection
