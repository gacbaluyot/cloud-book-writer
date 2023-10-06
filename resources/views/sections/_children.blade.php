@foreach($sections as $section)
    <div class="subsection-title">
        {{ $section->title }}
        <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-warning ml-2">Edit</a>
        @if(!auth()->user()->hasRole('Collaborator'))
            <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger ml-2">Delete</button>
            </form>
        @endif
        @if($section->children->count())
            <div class="subsubsections">
                @include('sections._children', ['sections' => $section->children, 'class' => 'subsubsection-title'])
            </div>
        @endif
    </div>
@endforeach
