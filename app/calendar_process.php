<?php
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon; // 時刻をAPI用の書式に形成する用のライブラリ

// API接続
function getClient() {
    require_once('putenv.php'); //環境変数読み込み
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP CONNECTOR');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAuthConfig(get_env('GOOGLE_AUTH'));

    return $client;
}

// [Calendar]イベントの挿入(開始時間の記録)
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
    
    $client = getClient(); // 接続
    $service = new Google_Service_Calendar($client);
    
    $event = new Google_Service_Calendar_Event();
    
    $event->setStart($googleStartTime);
    $event->setEnd($googleEndTime);
    $event->setSummary($title);
    
    $event = $service->events->insert($cal_id, $event);
    
    return $event->id; // イベントIDを返す
}

// [Calendar]イベントの変更(作業終了時刻登録)
function edit_event($cal_id, $event_id){
    
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    
    $calendarId = $cal_id;
    $eventId = $event_id;
    
    $tz = new DateTimeZone('Asia/Tokyo');
    $finish_time = Carbon::create(
        date(Y),
        date(m),
        date(d),
        date(H),
        date(i),
        date(s),
        $tz
    );
    
    $googleEndTime = new Google_Service_Calendar_EventDateTime();
    $googleEndTime->setTimeZone($tz);
    $googleEndTime->setDateTime($finish_time->format('c'));
    
    $event = $service->events->get($calendarId, $eventId);
    $event->setEnd($googleEndTime);
    
    $updatedEvent = $service->events->update($calendarId, $event->getId(), $event);
}