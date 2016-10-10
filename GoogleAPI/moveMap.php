<?php

include_once 'Classes/Curl.php';
use connect as Curl;

$key = 'AIzaSyC3LjkARjbGJoXw6VdKVVIG8_nYTbtY37s';
$address = trim(str_replace(' ', '+', $_POST['address']));
$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key;
$curl = new Curl\Curl($url);
$results = $curl->returnResults();
$lat = $results['results'][0]['geometry']['location']['lat'];
$lng = $results['results'][0]['geometry']['location']['lng'];
//$coordinates = $lat . ', ' . $lng;
$coordinates = [0=>$lat, 1=>$lng];

echo json_encode($coordinates,true);



