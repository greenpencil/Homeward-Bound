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
    $noCrimes = calculateCrimeStats($dataSet);
    $crimeWeightData = weightCrimes($dataSet)[0];
    $crimeFreqData = weightCrimes($dataSet)[1];

    generateRoot($noCrimes, $crimeWeightData, $crimeFreqData, $directions, $polylines);
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

function calculateCrimeStats($dataSet)
{
    $noCrimes = array();
    foreach ($dataSet as $data) {
        array_push($noCrimes, count($data));
    }
    return $noCrimes;
}

function weightCrimes($dataSet)
{
    $crimeFrequenciesArray = array();
    $totals = array();
    foreach ($dataSet as $data) {
        $count = 0;
        $crimeFrequencies = array(
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
        );

        foreach ($data as $crime) {
            switch ($crime->category) {
                case "possession-of-weapons":
                    $count += 9;
                    $crimeFrequencies["possession-of-weapons"] += 1;
                    break;
                case "violent-crime":
                    $count += 9;
                    $crimeFrequencies["violent-crime"] += 1;
                    break;
                case "theft-from-the-person":
                    $count += 8;
                    $crimeFrequencies["theft-from-the-person"] += 1;
                    break;
                case "robbery":
                    $count += 8;
                    $crimeFrequencies["robbery"] += 1;
                    break;
                case "anti-social-behaviour":
                    $count += 7;
                    $crimeFrequencies["anti-social-behaviour"] += 1;
                    break;
                case "public-order":
                    $count += 4;
                    $crimeFrequencies["public-order"] += 1;
                    break;
                case "vehicle-crime":
                    $count += 4;
                    $crimeFrequencies["vehicle-crime"] += 1;
                    break;
                case "burglary":
                    $count += 3;
                    $crimeFrequencies["burglary"] += 1;
                    break;
                case "criminal-damage-arson":
                    $count += 2;
                    $crimeFrequencies["criminal-damage-arson"] += 1;
                    break;
                case "drugs":
                    $count += 1;
                    $crimeFrequencies["drugs"] += 1;
                    break;
                case "bicycle-theft":
                    $count += 2;
                    $crimeFrequencies["bicycle-theft"] += 1;
                    break;
                case "other-theft":
                    $count += 1;
                    $crimeFrequencies["possession-of-weapons"] += 1;
                    break;
                case "shoplifting":
                    $count += 1;
                    $crimeFrequencies["shoplifting"] += 1;
                    break;
                case "other-crime":
                    $crimeFrequencies["other-crime"] += 1;
                    $count += 1;
                    break;
            }
        }
        array_push($totals, $count);
        array_push($crimeFrequenciesArray, $crimeFrequencies);
    }
    return array($totals, $crimeFrequenciesArray);
}

function generateRoot($noCrimes, $crimeWeightData, $crimeFreqData, $directions, $polyline) {
    $root = array($noCrimes, $crimeWeightData, $crimeFreqData, $directions, $polyline);
    $json = json_encode($root, JSON_PRETTY_PRINT);
    print(htmlspecialchars($json));
}
?>

