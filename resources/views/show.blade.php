@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Back Button with Margin -->
        <div class="d-flex justify-content-start mb-4 mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('messages.back_to_dashboard') }}</a>
        </div>

        <!-- Seminar Details Card -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>{{ $seminar->title }}</h3>
            </div>
            <div class="card-body">
                <!-- Seminar Information -->
                <p class="card-text"><strong>{{ __('messages.description') }}:</strong> {{ $seminar->description }}</p>
                <p class="card-text"><strong>{{ __('messages.date') }}:</strong> {{ \Carbon\Carbon::parse($seminar->date)->format('F j, Y') }}</p>
                <p class="card-text"><strong>{{ __('messages.time') }}:</strong> {{ $seminar->time }}</p>
                <p class="card-text"><strong>{{ __('messages.speakers') }}:</strong> {{ $seminar->speakers }}</p>
                <p class="card-text"><strong>{{ __('messages.location') }}:</strong> {{ $seminar->location }}</p>

                <!-- Status -->
                <div class="mt-4">
    <span class="badge {{ $seminar->date > now()->addDays(30) ? 'bg-warning text-dark' : ($seminar->date > now() ? 'bg-success' : 'bg-danger') }}">
        {{ $seminar->date > now()->addDays(30) ? __('messages.planned') : ($seminar->date > now() ? __('messages.upcoming') : __('messages.concluded') ) }}
    </span>
                </div>

                <!-- List of registered users, visible only to Workers and Admins -->
                @if(auth()->user()->type_id == 2 || auth()->user()->type_id == 3)
                    <br>
                    <h3>{{ __('messages.registered_users') }}</h3>
                    <ul>
                        @forelse($seminar->users as $user)
                            <li>{{ $user->name }}</li> <!-- Display each registered user's name -->
                        @empty
                            <li>{{ __('messages.no_registered_users') }}</li>
                        @endforelse
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
