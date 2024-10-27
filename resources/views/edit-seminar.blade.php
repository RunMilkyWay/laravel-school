@extends('layouts.app')

@section('content')
    <h1>Edit Seminar</h1>

    <form action="{{ route('seminar.update', $seminar->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ $seminar->title }}" required>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description">{{ $seminar->description }}</textarea>
        </div>
        <div>
            <label for="date">Date</label>
            <input type="date" name="date" value="{{ $seminar->date }}" required>
        </div>
        <div>
            <label for="time">Time</label>
            <input type="time" name="time" value="{{ $seminar->time }}" required>
        </div>
        <div>
            <label for="speakers">Speakers</label>
            <input type="text" name="speakers" value="{{ $seminar->speakers }}" required>
        </div>
        <div>
            <label for="location">Location</label>
            <input type="text" name="location" value="{{ $seminar->location }}" required>
        </div>
        <button type="submit">Update Seminar</button>
    </form>
@endsection
