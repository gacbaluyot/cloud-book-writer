<div id="collaboratorModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg"> <!-- I added modal-lg to make the modal larger -->

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add/Remove Collaborators</h5>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <!-- Add Collaborator Form -->
                        <form action="{{ route('assign.collaborator', $book->id) }}" method="post" class="mb-3">
                            @csrf
                            <div class="form-group">
                                <label for="user_id">Select Collaborator:</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    @foreach($collaborators as $collaborator)
                                        <option value="{{ $collaborator->id }}">{{ $collaborator->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </form>

                        <!-- List of Assigned Collaborators -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($book->collaborators as $assignedCollaborator)
                                <tr>
                                    <td>{{ $assignedCollaborator->name }}</td>
                                    <td>{{ $assignedCollaborator->email }}</td>
                                    <td>
                                        <form
                                            action="{{ route('remove.collaborator', [$book->id, $collaborator->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Unassign</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
