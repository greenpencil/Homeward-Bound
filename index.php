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
        
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="./css/metro.css" rel="stylesheet" />
        <link href="./css/metro-schemes.css" rel="stylesheet" />
        <link href="./css/metro-responsive.css" rel="stylesheet" />
        <link href="./css/metro-icons.css" rel="stylesheet" />
        <link href="./css/homeward.css" rel="stylesheet" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="./js/metro.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiDz1ZZDf9DFvjXJuhHVnP-KBZXT5EIo8&callback=initMap"></script>

        <script>
            // Note: This example requires that you consent to location sharing when
            // prompted by your browser. If you see the error "The Geolocation service
            // failed.", it means you probably did not give permission for the browser to
            // locate you.
            
            var infoWindow;
            var map;

            function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 53.479, lng: -2.249},
                    zoom: 12
                });
                infoWindow = new google.maps.InfoWindow({map: map});
                

                // Try HTML5 geolocation.
                //geoLocate(infoWindow);
            }
            
            function geoLocate(infoWindow, map)
            {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        var marker = new google.maps.Marker({
                            position: pos,
                            map: map,
                            title: 'location',
                            Label: 'A',
                          });
                        var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};
                        var geocoder = new google.maps.Geocoder;
                        
                        geocoder.geocode({'location': latlng}, function(results, status) {
                            if (status === google.maps.GeocoderStatus.OK) {
                              if (results[1]) {
                                infowindow.setContent(results[1].formatted_address);
                                  S.value = results[1].formatted_address;
                              } else {
                                window.alert('No results found');
                              }
                            } else {
                              window.alert('Geocoder failed due to: ' + status);
                            }
                          });
                        
                        var infowindow = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker, 'click', function() {
                            //infowindow.setContent("place.name");
                            infowindow.open(map, this);
                          });
                        
                        //S.value = "Your Location";

                        //infoWindow.setPosition(pos);
                        //infoWindow.setContent('Location found.');
                        map.setCenter(pos);
                        map.setZoom(17);
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
                <h2>Need to get home? Let us help!</h2>
                <form autocomplete="off" action="" method="POST" role="form" enctype="multipart/form-data">
                <div class="input-control file" data-role="input">
                        <input name="S" id="S" type="text" placeholder="Start">
                        <button class="button success" id="current_location" onclick="geoLocate(window.infoWindow, window.map)"><span class="mif-satellite"></span></button>
                </div>
                <div class="input-control text">
                    <input name="F" id="F" type="text" placeholder="Finish">
                </div>
                <button type="submit"  class="button success">Get me home</button>
            </form>
            </div>
            
            <div id="map" style="height:70%"></div>
            
            <div class="crime-report">
                crime report to go here
            </div>
            
            
        <div class="leader align-center">About</div>
        <div>
            <p>HomeWard Bound is a website app developed to get a person home via the safest route available to them, avoiding routes with a high level of crime rate in previous months.
            Hopefully giving the person the safest route to their destination. Some more words to describe it....</p>
        </div>
        
        
        </div>
    </body>
</html>