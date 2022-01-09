<?php
require_once 'dbconfig.php';
$sqlStmt="Select Distinct City from location WHERE Country = $country ORDER BY City";
$queryId=mysqli_query($connection, $sqlStmt);

while($rec2=mysqli_fetch_array($queryId)){
    $city=$rec2["City"];}
    echo '<option value="$city">$city</option>';//#testing

?>