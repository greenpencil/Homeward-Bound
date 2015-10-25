<?php
returnMaps("Manchester", "Salford");

function returnMaps($origin, $dest) {
    $origin = str_replace(" ", "+", $origin);
    $dest = str_replace(" ", "+", $dest);
    $routes = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $dest . "&key=AIzaSyDPIf8XDKguqBgJo5VzM8eurWmMmOvWxB0&alternatives=true&mode=walking");
    $json = json_decode($routes, true);
    $steps = array();
    $directions = array();
    $polylines = array();
    $i = 0;
    foreach ($json["routes"] as $route) {
        $directions[$i] = array();
        $steps[$i] = array();
        array_push($polylines, $route["overview_polyline"]["points"]);
        foreach ($route["legs"][0]["steps"] as $step) {
            $lat = $step["end_location"]["lat"];
            $long = $step["end_location"]["lng"];
            $html_instructions = $step["html_instructions"];
            array_push($steps[$i], array($lat, $long));
            array_push($directions[$i], $html_instructions);
        }
        $i++;
    }
    $polySet = calculatePoly($steps, 0.01);
    $dataSet = getCrimeData($polySet);
    $crimeRatings = weightCrimes($dataSet);

    generateRoot($crimeRatings, $directions, $polylines, $origin, $dest);
}


function calculatePoly($steps, $distance) {
    $out = array();
    foreach ($steps AS $stepsRoute) {
        $arr = array();
        for ($i = 0; $i < count($stepsRoute) - 1; $i++) {
            array_push($arr, plotPoints($stepsRoute[$i][0], $stepsRoute[$i][1], $stepsRoute[$i + 1][0], $stepsRoute[$i + 1][1], $distance));
        }

        $new = array();
        foreach ($arr AS $ar) {
            foreach ($ar AS $point) {
                $new[] = $point;
            }
        }
        array_push($out, $new);
    }
    return $out;
}

function calculateTheta($x1, $y1, $x2, $y2) {
    $tanTheta = ($y2 - $y1) / ($x2 - $x1);
    $theta = rad2deg(atan($tanTheta));
    return $theta;
}

function plotPoints($x1, $y1, $x2, $y2, $d) {
    $theta = calculateTheta($x1, $y1, $x2, $y2) + 45;
    return array(
        array($d * cos($theta) + $x1, $d * sin($theta) + $y1),
        array(-$d * sin($theta) + $x1, -$d * cos($theta) + $y1),
        array(-$d * cos($theta) + $x1, -$d * sin($theta) + $y1),
        array($d * sin($theta) + $x1, $d * cos($theta) + $y1),
    );
}

function getCrimeData($polySet) {
    $policeJsonArray = array();
    for ($i = 0; $i < count($polySet); $i++) {
        $latLngStr = "";
        for ($j = 0; $j < count($polySet[$i]); $j++) {
            $lat = $polySet[$i][$j][0];
            $lng = $polySet[$i][$j][1];
            $latLngStr = $latLngStr . ":" . $lat . "," . $lng;
        }
        array_push($policeJsonArray, makePoliceAPIRequest($latLngStr));
    }
    $policeDecodedJsonArray = array();
    foreach ($policeJsonArray as $json) {
        array_push($policeDecodedJsonArray, json_decode($json));
    }
    return $policeDecodedJsonArray;
}

function makePoliceAPIRequest($latLngStr) {
    return file_get_contents("https://data.police.uk/api/crimes-street/all-crime?poly=" . $latLngStr . "&date=2015-08");
}

function weightCrimes($dataSet)
{
    $valuesTotal = array();
    foreach ($dataSet as $data) {
        $rating = 0;
        $values = array(
            "possession-of-weapons" => 0,
            "violent-crime" => 0,
            "theft-from-the-person" => 0,
            "robbery" => 0,
            "anti-social-behaviour" => 0,
            "public-order" => 0,
            "vehicle-crime" => 0,
            "burglary" => 0,
            "criminal-damage-arson" => 0,
            "drugs" => 0,
            "bicycle-theft" => 0,
            "other-theft" => 0,
            "shoplifting" => 0,
            "other-crime" => 0,
            "crimes-total" => count($data),
            "ratings-total" => 0
        );

        foreach ($data as $crime) {
            switch ($crime->category) {
                case "possession-of-weapons":
                    $rating += 9;
                    $values["possession-of-weapons"] += 1;
                    break;
                case "violent-crime":
                    $rating += 9;
                    $values["violent-crime"] += 1;
                    break;
                case "theft-from-the-person":
                    $rating += 8;
                    $values["theft-from-the-person"] += 1;
                    break;
                case "robbery":
                    $rating += 8;
                    $values["robbery"] += 1;
                    break;
                case "anti-social-behaviour":
                    $rating += 7;
                    $values["anti-social-behaviour"] += 1;
                    break;
                case "public-order":
                    $rating += 4;
                    $values["public-order"] += 1;
                    break;
                case "vehicle-crime":
                    $rating += 4;
                    $values["vehicle-crime"] += 1;
                    break;
                case "burglary":
                    $rating += 3;
                    $values["burglary"] += 1;
                    break;
                case "criminal-damage-arson":
                    $rating += 2;
                    $values["criminal-damage-arson"] += 1;
                    break;
                case "drugs":
                    $rating += 1;
                    $values["drugs"] += 1;
                    break;
                case "bicycle-theft":
                    $rating += 2;
                    $values["bicycle-theft"] += 1;
                    break;
                case "other-theft":
                    $rating += 1;
                    $values["possession-of-weapons"] += 1;
                    break;
                case "shoplifting":
                    $rating += 1;
                    $values["shoplifting"] += 1;
                    break;
                case "other-crime":
                    $values["other-crime"] += 1;
                    $rating += 1;
                    break;
            }
        }
        $values["ratings-total"] = $rating;
        array_push($valuesTotal, $values);
    }
    return $valuesTotal;
}

function generateRoot($crimeRatings, $directions, $mapsPoly, $start, $end) {
    $results = array();
    for ($i=0; $i<count($directions) && $i<count($crimeRatings) && $i<count($mapsPoly); $i++) {
        array_push($results, array(
            "crimes" => $crimeRatings[$i],
            "directions" => $directions[$i],
            "poly" => $mapsPoly[$i]
        ));
    }
    print(htmlspecialchars(json_encode($results, JSON_PRETTY_PRINT)));
}
?>
