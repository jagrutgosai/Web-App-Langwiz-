<?php
include_once "configurationdb.php";
require_once 'Account.Class.php';
$connection = new PDO("mysql:host=$hostname; dbname=$dbname",$username, $password);

session_start();

$userID=$_SESSION["userid"];
$path = "uploads/";
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	$name = $_FILES['photo']['name'];
	$size = $_FILES['photo']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)) {
			if($size<(1024*1024)) {
			    $image_name = time()."userID".$userID.".".$ext;
				$tmp = $_FILES['photo']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$image_name)){
				    
				    $ac1=new Account();
				    $ac1->setUserID($userID);
				    $ac1->setPhoto( $path.$image_name);
				    $result=$ac1->update($connection,"ph","o");
				  
					echo "<img id='userpicture' src='uploads/".$image_name."' class='preview'>";
				    }
				else
				echo "Image Upload failed";
			}
			else
			echo "Image file size max 1 MB";
		}
		else
		echo "Invalid file format..";
	}
	else
	echo "Please select image..!";
	exit;
}
?>