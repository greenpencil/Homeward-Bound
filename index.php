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
            var infoWindow;
            var map;
            
            var start;
            var finish;
            
             //$('#crime-report').hide();
             //$('#route-dir').hide();
            
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
                    $('#crime-report').fadeIn(250);
                    $('#route-dir').fadeIn(250);
                });
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
            
            <div class="crime-report" id="crime-report" style="display:none;">
                <h2>Crime Report</h2>
                <div class="grid">
                    <div class="row cells8">
                        <div class="cell colspan6">
                            <p><h5>Theft: 38</h5></p>
                            <p><h5>Theft: 38</h5></p>
                            <p><h5>Theft: 38</h5></p>
                        </div>
                        <div class="cell colspan2" style="text-align:center;"><h2>38</h2><br/><h4>Total Crimes</h4></div>
                    </div>
                </div>
            </div>
            
            <div class="route-dir" id="route-dir" style="display:none;">
                <h2>Directions</h2>
                <div>Dom's stuff goes here</div>
            </div>
            
        <br/></br>
        <h1>About</h1>
        <div>
            <p>Homeward Bound is a webapp which will decide the safest route for you to get home. By using weighted crimes from the Police's online database we check all possible routes and search around the route for the most crime, easily letting you know the safest path. After we compute the data we show it back to you so you can make a decision on how you travel.</p>
            <p>This app was created in 24 hours by Team Wiggle Wiggle at HackManchester 2015. Wiggle Wiggle were a team of 4 2nd year Computer Science undergraduates from Salford University.</p>
        </div>
        </br>
        <h1>Help</h1>
        <div>
            <p>Homeward Bound is very simple to use, simply put in a start point and then put in your destination, if you're not sure where ou areyou can use the satellitte button and we will find you.</p>
            <p>If you require help during your travel please contact the police at 999 for emergencies or 101 for none-emergencies.</p>
        </div>
        </br>
        <h1>Contact</h1>
        <div>
            <p>Homeward Bound was created by:
                <ul>
                    <li>Frontend design and Javascript - Katie Paxton-Fear</li>
                    <li>Backend, crime and map data - Lewis Campbell</li>
                    <li>Backend, algorithm for finding crimes - Dominic Wright</li>
                    <li>Backend, algorithm for weighting crimes - Tom Willington</li>
                </ul>
            </p>
        </div>
        
        </div>
    </body>
</html>