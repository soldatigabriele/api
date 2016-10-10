<?php
define('FOLDER', 'examples/');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Google Maps APIs</title>
    <style>
        a {
            color:black;
            display: block;
            padding:5px;
        }
        a:visited{
            color:black;
        }
    </style>
</head>
<body>

<a href="<?php echo FOLDER; ?>JavascriptMap.html">A static <strong>Javascript Map</strong></a>
<a href="<?php echo FOLDER; ?>distance.php">Find the <strong>Distance</strong> between two places</a>
<a href="<?php echo FOLDER; ?>geocoding.php"><strong>Geocoding</strong>: find an address or the coordinates of a certain place</a>
<a href="<?php echo FOLDER; ?>places.php">Find <strong>Places</strong> near your place</a>
<a href="<?php echo FOLDER; ?>schools.php">Find <strong>Schools</strong> near your postcode (local DB)</a>
<a href="<?php echo FOLDER; ?>polygons.html"><strong>Draw</strong> on the map to find a house</a>

</body>
</html>