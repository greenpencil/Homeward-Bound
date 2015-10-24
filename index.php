<?php


/*function getCoordsLat($location){
    $loc = urlencode($location);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$loc&sensor=false";
    $json_result = json_decode(file_get_contents($url));

    $geo_result =  $json_result->results[0];
    $aCsv = $geo_result->geometry->location;

    return $aCsv->lat;
}

function getCoordsLng($location){
    $loc = urlencode($location);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$loc&sensor=false";
    $json_result = json_decode(file_get_contents($url));

    $geo_result =  $json_result->results[0];
    $aCsv = $geo_result->geometry->location;

     return $aCsv->lng;
}*/

if(isset($_POST["S"]) && isset($_POST["F"])) {
    $start = $_POST["S"];
    $finish = $_POST["F"];
}

?>
<html>
    <head>
        <title>Homeward Bound</title>
        
        <link href="./css/metro.css" rel="stylesheet" />
        <link href="./css/metro-schemes.css" rel="stylesheet" />
        <link href="./css/metro-responsive.css" rel="stylesheet" />
        <link href="./css/homeward.css" rel="stylesheet" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="./js/metro.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiDz1ZZDf9DFvjXJuhHVnP-KBZXT5EIo8&callback=initMap"></script>
        <script>
            // Note: This example requires that you consent to location sharing when
            // prompted by your browser. If you see the error "The Geolocation service
            // failed.", it means you probably did not give permission for the browser to
            // locate you.

            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: -34.397, lng: 150.644},
                    zoom: 6
                });
                var infoWindow = new google.maps.InfoWindow({map: map});

                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        infoWindow.setPosition(pos);
                        infoWindow.setContent('Location found.');
                        map.setCenter(pos);
                    }, function() {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            }

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
            }
    </script>
            </head>
    <body>
        <div class="app-bar darcula">
            <div class="makesmaller">
                <a class="app-bar-element" href="...">Homeward Bound</a>

                <span class="app-bar-divider"></span>

                <ul class="app-bar-menu">
                    <li><a href="">About</a></li>
                    <li><a href="">Help</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="main padding20">
            <div class="call-to-action">
                Need to get home? Let us help!
                <div class=""
            </div>
            <div id="map" style="height:50%"></div>
            <form autocomplete="off" action="" method="POST" role="form" enctype="multipart/form-data">
                <label>Start</label>
                <div class="input-control text">
                    <input name="S" id="S" type="text">
                </div>
                <label>Finish</label>
                <div class="input-control text">
                    <input name="F" id="F" type="text">
                </div>
                <button type="submit"  class="button success block-shadow-success text-shadow">Button</button>
                <button id="current_location" class="button success block-shadow-success text-shadow">From Current Location</button>
            </form>
        </div>
        <div class="leader align-center">About</div>
        <div>
            <p>HomeWard Bound is a website app developed to get a person home via the safest route available to them, avoiding routes with a high level of crime rate in previous months.
            Hopefully giving the person the safest route to there destination. Some more words to describe it....</p>
        </div>
    </body>
</html>