<?php
namespace App\Services;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class UpdateEventService
{


    public function updateEvent($eventId, $accessToken)
    {
         //dd($eventId);
         // Initialize Google client
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google_credentials.json')); // Path to Google API credentials file
        $client->setScopes(Google_Service_Calendar::CALENDAR);
         // Get access token (assuming you've already authenticated and have the token)
    $accessTokens = $accessToken;
    $client->setAccessToken($accessTokens);
        // Create service instance for Google Calendar API
        $service = new Google_Service_Calendar($client);

        // Retrieve the event from the API
        $event = $service->events->get('primary', $eventId);

        // Update event details
        $event->setSummary('Appointment at Somewhere');

        // Update the event
        $updatedEvent = $service->events->update('primary', $event->getId(), $event);

        // return the updated data
        return ['htmlLink' => $updatedEvent->htmlLink, 'eventId' => $updatedEvent->id];
    }
}
