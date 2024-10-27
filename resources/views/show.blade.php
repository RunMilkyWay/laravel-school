@extends('layouts.app')

@section('content')
    <h1>Conference: {{ $seminar->title }}</h1>
    <p>{{ $seminar->description }}</p>
    <p>Date: {{ $seminar->date }}</p>

    <!-- List of registered users, visible only to Workers and Admins -->
    @if(auth()->user()->type_id == 2 || auth()->user()->type_id == 3)
        <h3>Registered Users</h3>
        <ul>
            @forelse($seminar->users as $user)
                <li>{{ $user->name }}</li> <!-- Display each registered user's name -->
            @empty
                <li>No users registered for this conference yet.</li>
            @endforelse
        </ul>
    @endif
@endsection
