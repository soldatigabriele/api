<?php

include_once '../Classes/Curl.php';
use connect as Curl;

//if (isset($_POST['address'])) {
//    $coordinates = '';
//    $key = 'AIzaSyC3LjkARjbGJoXw6VdKVVIG8_nYTbtY37s';
//    $address = trim(str_replace(' ', '+', $_POST['address']));
//    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key;
//    $curl = new Curl\Curl($url);
//    $results = $curl->returnResults();
//    $lat = $results['results'][0]['geometry']['location']['lat'];
//    $lng = $results['results'][0]['geometry']['location']['lng'];
//    echo '<script>alert(' . $lat . ',' . $lng . ');</script>';
//    echo '<script>updateCoordinats(23.123213,-54.1231);</script>';
//}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            width: 900px;
            max-height: 500px;
            height: 100%;
        }
    </style>
</head>
<body>
<form action="../index.php" method="post"><input type="submit" value="Back"></form>
<br>
<!--<form action="../moveMap.php" method="post">-->

<input type="text" value="42a Cannon street, Preston, UK" id="address" name="address">
<input type="submit" id="update">
<!--</form>-->
<div id="map"></div>

<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
        crossorigin="anonymous"></script>
<script>
    var map;
//starting coordinates
    var lati = -34.456;
    var long = 150.623;

    function updateCoordinats(lat, lng) {
//        alert('updateCoordinates');
        lati = lat;
        long = lng;
        initMap();
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lati, lng: long},

            zoom: 7
        });
    }


    //jquery db function
    $(document).ready(function () {
//retrieve the data from the database
        $("#update").click(function () {
            var address = {address: $("#address").val()};
//            alert(address);
            $.ajax({
                url: "../moveMap.php",
                type: "POST",
                data: address,
                success: function (msg) {
//                    alert(msg);
                    lat = msg[0];
                    lng = msg[1];
                    updateCoordinats(lat,lng);
                },
                dataType: "json"
            });
        });
    })
    ;

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvJyXlleH21wnBwtpgHCD51iJpUUn1A04&callback=initMap"
        async defer></script>
</body>
</html>
