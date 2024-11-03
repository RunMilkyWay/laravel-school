@extends('layouts.app')

@section('content')
    <div data-aos="fade">
    <div class="container">
        <h1 class="mb-4">{{ __('messages.create_new_seminar') }}</h1>

        <!-- Action Buttons: Back to Dashboard and Submit aligned to the right -->
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('messages.back_to_dashboard') }}</a>
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
    </div>

        <!-- Seminar Creation Form -->
        <form action="{{ route('seminar.store') }}" method="POST" class="p-3 border rounded bg-light" style="max-width: 600px; margin: 0 auto;">
            @csrf
            <div class="mb-2">
                <label for="title" class="form-label">{{ __('messages.title') }}</label>
                <input type="text" name="title" class="form-control form-control-sm" value="{{ old('title') }}" required>
            </div>

            <div class="mb-2">
                <label for="description" class="form-label">{{ __('messages.description') }}</label>
                <textarea name="description" class="form-control form-control-sm" rows="2">{{ old('description') }}</textarea>
            </div>

            <div class="mb-2">
                <label for="date" class="form-label">{{ __('messages.date') }}</label>
                <input type="date" name="date" class="form-control form-control-sm" value="{{ old('date') }}" required>
            </div>

            <div class="mb-2">
                <label for="time" class="form-label">{{ __('messages.time') }}</label>
                <input type="text" name="time" class="form-control form-control-sm" value="{{ old('time') }}" placeholder="{{ __('messages.time_placeholder') }}" required>
            </div>

            <div class="mb-2">
                <label for="speakers" class="form-label">{{ __('messages.speakers') }}</label>
                <input type="text" name="speakers" class="form-control form-control-sm" value="{{ old('speakers') }}" placeholder="{{ __('messages.speakers_placeholder') }}" required>
            </div>

            <div class="mb-2">
                <label for="location" class="form-label">{{ __('messages.location') }}</label>
                <input type="text" name="location" class="form-control form-control-sm" value="{{ old('location') }}" required>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary btn-sm">{{ __('messages.create_seminar') }}</button>
            </div>
        </form>
    </div>
@endsection
