<?php
include '../functions.php';
include '../home.html';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}/*
$logged=loggedin();
if (loggedin()) // if the user is logged in, it will skip this page 
{
echo"is logged in 1".$logged;
header ("Location:welcome2.php");
exit();
}*/
// $browserLanguage=getBrowserLanguage();
$browserLanguage='en';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$loginPhrase=getMsg($db, $browserLanguage, 'Login');
$namePhrase=getMsg($db, $browserLanguage, 'Name');
$passwordPhrase=getMsg($db, $browserLanguage, 'password');
$forgotPhrase=getMsg($db, $browserLanguage, 'Forgot Password');
$readPhrase=getMsg($db, $browserLanguage, 'read');
$termsPhrase=getMsg($db, $browserLanguage, 'terms');
$submitPhrase=getMsg($db, $browserLanguage, 'submit');
$remPhrase=getMsg($db, $browserLanguage, 'Remember');

?>

<?php
$cookie_name = "user";
$cookie_value = $_POST["fname"];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
$nameErr =$passErr = "";
$username =$_POST["fname"];
?>
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
 <link rel="stylesheet" type="text/css" href="main.css">
<title>
    Xmatch-Genetics login </title><br><br>
  <div class="header" id="header">
<header></header>

 </div>
 </div>
</head>
<body>
<!--form with 2 input text-->  
<div class="cow">
<div id="center1">
<img src="/assets/logo_login.jpg"alt="Smlogo" height="70" width="120" style="  padding-left: 40px;"></div>
<div id="center">
<form class='register-form' name="log"  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" >
<div class="divlogin">
    <h1> <?php echo $submitPhrase; ?></h1>
<ul>
    <!-- /*<?php echo $loginPhrase; ?>*/ password &nbsp;: -->
    <li>
        <span class=<?php echo $class ;?>><input type="text" name="fname" placeholder="<?php echo $namePhrase; ?>" required pattern="[A-Za-z0-9]{1,}"></span>
    </li>
    <br>
<li>
    <span class=<?php echo $class ;?>> <input type="password" name="fpass" required placeholder="<?php echo $passwordPhrase; ?>" ></span>
</li>
<a class="forget" id="forget"href="#"><?php echo $forgotPhrase; ?></a>

<!--
<li>
    <span class=<?php echo $class ;?>> <input type="text" name="farm"  placeholder="Farm" ></span>
</li>
-->

<br><br>
<li name="read" class="read2" >
    <input type="checkbox" required checked><label><?php echo $readPhrase; ?> <a class="check" id="check" href="conditions.php"><?php echo $termsPhrase; ?>.</a> </label>
</li>
<li>
<input type="checkbox"><label><?php echo $remPhrase; ?>.</label></li>
<li>
    <button class="submit" type="submit"><?php echo $submitPhrase; ?></button>
</li>
</ul>
</div>
</form>
<img src="/assets/cows.jpg"alt="" height="313" width="512" style=" ">
</div>
</div>
<!-- פרסומת בדף הבית-->
<div id="gif">
<object width="350" height="150" style="margin-top: 5%;">
    <param name="movie" value="/assets/banner1.swf">
</object>

</div>
<!--<img src="/assets/banner1.swf"alt="Smlogo" height="120" width="250" style="  vertical-align: bottom;">-->
</body>
</html>
<?php
$username =$_POST["fname"];
$password =$_POST["fpass"];
$remember = $_POST['remember'];
$cookie_name = "farm";
$cookie_value = $_POST["Farm"];
global $access;
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 

 if($_SERVER['REQUEST_METHOD']=='POST')
  {
    	$valid=validateFrm();
    	$t=tnc($db, $password);
    	$valid=validateLoginForm($db, $username, $password);
    	if($valid) {
		$userType = getUserType($db, $username);
		//for development can be access only for admin
		if($access == '' or ($access == 'Admin' and $userType == 'Admin')){
		if ($userType == 'ContryDist' or $userType == 'RegionalDist' or $userType == 'Admin'){
		  //echo 'validation passed. Redirecting...<br>';
		  header('location:farm_Select.php');
		}
		else { //all the other users
		  //echo 'validation passed. Redirecting...<br>';
			  header('location:menu.php');
		}
		}
	}   
		 		
	else 
	       //header('location:menuNotUpdate.php');
		echo ' User/password does not match <br>';
	
   }
 
function validateFrm()//Integrity testing function, if well send the following form
{
    //int pg_field_prtlen ( resource $result , mixed $_POST["fname"]);
   	echo 'Starting validation <br>';
	$val = true;
	echo "hello &nbsp;" . $_POST["fname"];
	$result = preg_match('/[a-zA-Z0-9]/', $_POST["fname"]);
	if($result==0) 
	{
		$nameErr="Login must only include letters, or numbers.";
		$val = false;
	}
	echo '<br>';
	echo "hello".$_POST["fpass"];
	$resultp = preg_match('/[a-zA-Z0-9]/', $_POST["fpass"]);
	if($resultp==0 )
	{
		echo $error.="Your password must only include letters or numbers.";
		$val = false;
	}
	return $val;
}
?>