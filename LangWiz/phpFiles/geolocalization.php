<?php
/*This is in progress we couldn't finish this funcionality*/
/*$latLong=$_GET['place'];
$result=(explode("/",$latLong));
$lat=$result[0];
$long=$result[1];
var_dump($latLong);*/
function getNearPlaces($distanceKM, $limitDisplay, $lat, $long) {
    require_once 'configurationdb';
    $arCities = array();
    $EARTH_APROX_RADIUS=6371;
    $queryId = mysqli_query($conection, $sqlStmt);
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
                LIMIT $limitDisplay;";
    if($queryId)
    {
        while($rec = mysqli_fetch_assoc($queryId))
        {
            $City=$rec["City"];
            $Country= $rec["Country"];
            $arCities[$City]=$Country;
        }
        echo json_encode($arCities);
        return $arCities;
    }   
}


echo 'function getLocation() //ID just to display error message
{
    //verifies if the browser support
    if (navigator.geolocation) {
        window.alert("Working until here2"); //#testing
        navigator.geolocation.getCurrentPosition(success);
    }else {
        alert("Geolocation is not supported by this browser.");
    }
}
    
function getDistance(latX, longX, latY, longY)
{
    distKM = Math.sqrt((latX-latY)**2 + (longX-longY)**2);
    return distKM;
}
    
function success(position) {
    var latitude = position.coords.latitude;
    alert(latitude);
    var longitude = position.coords.longitude;
    alert(longitude);
    //Now we just have to pass the values to the function in php to get the city
    //something like this
    var arrContryAndCity = ';
//$rec= getNearPlaces(1,1,$lat,$long);
//echo json_encode($rec);
//echo 'document.getElementById("firstOption").value = arrContryAndCity[0];
 // document.getElementById("cityFirstOption").value = arrContryAndCity[1];
 //   };';
?>