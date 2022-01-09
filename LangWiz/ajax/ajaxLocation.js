$(document).ready(function(){
//console.log("hello");
	$( "#countryselect" ).change(function() {		
	var selectedCountry = $(this).children("option:selected").val();      
  $.getJSON( "./FindCity.php?countryName="+selectedCountry, function( data ) {
  console.log(data); 
    var items="";
    $("#city").empty();
    $("#city").append("<option value=''></option>");
      $.each( data, function(key,val) {
        items += "<option value='" + val.City + "'>" + val.City + "</option>" ;
      });
  $("#city").append($(items)); 
  });
	});
});