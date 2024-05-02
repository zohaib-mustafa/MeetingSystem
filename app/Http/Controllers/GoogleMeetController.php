<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleMeetService;

class GoogleMeetController extends Controller
{
     protected $googleMeetService;

    public function __construct(GoogleMeetService $googleMeetService)
    {
        $this->googleMeetService = $googleMeetService;
    }

    public function createMeeting(Request $request)
    {
        // Validate input here

        $meetingTitle = 'bdfbdfbdfbdf';
        $startTime = '2024-05-01T09:00:00';
        $endTime = '2024-05-02T09:00:00';

        $meetLink = $this->googleMeetService->generateMeetLink($meetingTitle, $startTime, $endTime);

        dd($meetLink);
        // Store the meet link in the database or return it to the client
    }

}
