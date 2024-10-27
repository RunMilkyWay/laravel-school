@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Create New Seminar</h1>

        <!-- Action Buttons: Back to Dashboard and Submit aligned to the right -->
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Seminar Creation Form -->
        <form action="{{ route('seminar.store') }}" method="POST" class="p-3 border rounded bg-light" style="max-width: 600px; margin: 0 auto;">
            @csrf
            <div class="mb-2">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control form-control-sm" value="{{ old('title') }}" required>
            </div>

            <div class="mb-2">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control form-control-sm" rows="2">{{ old('description') }}</textarea>
            </div>

            <div class="mb-2">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control form-control-sm" value="{{ old('date') }}" required>
            </div>

            <div class="mb-2">
                <label for="time" class="form-label">Time</label>
                <input type="text" name="time" class="form-control form-control-sm" value="{{ old('time') }}" placeholder="e.g., 10:30 AM or Afternoon" required>
            </div>

            <div class="mb-2">
                <label for="speakers" class="form-label">Speakers</label>
                <input type="text" name="speakers" class="form-control form-control-sm" value="{{ old('speakers') }}" placeholder="e.g., Speaker 1, Speaker 2" required>
            </div>

            <div class="mb-2">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control form-control-sm" value="{{ old('location') }}" required>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary btn-sm">Create Seminar</button>
            </div>
        </form>
    </div>
@endsection
