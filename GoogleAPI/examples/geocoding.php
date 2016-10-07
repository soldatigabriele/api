<?php

include_once '../Classes/Curl.php';
use connect as Curl;

echo ' <form action="../" method="post"><input type="submit" value="Go Back"></form> ';

if (isset($_POST['findAddress']) || isset($_POST['findCoordinates'])) {
    $key = 'AIzaSyC3LjkARjbGJoXw6VdKVVIG8_nYTbtY37s';
    if (isset($_POST['findAddress']) && ($_POST['coordinates'] != '')) {
        $coordinates = trim(str_replace(' ', '', $_POST['coordinates']));
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $coordinates . '&key=' . $key;
    } elseif (isset($_POST['findCoordinates'])) {
        $coordinates = '';
        $address = trim(str_replace(' ', '+', $_POST['address']));
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key;
    }
//initiate the call
    $curl = new Curl\Curl($url);
    $results = $curl->returnResults();
//    returns te coordinates or the complete address
    if (!$coordinates){
        print_r($results['results'][0]['geometry']['location']['lat']);
        echo ', ';
        print_r($results['results'][0]['geometry']['location']['lng']);
    }else{
        print_r($results['results'][0]['formatted_address']);
    }

}
echo '<br><hr><br><br>Try:<br> 53.483458, -2.237089 <br> 53.483177, -2.237261 <br><br>';

?>

<form action="" method="post">
    Insert coordinates:
    <input type="text" name="coordinates" value="">
    <input type="submit" name="findAddress" value="Find the address">
    <br>
    <hr>
    <br>Try:<br>
</form>
<form action="" method="post">
    4 Lloyd Street Manchester M2 5AB, UK <br>
    19 Peter Street Manchester M2 5GP, UK<br>
    <br><br>Insert an address:
    <input type="text" name="address" value="">
    <input type="submit" name="findCoordinates" value="Find the coordinates">
</form>





