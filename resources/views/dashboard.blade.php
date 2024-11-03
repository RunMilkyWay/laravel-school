@extends('layouts.app')

@section('content')
    <div data-aos="fade">
    <div class="container">
        <h1 class="mb-4">{{ __('messages.dashboard_seminars') }}</h1>

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
                <a href="{{ route('seminar.create') }}" class="btn btn-primary">{{ __('messages.create_new_seminar') }}</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('messages.manage_users') }}</a>
            </div>
        @endif

        <!-- Seminars Table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('messages.title') }}</th>
                <th>{{ __('messages.description') }}</th>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.time') }}</th>
                <th>{{ __('messages.speakers') }}</th>
                <th>{{ __('messages.location') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.actions') }}</th>
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
                            <span class="badge bg-warning text-dark">{{ __('messages.planned') }}</span>
                        @elseif($seminar->date > now())
                            <span class="badge bg-success">{{ __('messages.upcoming') }}</span>
                        @else
                            <span class="badge bg-danger">{{ __('messages.concluded') }}</span>
                        @endif
                    </td>
                    <td class="d-flex gap-2">
                        @if(auth()->user()->type_id == 1)
                            @if($seminar->date > now()->toDateString())
                                @if(auth()->user()->seminars->contains($seminar->id))
                                    <form action="{{ route('seminar.unregister', $seminar->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">{{ __('messages.unregister') }}</button>
                                    </form>
                                @else
                                    <form action="{{ route('seminar.register', $seminar->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">{{ __('messages.register') }}</button>
                                    </form>
                                @endif
                                <a href="{{ route('show', $seminar->id) }}" class="btn btn-sm btn-info">{{ __('messages.about') }}</a>
                            @endif
                        @elseif(auth()->user()->type_id == 2)
                            <a href="{{ route('show', $seminar->id) }}" class="btn btn-sm btn-info">{{ __('messages.about') }}</a>
                        @elseif(auth()->user()->type_id == 3)
                            <button class="btn btn-sm btn-primary" onclick="openEditModal({{ $seminar }})" data-bs-toggle="modal" data-bs-target="#editSeminarModal">{{ __('messages.edit') }}</button>
                            @if($seminar->date > now())
                                <form action="{{ route('seminar.delete', $seminar->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}')">{{ __('messages.delete') }}</button>
                                </form>
                            @endif
                            <a href="{{ route('show', $seminar->id) }}" class="btn btn-sm btn-info">{{ __('messages.about') }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>

        <!-- Edit Seminar Modal -->
        <div class="modal fade" id="editSeminarModal" tabindex="-1" aria-labelledby="editSeminarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSeminarModalLabel">{{ __('messages.edit_seminar') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-seminar-form" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('messages.title') }}</label>
                                <input type="text" name="title" id="edit-title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('messages.description') }}</label>
                                <textarea name="description" id="edit-description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">{{ __('messages.date') }}</label>
                                <input type="date" name="date" id="edit-date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">{{ __('messages.time') }}</label>
                                <input type="text" name="time" id="edit-time" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="speakers" class="form-label">{{ __('messages.speakers') }}</label>
                                <input type="text" name="speakers" id="edit-speakers" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">{{ __('messages.location') }}</label>
                                <input type="text" name="location" id="edit-location" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                        </form>
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
