<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Radar Search</title>
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
    <div class="col-md-4">
        <input type="checkbox" value="primary school" onclick="queryCheck(this);">primary schools<br>
        <input type="checkbox" value="school" onclick="queryCheck(this);">schools<br>
        <input type="checkbox" value="college" onclick="queryCheck(this);">college<br>
        <input type="checkbox" value="university" onclick="queryCheck(this);">university<br>
    </div>
    <div class="col-md-4">
        <input type="checkbox" value="library" onclick="queryCheck(this);">libraries<br>
        <input type="checkbox" value="supermarket" onclick="queryCheck(this);">supermarkets<br>
        <input type="checkbox" value="train station" onclick="queryCheck(this);">train stations<br>
        <input type="checkbox" value="bus station" onclick="queryCheck(this);">bus stations<br>
    </div>
    <div class="col-md-4">
        <input type="checkbox" value="NHS" onclick="queryCheck(this);">NHS<br>
        <input type="checkbox" value="clinics" onclick="queryCheck(this);">clinics<br>
        <input type="checkbox" value="fast food" onclick="queryCheck(this);">fast foods<br>
        <input type="checkbox" value="pub" onclick="queryCheck(this);">pubs<br>
    </div>
</form>
<br>
<div id="map"></div>
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
//        var ico;
//        switch (keyword) {
//            case 'primary school':
//            case 'school':
//            case 'college':
//            case 'library':
//            case 'university':
//                ico = 'https://cdn3.iconfinder.com/data/icons/black-easy/512/538738-school_512x512.png';
//                break;
//            case 'supermarket':
//                ico = 'http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-11/512/shop-icon.png';
//                break;
//            case 'train station':
//                ico = 'https://openclipart.org/image/800px/svg_to_png/248358/train_pictogram.png';
//                break;
//            case 'bus station':
//                ico = 'http://www.clker.com/cliparts/6/N/5/z/E/y/bus-stop-sign-blue-md.png';
//                break;
//            case: 'NHS':
//                ico = 'https://usilive.org/wp-content/uploads/2015/01/NHS-logo.png';
//                ico = 'http://www.clker.com/cliparts/6/N/5/z/E/y/bus-stop-sign-blue-md.png';
//                break;
//            default:
//                ico = 'http://maps.gstatic.com/mapfiles/circle.png';
//                break;
//        }
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            icon: {
                url: 'http://maps.gstatic.com/mapfiles/circle.png',
                anchor: new google.maps.Point(10, 10),
                scaledSize: new google.maps.Size(10, 17)
            }
//            icon: {
//                url: ico,
//                anchor: new google.maps.Point(10, 10),
//                scaledSize: new google.maps.Size(20,20)
//            }
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