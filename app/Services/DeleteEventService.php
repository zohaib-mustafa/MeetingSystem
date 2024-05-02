<?php
namespace App\Services;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class DeleteEventService
{


    public function deleteEvent($eventId, $accessToken)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google_credentials.json')); // Path to Google API credentials file
        $client->setScopes(Google_Service_Calendar::CALENDAR);
         // Get access token (assuming you've already authenticated and have the token)
    $accessTokens = $accessToken;
    $client->setAccessToken($accessTokens);
        // Create service instance for Google Calendar API
        $service = new Google_Service_Calendar($client);

    // Call the delete method on the events resource
    $service->events->delete('primary', $eventId);


        // return the updated data
        return 'success';
    }
}
