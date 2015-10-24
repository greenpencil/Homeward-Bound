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
        <script type="text/javascript">
            var map;
            function initMap() {
              map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
              });
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
        </div>
    </body>
</html>
