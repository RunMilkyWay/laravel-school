@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Back Button with Margin -->
        <div class="d-flex justify-content-start mb-4 mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <!-- Seminar Details Card -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>{{ $seminar->title }}</h3>
            </div>
            <div class="card-body">
                <!-- Seminar Information -->
                <p class="card-text"><strong>Description:</strong> {{ $seminar->description }}</p>
                <p class="card-text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($seminar->date)->format('F j, Y') }}</p>
                <p class="card-text"><strong>Time:</strong> {{ $seminar->time }}</p>
                <p class="card-text"><strong>Speakers:</strong> {{ $seminar->speakers }}</p>
                <p class="card-text"><strong>Location:</strong> {{ $seminar->location }}</p>

                <!-- Status -->
                <div class="mt-4">
                    <span class="badge {{ $seminar->date > now() ? 'bg-success' : 'bg-secondary' }}">
                        {{ $seminar->date > now() ? 'Upcoming' : 'Concluded' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
