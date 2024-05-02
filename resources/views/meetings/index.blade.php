@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-2">
                 <a href="{{ route('meetings.create') }}" class="btn btn-success btn-sm">+ Add Meeting</a>
            </div>
            <div class="card mb-2">
                <div class="card-header">Meetings</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Date & Time</th>
                                <th>Evenet</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($meetings as $meeting)
                                <tr>
                                    <td>{{ $meeting->subject }}</td>
                                    <td>{{ $meeting->datetime }}</td>
                                    <td><a href="{{ $meeting->google_calendar_event }}" target="_blank">Show Event</a></td>
                                    <td>
                                        <a href="{{ route('meetings.edit', $meeting->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST">
                                            @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this meeting?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" >No meetings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    
                </div>
            </div>
            {{ $meetings->links() }}
        </div>
    </div>
</div>
@endsection
