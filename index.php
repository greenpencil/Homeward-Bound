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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="./js/metro.js"></script>
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiDz1ZZDf9DFvjXJuhHVnP-KBZXT5EIo8&callback=initMap&libraries=geometry"></script>

        <script>
            // Note: This example requires that you consent to location sharing when
            // prompted by your browser. If you see the error "The Geolocation service
            // failed.", it means you probably did not give permission for the browser to
            // locate you.
            
            var infoWindow;
            var map;
            
            var start;
            var finish;

            function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 53.479, lng: -2.249},
                    zoom: 12
                });                

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
            
            function codeAddress(address, map) {
                var geocoder = new google.maps.Geocoder;
                geocoder.geocode( { 'address': address}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                  } else {
                    alert("Geocode was not successful for the following reason: " + status);
                  }
            });
          }

            $(document).on('click', '#get-me', function()
            {
                codeAddress(document.getElementById("F").value, window.map);
                $.ajax({
                    url: './getroutes.php',
                    type: 'get',
                    data: {'start': document.getElementById("S").value, 'finish': document.getElementById("F").value }
                }).done(function(e){
                  //  
                  //  var decodedLevels = decodeLevels("BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB");
                  //  setRegion = new google.maps.Polyline({
                  //      locations: decodedPath,
                   //     levels: decodedLevels,
                   //     strokeColor: "#FF0000",
                   //     strokeOpacity: 1.0,
                 //       strokeWeight: 2,
                   //     map: window.map
                //   });
                    
                    var decodedPath = google.maps.geometry.encoding.decodePath(e);
                    
                    var routemap = [
                    {lat: 37.772, lng: -122.214},
                    {lat: 21.291, lng: -157.821},
                    {lat: -18.142, lng: 178.431},
                    {lat: -27.467, lng: 153.027}
                  ];
                  var route = new google.maps.Polyline({
                    path: decodedPath,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                  });
                    
                        route.setMap(window.map);
                });
                //codeAddress(document.getElementById("S").value, window.map);
                 //codeAddress(document.getElementById("F").value, window.map);
             });
            
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
                <div class="input-control file" data-role="input">
                        <input name="S" id="S" type="text" placeholder="Start">
                        <button class="button success" id="current_location" onclick="geoLocate(window.infoWindow, window.map)"><span class="mif-satellite"></span></button>
                </div>
                <div class="input-control text">
                    <input name="F" id="F" value="The University of Salford" type="text" placeholder="Finish">
                </div>
                <button id="get-me" class="button success">Get me home</button>
            
            </div>
            
            <div id="map" style="height:70%"></div>
            
            <div class="crime-report" id="crime-report">
                <div class="grid">
                    <div class="row cells5">
                        <div class="cell col"></div>
                        ...
                        <div class="cell"></div>
                    </div>
                </div>
            </div>
            
            
        <div class="leader align-center">About</div>
        <div>
            <p>Homeward Bound is a webapp which allows you 
        </div>
        
        
        </div>
    </body>
</html>