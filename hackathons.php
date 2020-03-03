<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hackathons i Sverige 2020</title>
  <link rel="stylesheet" href="design.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:title" content="Hackathons i Sverige 2020" />
  <meta property="og:description" content="Upptäck och delta på hackathons runtom i Sverige."/>
  <meta property="og:url" content="https://itingrid.se/hackathons"/>
  <!-- Expire - because I do update content regurarly, and the page loads fairly quickly anyway :] -->
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
</head>
<body>
    <h1>Hackathons</h1>
  <div id="calendar">

      <?php
setlocale(LC_TIME, "sv_SE.UTF-8");

function pretty_date($date) {
  // $date = "YYYY-MM-DD";
  $parts = explode("-", $date);
  return strftime('%a %-d %B %Y', mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
}

      $events_json = file_get_contents("calendar-items.json");
      $calendar_events = json_decode($events_json);
      $items = "";
      $location_filter = $GET['location'];
      if (isset($_GET['location']) && in_array(strtolower($_GET['location']), $cities_with_events)) {
        $chosen_city = strtolower($_GET['location']);

        function filterArray($event){
          global $chosen_city;
          //return (strtolower($event->location) == strtolower($chosen_city));
          return strpos(strtolower($event->location), strtolower($chosen_city)) > -1;
        }

        $calendar_events = array_filter($calendar_events, 'filterArray');
      }

      foreach ($calendar_events as $event_item) {
        if($event_item->category == "hackathon") {
          $items .= '<div class="calendar-item" data-type="' . $event_item->category . '">';
          $items .= "<h2>" . $event_item->headline . "</h2>";
          $items .= '<p><span class="location">' . $event_item->location . '</span>';
          $items .= pretty_date($event_item->date) . "</p>";
          $items .= '<h3>'.$event_item->description_headline.'</h3>';
          $items .= '<p>'.$event_item->description_first.'</p>';
          if($event_item->description_second){
          $items .= '<p>'.$event_item->description_second.'</p>';
          }
          if($event_item->description_third){
            $items .= '<p>'.$event_item->description_third.'</p>';
          }
          if($event_item->description_fourth){
            $items .= '<p>'.$event_item->description_third.'</p>';
          }
          if($event_item->description_fifth){
            $items .= '<p>'.$event_item->description_third.'</p>';
          }
          $items .= '<p><a href="'.$event_item->link.'" target="_blank">'.$event_item->link_text.'</a></p>';
          $items .= '</div>';
        }
      }
      echo $items;
    ?>

  </div>

<?php

      $cities_with_events = array("göteborg","lund","luleå","jönköping","malmö","piteå","skåne","stockholm","uppsala");
      if (isset($_GET['location']) && in_array(strtolower($_GET['location']), $cities_with_events)) {
        echo "<p style='font-size: 1.8rem; text-align: center; margin: 13vh auto 0'>IT-kalender för " . ucfirst($_GET['location']) . ".</p>";
      } else {
        echo '<p>Poulära orter: <a href="/Göteborg">Göteborg</a>, <a href="/Jönköping">Jönköping</a>, <a href="/Lund">Lund</a>, <a href="/Stockholm">Stockholm</a>, <a href="/Uppsala">Uppsala</a></p>';
      }
?>
<style>
body {
  max-width: 840px;
  margin: 2rem auto 1rem;
  padding-left: 2rem;
  padding-right: 2rem;
}

#hackathons-list {
  margin: calc(3rem + 13vh) 0 0;
  padding: 0;
  list-style: none;
  font-size: 1.3rem;
}

#hackathons-list li:not(:first-child) {
  margin-top: 5rem;
}

h1 {
  font-size: 4rem;
  margin-top: calc(4rem + 13vh);
  margin-bottom: 4rem;
  font-family: monospace;
  text-align: center;
}

h2 {
  font-size: 2.4rem;
  margin-top: 4.2rem;
  font-family: sans-serif;
  color: #222;
  font-family: monospace;
  letter-spacing: -.06rem;
}

h2:first-of-type {
  margin-top: 1rem;
}

h2, h3 {
  margin-bottom: 2px;
}

h2 + ul {
  margin: 0 0 2rem;
  padding: 0;
}

h2 + ul li {
  display: inline;
}

h2 + ul li:first-child:not(:last-child):after {
  content: ", ";
}

h3 {
  font-size: 1.4rem;
}

p {
  margin-top: 2px;
  color: #333;
  font-size: 1.3rem;
  line-height: 130%;
}
</style>

</body>
</html>
