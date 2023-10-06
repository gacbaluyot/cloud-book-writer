@extends('layouts.app')

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

    <div class="container">
        <!-- Trigger the modal with a button -->
        @if(!auth()->user()->hasRole('Collaborator'))
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#collaboratorModal">Add
                Collaborator
            </button>
        @endif

        <h2 class="mt-4">Edit Book</h2>

        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('book.update', $book->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="name">Description:</label>
                        <input type="text" class="form-control" id="description" name="description"
                               value="{{ $book->description }}"
                               required>
                    </div>

                    @if(!auth()->user()->hasRole('Collaborator'))
                        <button type="submit" class="btn btn-primary">Update</button>
                    @endif
                </form>
            </div>
        </div>

        @if(!auth()->user()->hasRole('Collaborator'))

            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-primary mb-3 mt-4" data-toggle="modal" data-target="#addSectionModal">
                Create Section
            </button>
        @endif

        <div class="modal fade" id="addSectionModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add a Section</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('sections.store') }}" method="post" id="section-form">
                            @csrf
                            <div class="form-group">
                                <label for="book_id">Book:</label>
                                <h4> {{ $book->title }}</h4>
                                <input type="hidden" value="{{ $book->id }}" id="book_id" name="book_id">
                            </div>


                            <div class="form-group">
                                <label for="parent_section_id">Parent Section (Optional):</label>
                                <select name="parent_section_id" id="parent_section_id" class="form-control">
                                    <option value="">-- None --</option>
                                    @foreach($rootSections as $section)
                                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Section Title:</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="content">Section Content:</label>
                                <textarea name="content" id="content" rows="10" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Section</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <hr/>
        <h4> Sections </h4>
        @foreach($rootSections as $section)
            <div class="section-title">
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
                    <div class="subsections">
                        @include('sections._children', ['sections' => $section->children])
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    @if(!auth()->user()->hasRole('Collaborator'))
        <!-- Collaborator Modal -->
        @include('collaborator.modals.add-collaborator', ['book' => $book, 'collaborators' => $collaborators])
    @endif
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        const bookId = $('#book_id').val();
        // Fetch sections for this book
        $.ajax({
            url: `/sections-for-book/${bookId}`,
            method: 'GET',
            success: function (data) {
                const sectionsDropdown = $('#parent_section_id');
                sectionsDropdown.empty(); // Clear current options
                sectionsDropdown.append('<option value="">-- None --</option>'); // Add the default option

                // Append sections to the dropdown
                data.forEach(function (section) {
                    sectionsDropdown.append(`<option value="${section.id}">${section.title}</option>`);
                });
            },
            error: function (err) {
                console.error("Error fetching sections:", err);
            }
        });

        $("#section-form").submit(function (event) {
            event.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '/sections', // Assuming your store route is /sections
                data: formData,
                success: function (response) {
                    if (response.success) {
                        // Reset form or show a success message
                        alert('Section added successfully.');
                        window.location.reload();
                    } else {
                        alert('There was an error.');
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert('There was an error.');
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#ajaxSubmit').click(function (e) {
            e.preventDefault();
            let formData = $('#editSectionForm').serialize();

            $.ajax({
                type: 'POST',
                url: $('#editSectionForm').attr('action'),
                data: formData,
                success: function (response) {
                    if (response.success) {
                        // You can update other parts of the page here if necessary
                        alert('Section updated successfully.');
                        // Close the modal
                        $('#editSectionModal').modal('hide');
                    } else {
                        alert('There was an error updating the section.');
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert('There was an error updating the section.');
                }
            });
        });
    });
</script>

<style>
    .modal-header .close {
        margin-right: auto; /* This will push the close button to the left */
    }

    .section-title {
        font-size: 1.2rem;
        margin-top: 10px;
    }

    .subsection-title {
        font-size: 1.1rem;
        margin-left: 20px;
        color: #777;
        margin-top: 5px;
    }

    .subsubsection-title {
        margin-left: 40px;
        color: #999;
        margin-top: 3px;
    }
</style>
