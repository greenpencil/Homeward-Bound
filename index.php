<?php

if (isset($_POST["S"]) && isset($_POST["F"])) {
    $start = $_POST["S"];
    $finish = $_POST["F"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Homeward Bound</title>

    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="./css/metro.css" rel="stylesheet"/>
    <link href="./css/metro-schemes.css" rel="stylesheet"/>
    <link href="./css/metro-responsive.css" rel="stylesheet"/>
    <link href="./css/metro-icons.css" rel="stylesheet"/>
    <link href="./css/homeward.css" rel="stylesheet"/>

    <script type="text/javascript">
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 53.479, lng: -2.249},
                zoom: 12
            });
        }
    </script>

</head>
<body>

<div class="app-bar darcula">
    <div class="makesmaller">
        <span class="app-bar-element">Homeward Bound</span>
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
            <button class="button success" id="current_location" onclick="geoLocate(window.infoWindow, window.map)">
                <span class="mif-satellite"></span></button>
        </div>
        <div class="input-control text">
            <input name="F" id="F" value="The University of Salford" type="text" placeholder="Finish">
        </div>
        <button id="get" class="button success">Get me home</button>

    </div>

    <div id="map" style="height:600px"></div>

    <br />

    <div class="crime-report" id="crime-report" style="display:none;">
        <div class="panel" data-role="panel" data-route-id="0"  style="display:none;">
            <div class="heading bg-emerald">
                <span class="title">Route 1</span>
            </div>
            <div class="content bg-white">
                <div class="grid">
                    <div class="row cells8">
                        <div class="cell colspan6">
                            <span id="category"></span>
                        </div>
                        <div class="cell colspan2" style="text-align:center;">
                            <h3 class="fg-emerald">Weighted score: <span id="score"></span></h3>

                            <h2><span id="crimes"></span></h2>
                            <h4>Total Crimes</h4></div>
                    </div>
                </div>
            </div>
        </div>
        <br />

        <div class="panel" data-role="panel" data-route-id="1" style="display:none;">
            <div class="heading bg-yellow">
                <span class="title">Route 2</span>
            </div>
            <div class="content bg-white">
                <div class="grid">
                    <div class="row cells8">
                        <div class="cell colspan6">
                            <span id="category"></span>
                        </div>
                        <div class="cell colspan2" style="text-align:center;">
                            <h3 class="fg-emerald">Weighted score: <span id="score"></span></h3>

                            <h2><span id="crimes"></span></h2>
                            <h4>Total Crimes</h4></div>
                    </div>
                </div>
            </div>
        </div>
        <br />


        <div class="panel" data-role="panel" data-route-id="2"  style="display:none;">
            <div class="heading bg-orange">
                <span class="title">Route 3</span>
            </div>
            <div class="content bg-white">
                <div class="grid">
                    <div class="row cells8">
                        <div class="cell colspan6">
                            <span id="category"></span>
                        </div>
                        <div class="cell colspan2" style="text-align:center;">
                            <h3 class="fg-emerald">Weighted score: <span id="score"></span></h3>

                            <h2><span id="crimes"></span></h2>
                            <h4>Total Crimes</h4></div>
                    </div>
                </div>
            </div>
        </div>
        <br />


        <div class="panel" data-role="panel" data-route-id="3"  style="display:none;">
            <div class="heading bg-red">
                <span class="title">Route 4</span>
            </div>
            <div class="content bg-white">
                <div class="grid">
                    <div class="row cells8">
                        <div class="cell colspan6">
                            <span id="category"></span>
                        </div>
                        <div class="cell colspan2" style="text-align:center;">
                            <h3 class="fg-emerald">Weighted score: <span id="score"></span></h3>

                            <h2><span id="crimes"></span></h2>
                            <h4>Total Crimes</h4></div>
                    </div>
                </div>
            </div>
        </div>
        <br />
    </div>

    <div class="route-dir" id="route-dir" style="display:none;">
        <h2>Directions</h2>

        <div>Dom's stuff goes here</div>
    </div>

    <br /><br />
    <h1>About</h1>

    <div>
        <p>Homeward Bound is a webapp which will decide the safest route for you to get home. By using weighted crimes
            from the Police's online database we check all possible routes and search around the route for the most
            crime, easily letting you know the safest path. After we compute the data we show it back to you so you can
            make a decision on how you travel.</p>

        <p>This app was created in 24 hours by Team Wiggle Wiggle at HackManchester 2015. Wiggle Wiggle were a team of 4
            2nd year Computer Science undergraduates from Salford University.</p>
    </div>
    <br />
    <h1>Help</h1>

    <div>
        <p>Homeward Bound is very simple to use, simply put in a start point and then put in your destination, if you're
            not sure where ou areyou can use the satellitte button and we will find you.</p>

        <p>If you require help during your travel please contact the police at 999 for emergencies or 101 for
            none-emergencies.</p>
    </div>
    <br />
    <h1>Contact</h1>

    <div>
        <p>Homeward Bound was created by:</p>
        <ul>
            <li>Frontend design and Javascript - Katie Paxton-Fear</li>
            <li>Backend, crime and map data - Lewis Campbell</li>
            <li>Backend, algorithm for finding crimes - Dominic Wright</li>
            <li>Backend, algorithm for weighting crimes - Tom Willington</li>
        </ul>
    </div>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="./js/metro.js"></script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiDz1ZZDf9DFvjXJuhHVnP-KBZXT5EIo8&callback=initMap&libraries=geometry"></script>

