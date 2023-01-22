<?php
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

function getClient() {
    require_once('putenv.php'); //環境変数読み込み
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP CONNECTOR');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAuthConfig(get_env('GOOGLE_AUTH'));

    return $client;
}

function insert_event($cal_id) {
    
    $title = '作業時間';
    
    $tz = new DateTimeZone('Asia/Tokyo');
    
    $start_time = Carbon::create(
        date(Y),
        date(m),
        date(d),
        date(H),
        date(i),
        date(s),
        $tz
    );
    
    $googleStartTime = new Google_Service_Calendar_EventDateTime();
    $googleStartTime->setTimeZone($tz);
    $googleStartTime->setDateTime($start_time->format('c'));
    
    $googleEndTime = new Google_Service_Calendar_EventDateTime();
    $googleEndTime->setTimeZone($tz);
    $googleEndTime->setDateTime($start_time->format('c'));
    
    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    
    $event = new Google_Service_Calendar_Event();
    
    $event->setStart($googleStartTime);
    $event->setEnd($googleEndTime);
    $event->setSummary($title);
    
    $event = $service->events->insert($cal_id, $event);
    
    return $event->id;
}