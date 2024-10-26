@extends('layouts.app')

@section('content')
    <h1>Dashboard - Seminars</h1>

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($seminars as $seminar)
            <tr>
                <td>{{ $seminar->title }}</td>
                <td>{{ $seminar->description }}</td>
                <td>{{ $seminar->date }}</td>
                <td>{{ $seminar->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
