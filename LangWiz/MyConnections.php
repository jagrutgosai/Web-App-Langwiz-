<?php 
require_once 'configurationdb.php';


session_start();
$resultconn=$_SESSION["myconnections"];
$nbconnections=count($resultconn);    //NUMBER OF CONNECTIONS PER USER TO BE USE IN THE REWARDS

$resultMessages=$_SESSION["mymessages"];
$nbMessagess=count($resultMessages);

$userID= $_SESSION["userid"];
$userName=$_SESSION["userName"];
$userFname=$_SESSION["FName"];
$userLname=$_SESSION["LName"];
$userEmail=$_SESSION["email"];
$message=$_SESSION["message"];
$userCity=$_SESSION["city"];


$sqlStmt="Select Photo from users where Username='$userName'";
$queryId=mysqli_query($connection, $sqlStmt);
while($rec=mysqli_fetch_array($queryId))
{
    $userPhoto=$rec["Photo"];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>user profile</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/style2.css" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	  <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
	  <script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	  <script type="text/javascript" src="js/upload.js"></script>
	<script type="text/javascript" src="js/connection.js"></script>
</head>

<body>

<div id="main">
    <div id="header">
	
		
      <div id="logo">
		<div id="logoimgenes"></div>
        <div id="logo_text">
		
         
          <h1><a href="index.php">Lang<span class="logo_colour">Wiz</span></a></h1>
          <h2>The new way to learn a new language</h2>
		  <div id="loginbox">

		 
		  <form method="get" action="phpFiles/LoginHandler.php">
		  	 	<input type="submit" class="buttons" name="logOut" value="Log Out"></input>
		  </form>
		  </div>
		   <div class="clr"></div>
        </div>
      </div>
	 

 <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<div id="UserAccContainer" class="container bootstrap snippets bootdey" >
<div class="row">
  <div class="profile-nav col-md-3">
      <div  class="panel">
          <div class="user-heading round">
             <!-- Here after we can include the option to change the picture -->
             
              
                  <div id='preview'><?php echo "<img id='userpicture' src='$userPhoto' class='preview'>"?></div>	
				<form id="image_upload_form" method="post" enctype="multipart/form-data" action='image_upload.php' autocomplete="off">
					<div class="file_input_container">
						<div class="upload_button"><input type="file" name="photo" id="photo" class="file"/>
						<label for="photo">Change Picture</label></div>
					</div><br clear="all">
				</form>
             
              <h1><?=$userName?></h1>
              <h2><?php echo "$userFname  $userLname"?></h2>
              <p><?=$userEmail?></p>
          </div>

          <ul class="nav nav-pills nav-stacked">
              <li ><a href="userpage.php"> <i class="fa fa-user"></i> Profile</a></li>
              <li ><a href="SearchOtherUsers.php"> <i class="fa fa-connections"></i> Meet New People</a></li>
              <li class="active"><a href="MyConnections.php" name="seeConnec"><i class="fa fa-connections"></i> My Connections<span class="label label-warning pull-right r-activity"><?=$nbconnections?></span></a></li>
              <li><a href="MyMessages.php" name="seeMess"><i class="fa fa-connections"></i> My Messages<span class="label label-warning pull-right r-activity"><?=$nbMessagess?></span></a></li>
              <li><a data-toggle="modal" data-target="#modalUpdate"> <i class="fa fa-edit"></i> Edit profile</a></li>
          </ul>
      </div>
  </div>
   <div class="profile-info col-md-9">
      <div class="panel">
          <form method="get" action="phpFiles/LoginHandler.php">
              <textarea name="mystatus" id="status" placeholder="Whats in your mind today?" rows="2" class="form-control input-lg p-text-area" ></textarea>
         
          <footer class="panel-footer">
              <input type="submit" name="post2" class="btn btn-warning pull-right" value="Post"/>
               </form>
          </footer>
      </div>
       <div class="panel">
          <div  class="bio-graph-heading">
              <p id="postedstatuss" name="status"><?=$message?></p>
          </div>
          <div class="panel-body bio-graph-info">
             
                <div id="containerSearchU">
                  <h2>Your Connections</h2>
               
                  		 	 <input type="button"  data-toggle="modal" data-target="#modalSendMessage" class="btn btn-warning pull-right" name="usersClose" value="Send a message"/>
                  		            
                 </div>
                 <div id="containerTableSearch">
                  
                    
                    <table class="table2" >
                 
                  
                  <?php 
                  
                  if(sizeof($resultconn)>0){
                      foreach($resultconn as $data){
                              $userIdD=$data["UserID"];
                              $firstName=$data["FName"];
                              $lastName=$data["LName"];
                              $photo=$data["Photo"];
                              $language=$data["LangName"];
                              $message=$data["personalMsg"];
                              $country=$data["Country"];
                              $city=$data["City"];
                              $email=$data["EmailAddress"]; 
                    ?>
                   
                    <tbody>
           
                    <tr>    
                    <td>
                		<div class="row">
                          <div class="picCol">
                                      
                               <img id="userPict" src=<?=$photo?> alt="userphoto"/>
                            
                          </div>
                          
                        </div>
               		 </td>        
                      <td style="margin-left: 10px;margin-right: 25px;padding-right: 25px;">
                      <span class="descrip">My name is</span></br><?php echo "$firstName $lastName"?></td>
                      <td><span class="descrip">I speak</span></br><?=$language?></td>
                      <td><span class="descrip">Contact me</span></br><?=$email?></td>
                      <td><span class="descrip">I am from</span></br><?php echo "$country $city"?></td>
                      <td><span class="descrip">Something About me</span></br><?=$message?></td>
                      <td><button  name="connectbtn" class="btn btn-warning pull-right deleteuser" value=<?=$userIdD?>>Delete</button></td>
                    </tr>
                  
                    <?php }}
                    else{
                        echo "Ups! You don't have any connections =(";
                    }
                    
                  
                  
                   ?>
                  </tbody>
                </table>
                </div>
 
          </div>
      </div>
  </div>
</div>
</div>



<!-- MODAL FOR UPDATE PROFILE -->

<!--Modal-->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div  class="modal-dialog" role="document">
     <form  action="phpFiles/LoginHandler.php" method="get">
    <div class="modal-content" id="boxmodal2">
      <div class="modal-header text-center">
      <h3 class="modal-title w-100 font-weight-bold">Edit Profile Account</h3>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-text">User Name :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="userNameEdit" >
         </div>
		<div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-text">First Name :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="firstNameEdit" >
         </div>
		 <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-text">Last Name :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="LastNameEdit" >
         </div>
          <div class="md-form mb-5">

          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-email">Email :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="emailEdit" >
         </div>
          <div class="modal-footer d-flex justify-content-center">
        <input type="submit" class="btn btn-default" id="createacc" name="editProfile" value="Edit Profile" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
        
</div>
</div>
</form>
</div>
</div>
</div>
</div>

<!-- MODAL SEND A MESSAGE -->

<div class="modal fade" id="modalSendMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div  class="modal-dialog" role="document">
     <form  action="phpFiles/LoginHandler.php" method="get">
    <div class="modal-content" id="boxmodal2">
      <div class="modal-header text-center">
      <h3 class="modal-title w-100 font-weight-bold">Send a Message</h3>
      </div>
      
         <div class="md-form mb-5">
          
         <label data-error="wrong" data-success="right" for="defaultForm-text">Select User :</label>
         <select name="userselect" id="userMessageselect" class="form-control validate" required>
    	   <option value=""></option>
         
            <?php
            if(sizeof($resultconn)>0){
                foreach($resultconn as $data){
                    $usID=$data["UserID"];
                    $userNames=$data["Username"];
                    $firstName=$data["FName"];
                    $lastName=$data["LName"];
                    $photo=$data["Photo"];
                    
                         
                echo "<option value=' $usID'>$userNames $firstName $lastName</option>";
                }}?>
  		  </select>
  		  </div>
  		  
        <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-pass">Your message :</label>
           <textarea name="mymessge" id="message"  rows="4" class="form-control input-lg p-text-area validate" required></textarea>
        </div>
		
      <div class="modal-footer d-flex justify-content-center">
        <input type="submit" class="btn btn-default" id="createacc" name="sendMessage" value="Send" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    </form>
  </div>
</div>

</body>
</html>
