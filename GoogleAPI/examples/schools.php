<?php

include '../Classes/DB.php';
$dbh = DB::getInstance();
$properties = [];
if (isset($_POST['age'])) {
    $age = $_POST['age'];

//    takes the first 2 or 3 letters of the postcode
    $postcode = str_replace(' ','',$_POST['postcode']);
    if(strlen($postcode) > 5){
        $postcode = substr($postcode,0,3);
    }elseif(strlen($postcode) <= 5){
        $postcode = substr($postcode,0,2);
    }
    $fields = "POSTCODE LIKE '".$postcode." %' AND AGEL < " . $age . " AND AGEH >" . $age;
    $schools = $dbh->query('schools', $fields);
    $results = $dbh->results();
    $count = $dbh->count();
    for ($i = 0; $i < $count; $i++) {
        $schools = $results[$i]->TOWN . ', ' . $results[$i]->LOCALITY . ', ' . $results[$i]->POSTCODE . ', age: ' . $results[$i]->AGEL . '-' . $results[$i]->AGEH;
        $properties[] = $schools;
    }
    echo '<pre>';
    print_r($properties);
    echo '</pre>';
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Schools Search</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100%;
            width: 100%;
            height: 500px;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>
<form action="../index.php" method="post"><input type="submit" value="Back"></form>

<h4>Google Places</h4>
<form action="" method="post">
    <input type="text" name="postcode" value="PR1 3TH">
    <select name="age">
        <?php
        for($i = 2;$i<20;$i++){
            echo '<option value="'.$i.'"';
            if($i == 12){echo 'selected="selected"';}
            echo '>'.$i.'</option>';
        }
        ?>
    </select>
    <input type="submit">
</form>
<br>
<!--<div id="map"></div>-->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACjsYdnvLjrfMIGq4gqfOlcvMCrocFfIU&callback=initMap&libraries=places,visualization"
    async defer></script>

<script>
    var map;
    var infoWindow;
    var service;
    var markers = {};
    var keyword;

    function queryCheck(e) {
        keyword = e.value;
        if (e.checked == true) {
            markers[keyword] = [];
            performSearch(keyword);
        } else {
            google.maps.event.clearListeners(map, 'click');
            remove(keyword);
            keyword = null;
        }
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 53.482478, lng: -2.232023},
            zoom: 14,
            styles: [{
                stylers: [{visibility: 'simplified'}]
            }, {
                elementType: 'labels',
                stylers: [{visibility: 'off'}]
            }]
        });

        infoWindow = new google.maps.InfoWindow();
        service = new google.maps.places.PlacesService(map);

        // The idle event is a debounced event, so we can query & listen without
        // throwing too many requests at the server.
        map.addListener('idle', performSearch);
    }

    function performSearch() {
//            remove the markers when you move the map
//            remove();
        var request = {
            bounds: map.getBounds(),
            keyword: keyword
        };
        service.radarSearch(request, callback);
//            inserts an array into the markers object
    }

    function callback(results, status) {
        if (status !== google.maps.places.PlacesServiceStatus.OK) {
            console.error(status);
            return;
        }
        for (var i = 0, result; result = results[i]; i++) {
            addMarker(result);
        }
    }

    function addMarker(place) {
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            icon: {
                url: 'http://maps.gstatic.com/mapfiles/circle.png',
                anchor: new google.maps.Point(10, 10),
                scaledSize: new google.maps.Size(10, 17)
            }
        });

        google.maps.event.addListener(marker, 'click', function () {
            service.getDetails(place, function (result, status) {
                if (status !== google.maps.places.PlacesServiceStatus.OK) {
                    console.error(status);
                    return;
                }
                infoWindow.setContent(result.name);
                infoWindow.open(map, marker);
            });
        });
//            saves the markers in the array
        markers[keyword].push(marker);

    }

    var remove = function (keyword) {

        for (var i = 0; i < markers[keyword].length; i++) {
            markers[keyword][i].setMap(null);
        }
        markers[keyword] = [];
    }
</script>
</body>
</html>
