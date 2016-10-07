<?php

include 'Classes/DB.php';

$dbh = DB::getInstance();
$properties = [];
$houses = $dbh->query('houses');
$results = $dbh->results();
$count= $dbh->count();
for ($i = 0; $i<$count; $i++){
    $house = $results[$i]->lat.', '.$results[$i]->lng;
    $properties[] = $house;
}
//return the array with the coordinates of the properties
echo json_encode($properties);








