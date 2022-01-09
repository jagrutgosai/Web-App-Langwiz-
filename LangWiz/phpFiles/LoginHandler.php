<?php 
require_once '../configurationdb.php';
require '../Account.Class.php';

$connection = new PDO("mysql:host=$hostname; dbname=$dbname",$username, $password);


session_start();


if(isset($_GET["userName"])){$userName=$_GET["userName"];}
if(isset($_GET["userPassword"])){ $password=$_GET["userPassword"];}

if(isset($_GET['Login']))
{
    $ac =new Account();
    $ac->setUserName($userName);
    $ac->setPassword($password);
    if($ac->Login($connection)){
        header("Location:../userpage.php");
        $result=$ac->searchUserInformation($connection);
        if(sizeof($result)>0){

            $_SESSION["userid"]=$result[0]["UserID"];
            $_SESSION["userName"]=$result[0]["Username"];
            $_SESSION["FName"]=$result[0]["FName"];
            $_SESSION["LName"]=$result[0]["LName"];
            $_SESSION["Photo"]=$result[0]["Photo"];
            $_SESSION["email"]=$result[0]["EmailAddress"];
            $_SESSION["lang"]=$result[0]["LangName"];
            $_SESSION["country"]=$result[0]["Country"];
            $_SESSION["city"]=$result[0]["City"];
            $_SESSION["badgesNumber"]=$result[0]["BadgeID"];
            $_SESSION["badges"]=$result[0]["BadgeDesc"];
            $_SESSION["message"]=$result[0]["personalMsg"];
        }
    }
    else{
        
        
        header("Location:../index.php?loginMessage=Invalid Credentials!!,Try Again");
    }
    
    $ac->setUserID($_SESSION["userid"]);
    $resultconn=$ac->getMyConnections($connection);
    $_SESSION["myconnections"]=$resultconn;
    $resultMessages=$ac->getMyMessages($connection);
    
    $_SESSION["mymessages"]=$resultMessages;
    
    $nbconections=count($resultconn);
    $ac->update($connection,$nbconections,"3","4","5","6","7","8");
    
   
}

//STATUS MESSAGE
if(isset($_GET['post'])){
    if(isset($_GET["mystatus"])){$statusMessage=$_GET["mystatus"];}
    $userID= $_SESSION["userid"];
    $ac11 =new Account();
    $ac11->setUserID($userID);
  
    $ac11 -> setMessage($statusMessage);
    $result=$ac11->update($connection,'2','3','4','5','6');
        if($result==true)
        {
            $_SESSION["message"]=$statusMessage;
            echo  "Message has been updated";
        }
        else{
            $err=$connection->errorInfo();
            echo $err[2]."<br/>";
        }
        header("location:../userpage.php");
}
if(isset($_GET['post2'])){
    if(isset($_GET["mystatus"])){$statusMessage=$_GET["mystatus"];}
    $userID= $_SESSION["userid"];
    $ac11 =new Account();
    $ac11->setUserID($userID);
    
    $ac11 -> setMessage($statusMessage);
    $result=$ac11->update($connection,'2','3','4','5','6');
    if($result==true)
    {
        $_SESSION["message"]=$statusMessage;
        echo  "Message has been updated";
    }
    else{
        $err=$connection->errorInfo();
        echo $err[2]."<br/>";
    }
    header("location:../SearchOtherUsers.php");
}


//LOGOUT
if(isset($_GET['logOut'])){
    session_destroy();
    header("location:../index.php");
}

//UPDATE PROFILE
if(isset($_GET['editProfile'])){
    
    if(isset($_GET["userNameEdit"])){$userNameEdited=$_GET["userNameEdit"];}
    if(isset($_GET["firstNameEdit"])){$firstNameEdited=$_GET["firstNameEdit"];}
    if(isset($_GET["LastNameEdit"])){$lastNameEdited=$_GET["LastNameEdit"];}
    if(isset($_GET["emailEdit"])){$emailEdited=$_GET["emailEdit"];}
    
    
    $userID= $_SESSION["userid"];
    $ac1 =new Account();
    $ac1->setUserID($userID);
        
    if($userNameEdited!=""){
        $ac1 -> setUserName( $userNameEdited);
        $result=$ac1->update($connection);
        if($result==true)
        {
            $_SESSION["userName"]=$userNameEdited;
            echo  "The username has been updated";
        }
        else{
            $err=$connection->errorInfo();
            echo $err[2]."<br/>";
        }
    }
    
    if($firstNameEdited!=""){
        $ac1->setFirstName($firstNameEdited);
        $result=$ac1->update($connection,"FN");
        if($result==true)
        {
            $_SESSION["FName"]=$firstNameEdited;
            echo  "The first name has been updated";
        }
        else{
            $err=$connection->errorInfo();
            echo $err[2]."<br/>";
        }}
        
        
        
        if($lastNameEdited!=""){
            $ac1->setLastName($lastNameEdited);
            $result=$ac1->update($connection,"LN","LN","LN");
            if($result==true)
            {
                $_SESSION["LName"]=$lastNameEdited;
                echo  "The last Name has been updated";
            }
            else{
                $err=$connection->errorInfo();
                echo $err[2]."<br/>";
            }
        }
        if( $emailEdited!=""){
            $ac1->setEmail($emailEdited);
            $result=$ac1->update($connection,"E","M","A","IL");
            if($result==true)
            {
                $_SESSION["email"]=$emailEdited;
                echo  "The email has been updated";
            }
            else{
                $err=$connection->errorInfo();
                echo $err[2]."<br/>";
                
            }
           
        }  
        header("location:../userpage.php");
}


if (!empty($_GET['userConnID'])) {
    
    $userFollowed=$_GET['userConnID'];
    $currentUser=$_SESSION["userid"];
    $ac12 =new Account();
    $ac12->setUserID($currentUser);
    $ac12->createUserConnection($connection, $userFollowed);
    $resultconn=$ac12->getMyConnections($connection);
    $_SESSION["myconnections"]=$resultconn;
    $nbconections=count($resultconn);
    $ac12->update($connection,$nbconections,"3","4","5","6","7","8");
    
}

if (!empty($_GET['userConnidDelete'])) {
   
    $userFollowed=$_GET['userConnidDelete'];
    $currentUser=$_SESSION["userid"];
    $ac13 =new Account();
    $ac13->setUserID($currentUser);
    $ac13->deleteUserConnection($connection, $userFollowed);
    $resultconn=$ac13->getMyConnections($connection);
    $_SESSION["myconnections"]=$resultconn;
    $nbconections=count($resultconn);
    $ac13->update($connection,$nbconections,"3","4","5","6","7","8");
    header("location:../MyConnections.php");
}



if(isset($_GET['sendMessage'])){
    $message=$_GET['mymessge'];
    $userFolloedId=$_GET['userselect'];
    $currentUser=$_SESSION["userid"];
    $ac14 =new Account();
    $ac14->setUserID($currentUser);
    $ac14->update($connection,$userFolloedId,$message,"4","5","6","7");
   
    header("location:../MyConnections.php");
}

?>