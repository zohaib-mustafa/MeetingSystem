@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Meeting</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('meetings.store') }}">
                        @csrf

                        <div class="form-group mb-2">
                            <label for="subject">Subject</label>
                            <input id="subject" type="text" class="form-control" name="subject"  autofocus>
                        </div>

                        <div class="form-group mb-2">
                            <label for="datetime">Date & Time</label>
                            <input id="datetime" type="datetime-local" class="form-control" name="datetime" >
                        </div>

                           <div class="form-group mb-2" id="attendeesContainer">
                            <label for="attendees">Attendees (up to 2 & press enter to add email)</label>
                            <div id="attendeesWrapper">
                                <input type="email" class="form-control attendee-input" >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Meeting</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
