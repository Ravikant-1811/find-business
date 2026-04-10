<?php
$place_id = $_GET['place_id'];
$key = "AIzaSyD3Y69gJInyxqJPd_RF-ZZT8TRXYNQn5MU";

$url = "https://maps.googleapis.com/maps/api/place/details/json?
place_id=$place_id
&fields=formatted_phone_number,website,opening_hours
&key=$key";

echo file_get_contents($url);