<?php 
require_once 'configurationdb.php';

$cName=$_GET['countryName'];


if(!empty($cName)){
    $sqlStmt="select City from location where Country='$cName'";

    $queryId=mysqli_query($connection,$sqlStmt);

        
   $rec = mysqli_fetch_all($queryId,MYSQLI_ASSOC);
  
    echo json_encode($rec);
//parse an array to teh Json 
}
mysqli_close($connection);
?>