<?php 
require_once 'configurationdb.php';
require 'Account.Class.php';

$connection = new PDO("mysql:host=$hostname; dbname=$dbname",$username, $password);





if(isset($_GET["userName"])){$userName=$_GET["userName"];}
if(isset($_GET["firstName"])){ $firstName=$_GET["firstName"];}
if(isset($_GET["LastName"])){ $lastName=$_GET["LastName"];}
if(isset($_GET["email"])){ $email=$_GET["email"];}
if(isset($_GET["countryselect"])){ $country=$_GET["countryselect"];}
if(isset($_GET["cityselect"])){ $city=$_GET["cityselect"];}
if(isset($_GET["motherlang"])){ $langu=$_GET["motherlang"];}
if(isset($_GET["userPassword"])){ $password=$_GET["userPassword"];}



if(isset($_GET['CreateAcc']))
{
 
    $ac= new Account($userName,$firstName, $lastName,"img/default.jpg",
        $country,$city,$email, $password, $langu);
   
    if($ac->createAccount($connection)>0){
        header("Location:index.php"); 
        echo "<script>alert('The account has been created!')</script>";
    }
    else{
        header("Location:index.php"); 
        echo '<script>alert("The account was not created!!")</script>';
    }
}

?>