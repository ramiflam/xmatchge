<?php
include "config.php";
session_start(); 

function getDbConnection()
{
   global $db_name;
   global $dbPass;
   $db = mysqli_connect('localhost','xmatchge', $dbPass, $db_name);
   mysqli_query($db, "SET NAMES 'utf8'");
   return $db;
}
function closeDbConnection($db)
{
	mysqli_close($db);
}
 
function getBrowserLanguage()
{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    return $lang;
}
// function to return the message for given type and language from messages table
function getMsg($db, $language, $type)
{
	$returnMsg = "";
	$query = "SELECT * FROM `alert` where type='$type' and lang='$language' ;";

        $result = mysqli_query($db, $query);
        If ($result)
        {
        	$row = mysqli_fetch_assoc($result);
 		$returnMsg = $row["message"];
        }
        return $returnMsg;
}
function getMsgTbl($db)
{
	$returnMsg = "";
	 $query="SELECT cow_no,burn_no,lact_no,group_name FROM `users_details`";
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result = mysqli_query($db, $query);
                $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;      
}

        return $result_list;
        }
        
        /******************************************************************
        $query="SELECT cow_no,burn_no,lact_no,group_name FROM `users_details`";
        $result = mysqli_query($db, $query);
        
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
         func($row["User_Name"],$row["User_Address"],$row["Password"]);
        
}
        printf ("%s %s %d",$row["User_Name"],$row["User_Address"],$row["Password"]);
         func($row["User_Name"],$row["User_Address"],$row["Password"]);

         function func($name,$row2,$row3)
         {
            echo "the username is ".$name."<br/>";
         }/
}
*/
function validateLoginForm($db, $username, $password)
{
	//echo"hi how are you :-)";
	$msg="name exist ";
	$sql="SELECT * FROM `users_details` WHERE user_Name='$username' and Password='$password';";
	$result = mysqli_query($db, $sql);
	
	 if($result->num_rows > 0)
	   {
	     // echo 'user  exist';
	  
	     $row = mysqli_fetch_assoc($result);
	     $cookie_value =  $row["User_type"];
	     $cookie_name = "usertype";
             setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
             echo "$cookie_value";
              return true;
	   }
	   else
	   {
		//echo 'user not exist';
		return false;
	   }
}
function getUserType ($db,$username ) 
{
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["User_type"];
 		
        }
        return $UserType;
}

function getUserFamily ($db,$username ) 
{
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserDetails = $row["User_First_Name"]." ".$row["User_Last_Name"];
        }
        return $UserDetails;
}
function getUserProgram ($db,$username,$farm ) 
{
        $query = "SELECT * FROM `user_settings` WHERE user_id='$username' and FarmName='$farm';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserDetails =$row["program_plan_no"];
        }
        return $UserDetails;
}

function getUserLocation ($db,$username ) 
{
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserDetails = $row["Farm_location"];
        }
        return $UserDetails;
}

function getUserEmail ($db,$username) 
{
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserDetails = $row["User_E_Mail"];
        }
        return $UserDetails;
}
//login chech function
function loggedin()
{
if ( isset($_SESSION['user']) )
{
$loggedin ="its make a session";
return $loggedin;
}

if (isset($_COOKIE['username']))
{
$loggedin ="its make a cookies";
return $loggedin;
}
else 
return false;
}

function tnc($db, $password)
{
	$query = "UPDATE users_details SET TNC_accepted='Y' WHERE TNC_accepted='N' and Password='$password';" ; 
        $result = mysqli_query($db, $query);
             If ($result){
        return TRUE;
}
else
return FALSE;
}

function getLangAllingment($db, $lang)
{
	$langAllignment=null;
        $query = "SELECT Allignment FROM `supported_languages` WHERE lang='$lang';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$langAllignment = $row["Allignment"];
        }
        return $langAllignment;
}
 
function getBreedType($db,$bull_no)
{   
$result="";
 $query="SELECT BreedCode_2_ch	FROM `table_breeds`,`bulls_details` AS BI
  where ISRcode = BI.breed and BI.bull_no =$bull_no";
  $result= mysqli_query($db, $query);
  while($row = $result->fetch_assoc())
 
  { $breedcode=$row['BreedCode_2_ch']; 
 /* $query="UPDATE `bulls_details` SET Breed= '$breedcode' WHERE bull_no='$bull_no'";
   $result= mysqli_query($db, $query);*/
  return $breedcode;
  }
}
function getBreedType2($db, $breed)
{   
$result="";
 $query="SELECT BreedCode_2_ch	FROM `table_breeds`
  where ISRcode = $breed";
  $result= mysqli_query($db, $query);
  while($row = $result->fetch_assoc())
 
  { $breedcode=$row['BreedCode_2_ch']; 
 /* $query="UPDATE `bulls_details` SET Breed= '$breedcode' WHERE bull_no='$bull_no'";
   $result= mysqli_query($db, $query);*/
  return $breedcode;
  }
}

  function getCowNum($db){ 
        $query = "UPDATE local_cows SET lact_no=2 WHERE cow_no=3";
        $result = mysqli_query($db, $query);
        if($result)
        {
        echo"is succeesdd";
        }
        return 23;
   } 
   function getUserFarm ($db,$username ) 
{
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserDetails = $row["Farm"];
        }
        return $UserDetails;
}
   function getUserId ($db,$username ) 
{
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserDetails = $row["User_Name"];
        }
        return $UserDetails;
}
function getUserNumber($db,$username )
{
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username';" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows > 0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserDetails = $row["User_No"];
        }
        return $UserDetails;
} 
   /*
 function getCowNum($db,$i,$lactno){
        $query="SELECT cow_no FROM `local_cows`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["cow_no"];
        $query = "UPDATE local_cows SET lact_no='$lactno' WHERE cow_no='$i';" 
   } 
   */



?> 