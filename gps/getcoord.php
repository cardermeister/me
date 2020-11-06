<?php

    $phone = $_GET['phone'];
    if(!$phone)exit("nophone");
    if($phone=="00000000000")exit("00000000000");

    $current = json_decode(file_get_contents("./geo.json"),true);

    $lat = floatval($_GET['lat']);
    $lon = floatval($_GET['lon']);
    $speed = $_GET['speed'];
    $batt = floatval($_GET['battery']);
    $update = strtotime($_GET['update']);
    $acc = $_GET['acc'];
    $dir = $_GET['dir'];

    $current[$phone] = array(
        "lat" => $lat,
        "lon" => $lon,
        "speed" => $speed,
        "acc" => $acc,
        "dir" => $dir,
        "batt" => $batt,
        "update" => $update
    );

    file_put_contents("./geo.json", json_encode($current));
    //http://partum-logistic.ru/gps/getcoord.php?lat=%LAT&lon=%LON&speed=%SPD&battery=%BATT&acc=%ACC&dir=%DIR&update=%TIME&phone=00000000000
?>