<script>
    var infoWindow;
    var map;

    var start;
    var finish;

    function geoLocate(infoWindow, map) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                var marker = new google.maps.Marker({
                    position: pos,
                    map: map,
                    title: 'location',
                    Label: 'A'
                });

                var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};
                var geocoder = new google.maps.Geocoder;

                geocoder.geocode({'location': latlng}, function (results, status) {
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
                google.maps.event.addListener(marker, 'click', function () {
                    infowindow.open(map, this);
                });

                map.setCenter(pos);
                map.setZoom(17);
            }, function () {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function codeAddress(address, map) {
        var geocoder = new google.maps.Geocoder;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }

    /**
    function perform() {
        // codeAddress($("#F").attr("value"), window.map);

        $.getJSON("backend/index.php?start=" + $("#S").val() + "&finish=" + $("#F").val(), function(json) {
            console.log("Test: " + json);
            $.each(json, function(index, v) {
                $.each(v, function(key, value) {
                    $('span[data-route-id=\"' + index + '\"').text(value["crimes"]["ratings-total"]);
                });
            });
        });
    }

    $("#get").click(perform);**/

    $("#get").click(function() {
        $.ajax({
            url: "backend/index.php",
            type: "get",
            data: {'start': $("#S").val(), 'finish': $("#F").val() }
        }).done(function(result)  {
            $('#crime-report').show();
            var json = $.parseJSON(result);

            $.each(json, function(index, v) {
                var route = $('[data-route-id=\"' + index + '\"]');
                route.find('#score').text(v["crimes"]["ratings-total"]);
                route.find('#crimes').text(v["crimes"]["crimes-total"]);
                
                var decodedPath = google.maps.geometry.encoding.decodePath(v["poly"]);
                
                var strokeColor;
                
                if(index == 0)
                    {
                        strokeColor="#008A00";
                    }
                else if(index == 1)
                    {
                        strokeColor="#E3C800";
                    }
                else if(index == 2)
                    {
                        strokeColor="#FA6800";
                    }
                else
                    {
                        strokeColor="#CE352C";
                    }
                    
                  var poly = new google.maps.Polyline({
                    path: decodedPath,
                    geodesic: true,
                    strokeColor: strokeColor,
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                  });
                    poly.setMap(window.map);

                $.each(v["crimes"], function(key, value) {
                    if (key == "crimes-total" && key == "ratings-total") return;
                    route.find("#category").html(route.find("#category").html() +
                            "<h5><b>" + key.replace('-', ' ').replace('-', ' ') + "</b>:&nbsp;" + value + "</h5>"
                    );
                });
                
                route.show();
            });
        }).fail(function()  {
            alert("Sorry. Server unavailable. ");
        });
    });
</script>
</body>
</html>
