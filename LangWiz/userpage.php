<?php 
require_once 'configurationdb.php';


session_start();
$userName=$_SESSION["userName"];
$userFname=$_SESSION["FName"];
$userLname=$_SESSION["LName"];
$userEmail=$_SESSION["email"];
$userLang=$_SESSION["lang"];
$userCountry=$_SESSION["country"];
$userCity=$_SESSION["city"];
$badgenumber=$_SESSION["badgesNumber"];
$userBadges=$_SESSION["badges"];
$message=$_SESSION["message"];

$resultconn=$_SESSION["myconnections"];
$nbconnections=count($resultconn);

$resultMessages=$_SESSION["mymessages"];
$nbMessagess=count($resultMessages);

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
              <li class="active"><a href="userpage.php"> <i class="fa fa-user"></i> Profile</a></li>
              <li><a href="SearchOtherUsers.php"> <i class="fa fa-connections"></i> Meet New People</a></li>
              <li><a href="MyConnections.php" name="seeConnec"> <i class="fa fa-connections"></i> My Connections<span class="label label-warning pull-right r-activity"><?=$nbconnections?></span></a></li>
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
              <input type="submit" name="post" class="btn btn-warning pull-right" value="Post"/>
               </form>
          </footer>
      </div>
      <div class="panel">
          <div  class="bio-graph-heading">
              <p id="postedstatus" ><?=$message?></p>
          </div>
          <div class="panel-body bio-graph-info">
              <h1>Your Information</h1>
              <div class="row">
                  <div class="bio-row">
                      <p><span>First Name </span>: <?=$userFname?></p>
                  </div>
                  <div class="bio-row">
                      <p><span>Last Name </span>: <?=$userLname?></p>
                  </div>
                  <div class="bio-row">
                      <p><span>Country </span>:<?=$userCountry?></p>
                       <p><span>City </span>:<?=$userCity?></p>
                  </div>
                  
                  <div class="bio-row">
                      <p><span>Language </span>:<?=$userLang?></p>
                  </div>
                  <div class="bio-row">
                      <p><span>Email </span>: <?=$userEmail?></p>
                  </div>
                 
              </div>
             
          </div>
      </div>
      <div>
          <div class="row">
              <div class="col-md-6">
                  <div class="panel">
                  	<div id="badgeimg"></div>
                      <div class="panel-body">
                          <div class="bio-chart">
                              <div style="display:inline;width:100px;height:100px;"><canvas width="100" height="100px"></canvas><input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value=<?=$badgenumber?> data-fgcolor="#e06b7d" data-bgcolor="#e8e8e8" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 20px; line-height: normal; font-family: Arial; text-align: center; color: rgb(224, 107, 125); padding: 0px; -webkit-appearance: none; background: none;" readonly></div>
                          </div>
                          <div class="bio-desk">
                              <h4 class="red">Langwiz Badges</h4>
                              <p><?=$userBadges?></p>
                              <p><?=$badgenumber?></p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="panel">
                      <div class="panel-body">
                      	<div id="meetingsimg"></div>
                          <div class="bio-chart">
                              <div style="display:inline;width:100px;height:100px;"><canvas width="100" height="100px"></canvas><input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value=<?=$nbconnections?> data-fgcolor="#4CC5CD" data-bgcolor="#e8e8e8" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 20px; line-height: normal; font-family: Arial; text-align: center; color: rgb(76, 197, 205); padding: 0px; -webkit-appearance: none; background: none;" readonly></div>
                          </div>
                          <div class="bio-desk">
                              <h4 class="terques">Connections</h4>
                              <p>Your connections <span><?=$nbconnections?></span></p>
                              <p>Messages <span><?=$nbMessagess?></span></p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="panel">
                      <div class="panel-body">
                      <div id="rewardsimg"></div>
                          <div class="bio-chart">
                              <div style="display:inline;width:100px;height:100px;"><canvas width="100" height="100px"></canvas><input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value=<?=$badgenumber*$nbconnections?> data-fgcolor="#96be4b" data-bgcolor="#e8e8e8" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 20px; line-height: normal; font-family: Arial; text-align: center; color: rgb(150, 190, 75); padding: 0px; -webkit-appearance: none; background: none;" readonly></div>
                          </div>
                          <div class="bio-desk">
                              <h4 class="green">Rewards</h4>
                              <p>Stars : <?=$badgenumber*$nbconnections?></p>
                              <p>Points: <?=$badgenumber*122*$nbconnections?></p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="panel">
                  <div id="langimg"></div>
                      <div class="panel-body">
                          <div class="bio-chart">
                              <div style="display:inline;width:100px;height:100px;"><canvas width="100" height="100px"></canvas><input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value="1" data-fgcolor="#cba4db" data-bgcolor="#e8e8e8" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 20px; line-height: normal; font-family: Arial; text-align: center; color: rgb(203, 164, 219); padding: 0px; -webkit-appearance: none; background: none;" readonly></div>
                          </div>
                          <div class="bio-desk">
                              <h4 class="purple">Language</h4>
                              <p><?=$userLang?></p>
                              
                          </div>
                      </div>
                  </div>
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

</body>
</html>
