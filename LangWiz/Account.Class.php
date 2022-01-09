<?php 

class Account{
    
    private $userID;
    private $userName;
    private $firstName;
    private $lastName;
    private $photo;
    private $country;
    private $city;
    private $email;
    private $password;
    private $language;
    private $locId;
    private $langId;
    private $message;
    


    function __construct($userName=null, $firstName=null, $lastName=null,$photo=null,$country=null,$city=null,$email=null,$password=null, $language=null) {
        
       
        $this->userName=$userName;
        $this->firstName=$firstName;
        $this->lastName=$lastName;
        $this->photo=$photo;
        $this->country=$country;
        $this->city=$city;
        $this->email=$email;
        $this->password=$password;
        $this->language=$language;
       
    }

    public function getUserID() {return $this->userID;}
    public function setUserID($userID){$this->userID = $userID;}
    public function getCountry(){return $this->country;}
    public function getCity(){return $this->city;}
    public function setCountry($country){$this->country = $country;}
    public function setCity($city){$this->city = $city;}
    public function getUserName(){return $this->userName;}
    public function getFirstName(){return $this->firstName;}
    public function getLastName(){ return $this->lastName;}
    public function getPhoto(){return $this->photo;}
    public function getEmail(){return $this->email;}
    public function getPassword(){return $this->password;}
    public function getLanguage(){return $this->language;}
    public function setUserName($userName){$this->userName = $userName;}
    public function setFirstName($firstName){$this->firstName = $firstName;}
    public function setLastName($lastName){$this->lastName = $lastName;}
    public function setPhoto($photo){$this->photo = $photo;}
    public function setEmail($email){$this->email = $email;}
    public function setPassword($password){$this->password = $password;}
    public function setLanguage($language){$this->language = $language;}
    public function getMessage(){ return $this->message;}
    public function setMessage($message){ $this->message = $message;}


