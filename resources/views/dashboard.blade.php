@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Dashboard - Seminars</h1>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Admin Buttons -->
        @if(auth()->user()->type_id == 3)
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('seminar.create') }}" class="btn btn-primary">Create New Seminar</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Manage Users</a>
            </div>
        @endif

        <!-- Seminars Table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Speakers</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($seminars as $seminar)
                <tr>
                    <td>{{ $seminar->title }}</td>
                    <td>{{ $seminar->description }}</td>
                    <td>{{ $seminar->date }}</td>
                    <td>{{ $seminar->time }}</td>
                    <td>{{ $seminar->speakers }}</td>
                    <td>{{ $seminar->location }}</td>
                    <td>
                        @if($seminar->date > now()->addDays(30))
                            <span class="badge bg-warning text-dark">Planned</span>
                        @elseif($seminar->date > now())
                            <span class="badge bg-success">Upcoming</span>
                        @else
                            <span class="badge bg-danger">Concluded</span>
                        @endif
                    </td>
                    <td class="d-flex gap-2">
                        @if(auth()->user()->type_id == 1)
                            <!-- User Registration/Unregistration based on seminar status -->
                            @if($seminar->date > now()->toDateString())
                                @if(auth()->user()->seminars->contains($seminar->id))
                                    <form action="{{ route('seminar.unregister', $seminar->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Unregister</button>
                                    </form>
                                @else
                                    <form action="{{ route('seminar.register', $seminar->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Register</button>
                                    </form>
                                @endif
                                <a href="{{ route('show', $seminar->id) }}" class="btn btn-sm btn-info">About</a>
                            @endif
                        @elseif(auth()->user()->type_id == 2)
                            <a href="{{ route('show', $seminar->id) }}" class="btn btn-sm btn-info">About</a>
                        @elseif(auth()->user()->type_id == 3)
                            <!-- Admin: Edit/Delete if not Concluded -->
                            <button class="btn btn-sm btn-primary" onclick="openEditModal({{ $seminar }})" data-bs-toggle="modal" data-bs-target="#editSeminarModal">Edit</button>
                            @if($seminar->date > now())
                                <form action="{{ route('seminar.delete', $seminar->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this seminar?')">Delete</button>
                                </form>
                            @endif
                            <a href="{{ route('show', $seminar->id) }}" class="btn btn-sm btn-info">About</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Edit Seminar Modal -->
        <div class="modal fade" id="editSeminarModal" tabindex="-1" aria-labelledby="editSeminarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSeminarModalLabel">Edit Seminar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-seminar-form" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="edit-title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="edit-description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="edit-date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="text" name="time" id="edit-time" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="speakers" class="form-label">Speakers</label>
                                <input type="text" name="speakers" id="edit-speakers" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="edit-location" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Populate Modal with Seminar Data -->
    <script>
        function openEditModal(seminar) {
            document.getElementById('edit-seminar-form').action = `/seminar/${seminar.id}`;
            document.getElementById('edit-title').value = seminar.title;
            document.getElementById('edit-description').value = seminar.description;
            document.getElementById('edit-date').value = seminar.date;
            document.getElementById('edit-time').value = seminar.time;
            document.getElementById('edit-speakers').value = seminar.speakers;
            document.getElementById('edit-location').value = seminar.location;
        }
    </script>
@endsection
