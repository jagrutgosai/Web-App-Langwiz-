 <?php  
  require_once 'configurationdb.php';
  if(isset($_GET['loginMessage'])){
      $loginMessage=$_GET['loginMessage'];
  }else $loginMessage="";
?>
<html>

<head>
  <title>LangWiz</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="ajax/ajaxLocation.js"></script>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
  <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src=".\js\geolocalization.js"></script>
  <script type="text/javascript" src=".\js\passwordValidation.js"></script>


</head>

<body>
<!--Modal-->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div  class="modal-dialog" role="document">
     <form  action="phpFiles/LoginHandler.php" method="get">
    <div class="modal-content" id="boxmodal">
      <div class="modal-header text-center">
      <h3 class="modal-title w-100 font-weight-bold">Welcome</h3>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-email">User Name :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="userName" required>
         </div>

        <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-pass">Password :</label>
          <input type="password" id="defaultForm-password" class="form-control validate" name="userPassword" required>
          
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <input type="submit" class="btn btn-default" id="login" name="Login" value="Login"/>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!--Modal-->
<div class="modal fade" id="modalSignIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div  class="modal-dialog" role="document">
     <form  action="create_Account.php" method="get" onsubmit="validatePassword()">
    <div class="modal-content" id="boxmodal2">
      <div class="modal-header text-center">
      <h3 class="modal-title w-100 font-weight-bold">Create an Account</h3>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-text">User Name :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="userName" required>
         </div>
		<div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-text">First Name :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="firstName" required>
         </div>
		 <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-text">Last Name :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="LastName" required>
         </div>
          <div class="md-form mb-5">

          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-email">Email :</label>
          <input type="text" id="defaultForm-text" class="form-control validate" name="email" required>
         </div>
         <div class="md-form mb-5">
          
         <label data-error="wrong" data-success="right" for="defaultForm-text">Country :</label>
         <select name="countryselect" id="countryselect" class="form-control validate" required>
    	   <option value="" id = "firstOption"></option>
         
            <?php              
              $sqlStmt="Select Distinct Country from location ORDER BY Country";
              $queryId=mysqli_query($connection, $sqlStmt);
              while($rec=mysqli_fetch_array($queryId))
              {
                $country=$rec["Country"];              
                echo "<option value='$country'>$country</option>";
               }?>
  		  </select>
  		  </div>
  		    
       
  		  <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-text">City :</label>          
           <?php  
           echo '<select name="cityselect" id="city" class="form-control validate" required>';
           echo '<option value="" id = "cityFirstOption"></option>';
           echo "<option value='$city'>$city</option>";
           ?>
             </select>
         </div>
		 <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
           <label data-error="wrong" data-success="right" for="defaultForm-email">Mother Language :</label>
          <select name="motherlang" id="motherlang" class="form-control validate">
          <option value=""></option>
            
          <?php 
            $sqlStmt="Select LangName from languages";
            $queryId=mysqli_query($connection, $sqlStmt);
            
            while($rec=mysqli_fetch_array($queryId)){
               $langName=$rec["LangName"];
               echo "<option value='$langName'>$langName</option>";
             }?>
          </select>
         </div>
		 
        <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-pass">Password :</label>
          <input type="password" id="password1" class="form-control validate" name="userPassword"  onkeyup='validatePassword();' required> 
        </div>
		<div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-pass"> Repeat Password :</label>
          <input type="password" id="password2" class="form-control validate" name="userPasswordconfirm"   onkeyup='validatePassword();' required> 
        </div>
		<div class="md-form mb-4">
          <span id="errorMatch"></span><br/>
          <span id="errorPassw"></span>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <input type="submit" class="btn btn-default" id="createacc" name="CreateAcc" value="Create Account" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    </form>
  </div>
