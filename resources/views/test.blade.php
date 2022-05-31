<?php
define("API_KEY", "AIzaSyDcBCPH0mGrTWWZnWWKzyLvTx06lBeNFAs");
?>
<html>
<head>
    <title>How to draw route Path on Map using Google Maps Direction API in PHP | Tutorialswebsite</title>
    <style>
        #map-layer {
            max-width: 900px;
            min-height: 550px;
        }
        .lbl-locations {
            font-weight: bold;
            margin-bottom: 15px;
        }
        .locations-option {
            display:inline-block;
            margin-right: 15px;
        }
        .btn-draw {
            background: green;
            color: #ffffff;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>
<body>
<p>How to draw Path on Map using Google Maps Direction API</p>
<div class="lbl-locations">Travel Mode</div>

<div>
    <input type="radio" name="travel_mode" class="travel_mode" value="WALKING"> WALKING

    <input type="radio" name="travel_mode" class="travel_mode" value="DRIVING" checked> DRIVING
</div>
<div>&nbsp;</div>
<div class="lbl-locations">Way Points</div>
<div>


    <div class="locations-option"><input type="text" id="origin" name="way_start" class="way_points" placeholder="Start from" value="New Delhi"> </div>
    <br>
    <br>

    <div class="locations-option"><input type="text" id="destination" name="way_end" class="way_points" placeholder="Destination" value="Gurgaon"> </div>
    <input type="button" id="drawPath" value="Draw Path" class="btn-draw" />
    <br>
    <br>
</div>

<div id="map-layer"></div>
<script>
    var map;
    var waypoints;
    function initMap() {
        var mapLayer = document.getElementById("map-layer");
        var centerCoordinates = new google.maps.LatLng(28.6139, 77.2090);
        var defaultOptions = { center: centerCoordinates, zoom: 8 }
        map = new google.maps.Map(mapLayer, defaultOptions);

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        directionsDisplay.setMap(map);

        $("#drawPath").on("click",function() {
            var start =$("#origin").val();
            var end = $("#destination").val();
            drawPath(directionsService, directionsDisplay,start,end);

        });

    }
    function drawPath(directionsService, directionsDisplay,start,end) {
        directionsService.route({
            origin: start,
            destination: end,
            optimizeWaypoints: true,
            travelMode: $("input[name='travel_mode']:checked"). val()
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Problem in showing direction due to ' + status);
            }
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo API_KEY; ?>&callback=initMap">
</script>

</body>
</html>