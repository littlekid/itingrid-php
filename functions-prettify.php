<?php
function pretty_date($date) {
  // $date = "YYYY-MM-DD";
  $parts = explode("-", $date);
  return strftime('%a %-d %B', mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
}
?>