</div>




  <div id="main">
    <div id="header">
	
      <div id="logo">
		<div id="logoimgenes"></div>
        <div id="logo_text">
		
          <h1><a href="index.php">Lang<span class="logo_colour">Wiz</span></a></h1>
          <h2>The new way to learn a new language</h2>
		  <div id="loginbox">
		  <button class="buttons" data-toggle="modal" data-target="#modalLogin">Login</button>
		  <button class="buttons" data-toggle="modal" data-target="#modalSignIn">Sign In</button>
		  </div>
		   <div class="clr"></div>
        </div>
      </div>
	 
      <div id="menubar">
        <ul id="menu">
          
          <li class="selected"><a href="index.php">Home</a></li>
          <li><a href=#howtostartmark>How to Start</a></li>
          <li><a href=#OurMssionmark>Our Mission</a></li>
          <li><a href=#contactusmark>Contact Us</a></li>
        </ul>
      </div>

    </div>
    <div id="content_header"></div>
    <h5 id="messagedd"><?php echo $loginMessage?></h5>
    <div id="site_content">
      <div id="banner"></div>
	  <div id="sidebar_container">
        <div class="sidebar">
          <div class="sidebar_top"></div>
          <div class="sidebar_item">

            <h3>Latest News</h3>
            <h5><strong>Now you can find friends in other countries</strong></h5>
            <h5>October 1st, 2021</h5>
            <p> Take a look around and let us know what you think.<br /><a href="#">Read more</a></p>
          </div>
          <div class="sidebar_base"></div>
        </div>
        <div class="sidebar">
          <div class="sidebar_top"></div>
          <div class="sidebar_item">
            <h3>Useful Links</h3>
            <ul>
              <li><a href="https://translate.google.ca">Google Translate</a></li>
              <li><a href="https://www.google.com/">Google</a></li>
              <li><a href="https://www.google.ca/maps">Google Maps</a></li>
              <li><a href="#">link 4</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
        
      </div>
      <div id="content">
        <!-- insert the page content here -->
        <h1>Welcome to <span id="langwiz">LangWiz</span></h1>
        <p>With LangWiz you can learn and practice a new language, find new friends, share and get to know new cultures.</p>
		<p>We already know how complicated it is to practice a new language, especially if you are in a place or surrounded by people who speak the same mother tongue as you, and despite taking language courses there comes a point where you need to put your knowledge into practice.</p>
		<p>That is why LangWiz is created that It allows you to meet another person who speaks the language you want to improve and in turn you can help that person to know and share your language and culture. </p>
        <h2 class="title2">It is time to learn a new language</h2>
        <p>In this Website you can :</p>
        <ul>
          <li>Explore New Cultures</li>
          <li>Meet new frieds</li>
          <li>Learn as many languages as you want</li>
        </ul>
     <span id="howtostartmark"></span>
      <div id="HowToStart">
      	<h1>How to Start</h1>
         <ul>
              <li>First Create an Account
              	<ul>
              		<li>Click here to create an account  <button class="buttons" data-toggle="modal" data-target="#modalSignIn">Sign In</button></li>
              		<li>Add all the Requested Information and password </li>
              		<li>Now you can Login</li>
              	</ul>
              </li>
              <li>Second Log in to account <button class="buttons" data-toggle="modal" data-target="#modalLogin">Login</button>
              	<ul>
              		<li>Now you can update your account</li>
              		<li>Add a profile picture</li>
              		<li>And the most important start connection and practicing a new language</li>
              	</ul>
              </li>
            
          </ul>
      </div>
      
      </div>
    </div>
    <span id="OurMssionmark"></span>
    <div id="OurMssion">
        <div id="popuplogo">
          	<div id="lwLogoPopup"></div>
         </div>
         <div id="Mission">
             <h2 class="title2">Our Mission</h2>
             <p>In Lanwiz we understand that everyone learn in a different way. Or mision is to create a platform that allows people to learn at once and help each other.
             </br>Beyond the classroom, in LangWiz you can share experiences, culture, and hear first-hand the correct pronunciation of the language you want to learn.
             </br>Our ultimate goal is that everyone have the opportunity of learn and connect with more people through technology.</p>
         </div>
     </div>
      <span id="contactusmark"></span>
     <div id="contactus">
     <h2 class="title2">Contact Us</h2>
     	<div id="map">
     		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.91767465899!2d-73.58371338420238!3d45.49160253963517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc91a6c597e5669%3A0x8dbf497cbd80d838!2sColl%C3%A8ge%20LaSalle!5e0!3m2!1sen!2sca!4v1637006746025!5m2!1sen!2sca" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
     	</div>
     	<div id="contacusText">
     		<h3>Our location</h3>
     		<p>Rez-de-chaussee, 2000 Saint-Catherine St W, Montreal, Quebec</p>
     		<h3>Call us at :</h3>
     		<p>(438) 564-98-44</p>
     		<h3>Or email us at :</h3>
     		<p>langwizsupport@langwiz.com</p>
     		
     	</div>
     	
     </div>
     <div class="clear"></div>
    <div id="content_footer"></div>
    <div id="footer">
      <p><a href="index.php">Home</a> | <a href=#howtostartmark>How to Start</a> | <a href=#OurMssionmark>Our Mission</a>|<a href=#contactusmark>Contact Us</a></p>
      <p>Copyright &copy;  WebServer Applications - Group 3
    </div>
  </div>
  
  
  
</body>
</html>
