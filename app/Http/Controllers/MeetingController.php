<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Attendee;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Auth;
use App\Services\CreateEventService;
use App\Services\UpdateEventService;
use App\Services\DeleteEventService;

class MeetingController extends Controller
{
     protected $createEventService;
    protected $updateEventService;
    protected $deleteEventService;

    public function __construct(
        CreateEventService $createEventService,
        UpdateEventService $updateEventService,
        DeleteEventService $deleteEventService
    ) {
        $this->createEventService = $createEventService;
        $this->updateEventService = $updateEventService;
        $this->deleteEventService = $deleteEventService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=auth()->user();
        $meetings = $user->meetings()->paginate(10);
        return view('meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate form data
     $validator = Validator::make($request->all(), [
        'subject' => 'required|string',
        'datetime' => 'required|date',
        'attendees' => 'required|array|min:1|max:2',
    ]);
    if ($validator->fails()) {
            return Redirect()->back()->with('error', $validator->errors());
        } 
    // Proceed if access token is obtained
    if (auth()->user()->access_token) {
        $accessToken=auth()->user()->access_token;
        // create google calender event
        $googleCalendarEventcreated = $this->createEventService->createEvent($request->all(), $accessToken);

        // Create meeting in the database
        $meeting = Meeting::create([
            'subject' => $request->input('subject'),
            'datetime' => $request->input('datetime'),
            'creator_id' => auth()->user()->id,
            'google_calendar_event' => $googleCalendarEventcreated['htmlLink'],
            'google_calendar_event_id' => $googleCalendarEventcreated['eventId'],
        ]);

        // Redirect to meetings listing page with success message
        return redirect()->route('meetings.index')->with('success', 'Meeting created successfully.');
    }

    // Redirect to Google authentication if access token cannot be obtained
    return Redirect()->back()->with('error', 'Something went wrong');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $meeting = Meeting::where('id',$id)->first();
         return view('meetings.edit', compact('meeting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate form data
     $validator = Validator::make($request->all(), [
        'subject' => 'required|string',
        'datetime' => 'required|date',
        'attendees' => 'required|array|min:1|max:2',
    ]);
    if ($validator->fails()) {
            return Redirect()->back()->with('error', $validator->errors());
        } 
    // Proceed if access token is obtained
    if (auth()->user()->access_token) {
        $meeting = Meeting::findOrFail($id); // Replace $meetingId with the actual ID
        $accessToken=auth()->user()->access_token;
        // create google calender event
        $googleCalendarEventupdated = $this->updateEventService->updateEvent($meeting->google_calendar_event_id, $accessToken);
        // Find the meeting instance based on some criteria, such as ID
        
        // Update the meeting attributes
        $meeting->update([
            'subject' => $request->input('subject'),
            'datetime' => $request->input('datetime'),
            'creator_id' => auth()->user()->id,
            'google_calendar_event' => $googleCalendarEventupdated['htmlLink'],
            'google_calendar_event_id' => $googleCalendarEventupdated['eventId'],
        ]);

        // Redirect to meetings listing page with success message
        return redirect()->route('meetings.index')->with('success', 'Meeting updated successfully.');
    }

    // Redirect to Google authentication if access token cannot be obtained
    return Redirect()->back()->with('error', 'Something went wrong');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->access_token) {
        $meeting = Meeting::findOrFail($id); // Replace $meetingId with the actual ID
        $accessToken=auth()->user()->access_token;
        // create google calender event
        $googleCalendarEventdeleted = $this->deleteEventService->deleteEvent($meeting->google_calendar_event_id, $accessToken);
        if($googleCalendarEventdeleted == 'success'){
        // Delete the meeting attributes
        $meeting = Meeting::where('id',$id)->delete();
        }
        // Redirect to meetings listing page with success message
        return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully.');
    }
    }




   


}
