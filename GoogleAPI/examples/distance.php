<?php
//DISTANCE API

include_once '../Classes/Curl.php';
use connect as Curl;


echo ' <form action="../" method="post"><input type="submit" value="Go Back"></form> ';
echo '<h3>Google APIs</h3>';

if (isset($_POST['go'])) {

    $distanceMatrix = 'AIzaSyD-k9nEAGUP5Ppyv0JLWdtVm8c7kOW_YOg';
    $origin = trim(str_replace(' ', '', $_POST['origin']));
    $destination = trim(str_replace(' ', '', $_POST['destination']));
    $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=' . $origin . '&destinations=' . $destination . '&key=' . $distanceMatrix;
    
    $curl = new Curl\Curl($url);
    $json = $curl->returnResults();

    echo 'It takes <strong>';
    print_r($json['rows'][0]['elements'][0]['duration']['text']);
    echo '</strong> from <strong>';
    print_r($json['origin_addresses'][0]);
    echo '</strong> to <strong>';
    print_r($json['destination_addresses'][0]);
    echo '</strong>.';
    echo ' Distance: <strong>';
    print_r($json['rows'][0]['elements'][0]['distance']['text']);
    echo '</strong><br><br>';
}
?>
<br><br>Try:<br> 53.483458, -2.237089 <br> 53.483177, -2.237261 <br> Aberdeen, UK <br> Manchester UK <br><br>

<form action="" method="post">
    departure from: <input type="text" name="origin">
    destination: <input type="text" name="destination">
    <input type="submit" name="go" value="calculate distance">
</form>