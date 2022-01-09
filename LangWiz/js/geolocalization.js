
function getLocation() //ID just to display error message
 {
    //verifies if the browser support
  if (navigator.geolocation) {
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
  var longitude = position.coords.longitude;
  $(document).ready(function(){
    console.log("Your longitude is " + longitude);
    console.log("Your latitude is " + latitude); //Working until here
    $.getJSON("./phpFiles/locationByNavigator.php?latitude="+latitude+"?longitude=" +longitude, function (arrContryAndCity){
      console.log(arrContryAndCity[0]);
      $("#firstOption").innerHTML = arrContryAndCity[0];
      $("#cityFirstOption").innerHTML = arrContryAndCity[1];
    });
  });
};

function error(err) {
  console.warn('ERROR(' + err.code + '): ' + err.message);
};

//Albelis : sorry I try to fixed but fail :()
/*function getLocation() //ID just to display error message
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
 // alert(latitude);
  var longitude = position.coords.longitude;
 // alert(longitude);
/*var location= latitude+"/"+longitude;
$.getJSON( "../phpFiles/geolocalization.php?place="+location, function( data ) {
console.log(data); 
  /*var arrContryAndCity = <?php include_once '../phpFiles/geolocalization.php';echo getNearPlaces(1,1,latitude,longitude);?>;
  document.getElementById("firstOption").innerHTML = arrContryAndCity[0];
  document.getElementById("cityFirstOption").innerHTML = arrContryAndCity[1];*/
/*var items="";
 $("#city").empty();
 $("#city").append("<option value=''></option>");
 $("#countryselect").empty();
 $("#countryselect").append("<option value=''></option>");
  $.each( data, function(key,val) {
    items += "<option value='" + val.City + "'>" + val.City + "</option>" ;
  });

 $("#city").append($(items));

});
}
function error(err) {
  console.warn('ERROR(' + err.code + '): ' + err.message);
}*/

