<?php
setlocale(LC_TIME, "sv_SE.UTF-8");
include("functions-prettify.php");

function filterCalendarEvents($calendarEvents, $get) {

  if(isset($get['location'])){
    $location = $get['location'];
    $cities = citiesWithEvents();
    if (in_array_any_case(strtolower($location), $cities)) {
      $calendarEvents = array_filter($calendar_events, 'filterEventsByCity');
    }
  }
  return $calendarEvents;
}

function filterEventsByCity($event) {
  //return (strtolower($event->location) == strtolower($chosen_city));
  return strpos(strtolower($event->location), strtolower($chosen_city)) > -1;
}

function fetchCalendarEvents(){
  $events_json = file_get_contents("calendar-items.json");
  return json_decode($events_json);
}

function citiesWithEvents(){
  // #todo
  // Automatically extract list of cities from .json
  return ['Uppsala', 'Göteborg', 'Linköping', 'Sundsvall','Gävle', 'Piteå', 'Kalmar', 'Stockholm'];
}

function in_array_any_case($needle, $haystack) {
    return in_array(strtolower($needle), array_map('strtolower', $haystack));
}
?>
