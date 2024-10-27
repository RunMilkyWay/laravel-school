@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Header and Back Button in a Row -->
        <div class="d-flex align-items-center mb-4 gap-2">
            <h1 class="mb-0">Create New Seminar</h1>
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
        <form action="{{ route('seminar.store') }}" method="POST" class="p-4 border rounded bg-light">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="text" name="time" class="form-control" value="{{ old('time') }}" placeholder="e.g., 10:30 AM or Afternoon" required>
            </div>

            <div class="mb-3">
                <label for="speakers" class="form-label">Speakers</label>
                <input type="text" name="speakers" class="form-control" value="{{ old('speakers') }}" placeholder="e.g., Speaker 1, Speaker 2" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Seminar</button>
        </form>
    </div>
@endsection
