<?php
namespace App\Services;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class CreateEventService
{


    public function createEvent(array $data, $accessToken)
    {
        // Initialize Google client
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google_credentials.json')); // Path to Google API credentials file
        $client->setScopes(Google_Service_Calendar::CALENDAR);
         // Get access token (assuming you've already authenticated and have the token)
    $accessTokens = $accessToken;
    $client->setAccessToken($accessTokens);
        // Create service instance for Google Calendar API
        $service = new Google_Service_Calendar($client);

        // Create event object
        $event = new Google_Service_Calendar_Event([
            'summary' => 'Google I/O 2015',
            'location' => '800 Howard St., San Francisco, CA 94103',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => [
                'dateTime' => '2015-05-28T09:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ],
            'end' => [
                'dateTime' => '2015-05-28T17:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ],
            'recurrence' => [
                'RRULE:FREQ=DAILY;COUNT=2',
            ],
            'attendees' => [
                ['email' => 'zmrollins23@gmail.com'],
                ['email' => 'zohaibmustafa459@gmail.com'],
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60],
                    ['method' => 'popup', 'minutes' => 10],
                ],
            ],
        ]);

        // Insert the event
        $calendarId = 'primary'; // You can change this to your desired calendar ID
        $event = $service->events->insert($calendarId, $event);
        //dd($event);
        // Output the event link and id
        return ['htmlLink' => $event->htmlLink, 'eventId' => $event->id];
    }
}