    public function searchUserId($connection){
        $sqlStmt="Select `UserID` from `users` where `Username`=:username";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':username', $this->getUserName(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        return $result[0]['UserID'];
        
    }
    
    public function searchLocationId($connection){
        $sqlStmt="Select `LocationID` from `location` where `City`=:city";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':city', $this->getCity(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        $locationID=($result[0]['LocationID']);
        return $locationID;
    }
    public function searchLanguagebyID($connection){
        $sqlStmt="SELECT `LangID` FROM `languages` WHERE `LangName`=:lang";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':lang', $this->getLanguage(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        $languageID=($result[0]['LangID']);
        return $languageID;
        
    }
    public function searchUserIdByName($connection){
        $sqlStmt="Select `UserID` from `users` where `Username`=:username";
         $prepareQuery= $connection ->prepare($sqlStmt);
         $prepareQuery->bindValue(':username', $this->getUserName(),PDO::PARAM_STR);
         $prepareQuery->execute();
         $result=$prepareQuery->fetchAll();
         
         $userID=($result[0]['UserID']);
         return $userID;
        
    }
    public function createAccount($connection) {
      
        $locationID=$this->searchLocationId($connection);
        $languageID=$this->searchLanguagebyID($connection);
      
       $userName=$this->userName;
       $firstName=$this->firstName;
       $lastName=$this->lastName;
       $photo=$this->photo;
       $email=$this->email;
       $password=$this->password;
       
        //Inserting Data into users
        $sqlStmt="INSERT INTO `users`(`Username`, `FName`,`LName`, `Photo`, `LocationID`, `EmailAddress`) 
        VALUES ('$userName','$firstName','$lastName','$photo',$locationID,'$email')";
        $result=$connection->exec($sqlStmt);
        //Searching the asigned user Id
       
        $userID=$this->searchUserIdByName($connection);
        //Inserting Data into accounts 
        $sqlStmt="INSERT INTO `accounts`(`UserID`, `Password`) VALUES ($userID,'$password')";
        $result1=$connection->exec($sqlStmt);
        //Inserting Data into languagespeak 
        $sqlStmt="INSERT INTO `languagespeak` (`LangID`, `UserID`) VALUES ($languageID,$userID)";
        $result2=$connection->exec($sqlStmt);
        $rewardId=100;
        $sqlStmt="INSERT INTO `rewardtable`(`BadgeID`, `UserID`) VALUES ($rewardId,$userID)";
        $result3=$connection->exec($sqlStmt);
        
        return $result;
        
    }
    
    public function Login($connection){
        $userName=$this->userName;
        $password=$this->password;
        
        $sqlStmt="Select `UserID` from `users` where `Username`=:username";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':username', $this->getUserName(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        $userId= ($result[0]['UserID']);
        
      
        
        $sqlStmt="SELECT `Password` FROM `accounts` WHERE `UserID`=:userId";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':userId',$userId,PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        $passSaved=($result[0]['Password']);
        
        if( $password==$passSaved){
            return true;
        }
        else return false;
    }
      
    public function searchUserInformation($connection){
        $userName=$this->userName;
        $sqlStmt="SELECT u.`Username`,u.`UserID`,u.`FName`,u.`LName`,u.`Photo`,u.`EmailAddress`,u.`personalMsg`,l.LangName,lo.Country,lo.City, b.BadgeID,b.BadgeDesc 
        FROM users u
        LEFT JOIN location lo ON lo.LocationID = u.LocationID
        LEFT JOIN rewardtable r ON u.UserID=r.UserID
        LEFT JOIN languagespeak lgsp ON lgsp.UserID=u.UserID
        LEFT JOIN languages l ON lgsp.LangID=l.LangID
        LEFT JOIN badges b ON r.BadgeID=b.BadgeID 
        WHERE u.Username=:username";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':username', $this->getUserName(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
       
           return $result;
  
    }
    
    ///UPDATE
    function __call($method,$arg) {
        if ($method="update")
        {
            $userID=$this->userID;
           
            switch (count($arg)){
                case 1:
                    $userName=$this->userName;
                    $connection=$arg[0];
                    $sqlStmt="Update `users` set UserName='$userName' where UserID=$userID";
                    break;
                case 2:
                    $firstName=$this->firstName;
                    $connection=$arg[0];
                    $sqlStmt="Update `users` set FName='$firstName' where UserID=$userID";
                    break;
                
                case 3:
                    $photo=$this->photo;
                    $connection=$arg[0];
                    $sqlStmt="Update `users` set Photo='$photo' where UserID=$userID";
                    break;
                case 4:
                    $lastName=$this->lastName;
                    $connection=$arg[0];
                    $sqlStmt="Update `users` set LName='$lastName' where UserID=$userID";
                    break;
                case 5:
                    $email=$this->email;
                    $connection=$arg[0];
                    $sqlStmt="Update `users` set EmailAddress='$email' where UserID=$userID";
                    break;
                case 6:
                    $messg=$this->message;
                    $connection=$arg[0];
                    $sqlStmt="Update `users` set personalMsg='$messg' where UserID=$userID";
                    break;
                case 7:
                    $connection=$arg[0];
                    $userFolloedId=$arg[1];
                    $messg=$arg[2];
                    $sqlStmt=" UPDATE `connections` SET `conenctionMessage`='$messg' WHERE `UserFollowID`=$userID && `UserFollowedID`=$userFolloedId";
                    break;
                case 8:
                    $connection=$arg[0];
                    $nbConnections=$arg[1];
                    if($nbConnections>=0 && $nbConnections<=20){
                        $rewardId=100;
                    }
                    elseif ($nbConnections>20 && $nbConnections<=40)
                    {
                        $rewardId=200;
                    }
                    elseif ($nbConnections>40 && $nbConnections<=70)
                    {
                        $rewardId=300;
                    }
                    elseif ($nbConnections>70 && $nbConnections<=100)
                    {
                        $rewardId=400;
                    }
                    else{
                        $rewardId=500;
                    }
                    
                   
                    $sqlStmt=" UPDATE `rewardtable` SET `BadgeID`=$rewardId WHERE `UserID`=$userID";
                   
                    break;
            }
            $result = $connection->exec($sqlStmt);
            return $result;
        }
    }
   //SEARCH USERS
    public function searchUserSbyLanguage($connection){
                
        $sqlStmt="SELECT u.`Username`,u.`UserID`,u.`FName`,u.`LName`,u.`Photo`,u.`EmailAddress`,u.`personalMsg`,l.LangName,lo.Country,lo.City
        FROM users u
        LEFT JOIN location lo ON lo.LocationID = u.LocationID
        LEFT JOIN languagespeak lgsp ON lgsp.UserID=u.UserID
        LEFT JOIN languages l ON lgsp.LangID=l.LangID
        WHERE l.LangName=:language";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':language',$this->getLanguage(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        
        return $result;
        
    }

    // SEARCH USERS BY DISTANCE
    public function searchUsersByDistance($connection, $distance,$limitDisplay){
        $EARTH_APROX_RADIUS = 6371;
        
        $sqlStmt="SELECT g.GeoLat, g.GeoLong from geolocalization g
                    JOIN location l on l.GeopositioningID = g.GeopositioningID
                    WHERE City = :city";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':city', $this->getCity(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
       foreach($result as $data)
        {        
            $lat = $data["GeoLat"];
            $long = $data["GeoLong"];
       }
        $sqlStmt="SELECT u.`Username`,u.`UserID`,u.FName, u.LName,u.Photo,u.EmailAddress,u.personalMsg, la.LangName, l.City, l.Country,
                ($EARTH_APROX_RADIUS * acos(
                 cos( radians(:lat) )
                 * cos( radians( g.GeoLat ) )
                 * cos( radians( g.GeoLong ) - radians(:long) )
                 + sin( radians(:lat) )
                 * sin( radians( g.GeoLat ) )
                 )) AS Distance
                FROM geolocalization g
                JOIN location l ON g.GeopositioningID = l.GeopositioningID
                JOIN users u on u.LocationID=l.LocationID
                LEFT JOIN languagespeak ls on ls.UserID = u.UserID
                LEFT JOIN languages la on la.LangID = ls.LangID
                HAVING Distance < :distance
                ORDER BY Distance ASC
                LIMIT :limitToDisplay;";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':distance', $distance,PDO::PARAM_STR);
        $prepareQuery->bindValue(':limitToDisplay', $limitDisplay,PDO::PARAM_INT);
        $prepareQuery->bindValue(':lat', $lat,PDO::PARAM_STR);
        $prepareQuery->bindValue(':long', $long,PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
      //var_dump($result);
        return $result;
  
    }
     
   /* THIS FUNCTION IS NOT LONGER NEED IT  
    public function getLatAndLong($connection){
         $sqlStmt="SELECT g.GeoLat, g.GeoLong from geolocalization g 
                    JOIN location l on l.GeopositioningID = g.GeopositioningID 
                    WHERE City = :city";
         $prepareQuery= $connection ->prepare($sqlStmt);
         $prepareQuery->bindValue(':city', $this->getCity(),PDO::PARAM_STR);
         $prepareQuery->execute();
         $result=$prepareQuery->fetchAll();
         if($result)
         {            
            $arCoords["Lat"]=$rec["GeoLat"];
            $arCoords["Long"]=$rec["GeoLong"];
            return $arCities;
         }   
         
         return $result;
     }*/
    
    //FIND NEAREST CITIES (returns an array of city and country)
    public function searchUserSbyLocation($connection,$distanceKM, $limitDisplay){
        include($_SERVER['DOCUMENT_ROOT'].'/phpFiles/geolocalization.php');
        //get lat and long
        $sqlStmt = "SELECT g.GeoLat, g.GeoLong 
                    FROM users u 
                    JOIN location l ON l.LocationID = u.LocationID 
                    JOIN geolocalization g ON g.GeopositioningID=l.GeopositioningID 
                    WHERE country = ':country' AND City = ':city';";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':country', $this->getCountry(),PDO::PARAM_STR);
        $prepareQuery->bindValue(':city', $this->getCity(),PDO::PARAM_STR);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll(); 
        $lat = $result[0]["GeoLat"];
        $long = $result[0]["GeoLong"];
        return getNearPlaces($distanceKM, $limitDisplay, $lat, $long);
    } 
    
    public function createUserConnection($connection, $userFollowed){
        $currentUser=$this->userID;
        $sqlStmt = "INSERT INTO `connections`(`UserFollowID`, `UserFollowedID`) VALUES ($currentUser,$userFollowed)";
        $connection->exec($sqlStmt);
    }
    
    public function getMyConnections($connection){
        
        $sqlStmt="SELECT u.`Username`,u.`UserID`,u.`FName`,u.`LName`,u.`Photo`,u.`EmailAddress`,u.`personalMsg`,l.LangName,lo.Country,lo.City, b.BadgeDesc
        FROM connections c
        LEFT JOIN users u on u.UserID=c.UserFollowedID
        LEFT JOIN location lo ON lo.LocationID = u.LocationID
        LEFT JOIN rewardtable r ON u.UserID=r.UserID
        LEFT JOIN languagespeak lgsp ON lgsp.UserID=u.UserID
        LEFT JOIN languages l ON lgsp.LangID=l.LangID
        LEFT JOIN badges b ON r.BadgeID=b.BadgeID
        WHERE c.UserFollowID=:userID";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':userID',$this->getUserID(),PDO::PARAM_INT);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        
        return $result;
        
    }
   
    public function getMyMessages($connection){
        
        $sqlStmt="SELECT u.`Username`,u.`FName`,u.`LName`,u.`Photo`,u.`EmailAddress`,l.LangName,lo.Country,lo.City,c.`conenctionMessage`,b.BadgeDesc
        FROM connections c
        LEFT JOIN users u on u.UserID=c.UserFollowID
        LEFT JOIN location lo ON lo.LocationID = u.LocationID
        LEFT JOIN rewardtable r ON u.UserID=r.UserID
        LEFT JOIN languagespeak lgsp ON lgsp.UserID=u.UserID
        LEFT JOIN languages l ON lgsp.LangID=l.LangID
        LEFT JOIN badges b ON r.BadgeID=b.BadgeID
        WHERE c.UserFollowedID=:userID and c.`conenctionMessage`<>'null'";
        $prepareQuery= $connection ->prepare($sqlStmt);
        $prepareQuery->bindValue(':userID',$this->getUserID(),PDO::PARAM_INT);
        $prepareQuery->execute();
        $result=$prepareQuery->fetchAll();
        
        return $result;
        
    }

    public function deleteUserConnection($connection, $userFollowed){
        $currentUser=$this->userID;
        $sqlStmt = "DELETE FROM `connections` WHERE `connections`.`UserFollowID` = $currentUser AND `connections`.`UserFollowedID` = $userFollowed";
        $connection->exec($sqlStmt);
    }
 
    
}
?>