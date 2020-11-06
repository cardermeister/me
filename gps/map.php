<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

?>
<html>
<head>
    <title>Partum GPS map</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="icon" href="http://partum-logistic.ru/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="http://partum-logistic.ru/favicon.ico" type="image/x-icon">

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=959e026e-d8db-452d-849c-760c29e5f782" type="text/javascript"></script>
    
    <script src="/gps/mainjs.js"></script>

	<style>
        html, body, #map {
            width: 100%; height: 100%; padding: 0; margin: 0;
        }
    </style>
</head>
<body>
    <div id="map"></div>
</body>
</html>