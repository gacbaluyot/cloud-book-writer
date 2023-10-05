@foreach($sections as $section)
    <div class="subsection-title">
        {{ $section->title }}
        <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-warning ml-2">Edit</a>
        <a href="{{ route('sections.destroy', $section->id) }}" class="btn btn-sm btn-warning ml-2">Delete</a>

        @if($section->children->count())
            <div class="subsubsections">
                @include('sections._children', ['sections' => $section->children, 'class' => 'subsubsection-title'])
            </div>
        @endif
    </div>
@endforeach
