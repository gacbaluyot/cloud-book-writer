@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Book Details</h2>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">{{ $book->title }}</h4>
                <a href="{{ route('book.edit', $book->id) }}" class="btn btn-warning">Edit Book</a>
            </div>
        </div>
        <h4 class="mb-4">Sections:</h4>

        @foreach($rootSections as $section)
            <div class="section-title">
                {{ $section->title }}
                <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-warning ml-2">Edit</a>

                @if($section->children->count())
                    <div class="subsections">
                        @include('sections._children', ['sections' => $section->children])
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection

<style>
    .section-title {
        font-size: 1.2rem;
        margin-top: 10px;
    }

</style>
