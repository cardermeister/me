<?php

    $current = json_decode(file_get_contents("./geo.json"),true);
    $input4 = json_decode(file_get_contents("php://input"),true);

    $phone = $input4["locations"][0]["properties"]["device_id"];
    if(!$phone)exit("nophone");
    if($phone=="00000000000")exit("00000000000");

    $lat = floatval($input4["locations"][0]["geometry"]["coordinates"][1]);
    $lon = floatval($input4["locations"][0]["geometry"]["coordinates"][0]);
    //$speed = $_GET['speed'];
    $batt = floatval($input4["locations"][0]["properties"]["battery_level"]);
    
    $update = time();
    $acc = floatval($input4["locations"][0]["properties"]["horizontal_accuracy"]);
    //$dir = $_GET['dir'];

    $current[$phone] = array(
        "lat" => $lat,
        "lon" => $lon,
        "speed" => $speed,
        "acc" => $acc,
        "dir" => $dir,
        "batt" => round($batt*100),
        "update" => $update
    );

    header('Content-Type: application/json');
    if($input4=="")
    {
        echo json_encode(["result"=>"no"]);
    }
    else
    {
        file_put_contents("./geo.json", json_encode($current));
        echo json_encode(["result"=>"ok"]);
    }
    //http://partum-logistic.ru/gps/getcoord.php?lat=%LAT&lon=%LON&speed=%SPD&battery=%BATT&acc=%ACC&dir=%DIR&update=%TIME&phone=00000000000


?>
