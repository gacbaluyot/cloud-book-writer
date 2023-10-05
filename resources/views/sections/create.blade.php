@extends('layouts.app')

@section('title', 'Add Section')

@section('content')
    <div class="container">
        <h2>Add a Section</h2>

        <form action="{{ route('sections.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="book_id">Book:</label>
                <select name="book_id" id="book_id" class="form-control">
                    @foreach($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="parent_section_id">Parent Section (Optional):</label>
                <select name="parent_section_id" id="parent_section_id" class="form-control">
                    <option value="">-- None --</option>
                    @foreach($sections as $section)
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
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add the AJAX script -->
<script type="text/javascript">
    $(document).ready(function () {
        // Clear sections dropdown on initial load
        const sectionsDropdown = $('#parent_section_id');
        sectionsDropdown.empty();
        sectionsDropdown.append('<option value="">-- None --</option>');

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
                        $("#section-form")[0].reset();
                        alert('Section added successfully.');
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

        $('#book_id').on('change', function() {
            const bookId = $(this).val();

            // Fetch sections for this book
            $.ajax({
                url: `/sections-for-book/${bookId}`,
                method: 'GET',
                success: function(data) {
                    const sectionsDropdown = $('#parent_section_id');
                    sectionsDropdown.empty(); // Clear current options
                    sectionsDropdown.append('<option value="">-- None --</option>'); // Add the default option

                    // Append sections to the dropdown
                    data.forEach(function(section) {
                        sectionsDropdown.append(`<option value="${section.id}">${section.title}</option>`);
                    });
                },
                error: function(err) {
                    console.error("Error fetching sections:", err);
                }
            });
        });
    });
</script>

