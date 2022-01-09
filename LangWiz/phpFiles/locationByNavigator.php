<?php
    require_once 'configurationdb';
    $arCities = array();
    $lat=$_GET['latitude'];
    $long=$_GET['longitude'];
    $EARTH_APROX_RADIUS=6371;
    echo "hi"; 
    
    $sqlQuery = "SELECT g.GeopositioningID, l.City, l.Country,
                ($EARTH_APROX_RADIUS * acos(
                 cos( radians($lat) )
                 * cos( radians( g.GeoLat ) )
                 * cos( radians( g.GeoLong ) - radians($long) )
                 + sin( radians($lat) )
                 * sin( radians( g.GeoLat ) )
                 )) AS Distance
                FROM geolocalization g
                join location l ON g.GeopositioningID = l.GeopositioningID
                HAVING Distance < 25
                ORDER BY Distance ASC
                LIMIT 1;";
    $queryId = mysqli_query($conection, $sqlQuery);
    if($queryId)
    {
        $rec = mysqli_fetch_assoc($queryId);    
        $City=$rec["City"];
        $Country= $rec["Country"];
        $arCities[$City]=$Country;        
    }   
    echo json_encode($arCities);
?>