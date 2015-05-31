<?php

include 'functions.php';
include 'home.html';
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
//$browserLanguage=getBrowserLanguage();
$browserLanguage='HE';

$loginPhrase=getMsg($db, /*$browserLanguage*/'HE', 'Login');
$passwordPhrase=getMsg($db, $browserLanguage, 'password');
//echo $loginPhrase;
//echo $passwordPhrase;
// Login : <input type="text" name="fname"/>
?>
<?php
$cookie_name = "user";
$cookie_value = $_POST["fname"];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
$nameErr =$passErr = "";
$username =$_POST["fname"];
?>
<html>
<?php header('Content-Type: text/html; charset=utf-8');?>
<head>
 <meta http-equiv="Content-Type" content="text/html/php" charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="main.css" />
 <br> <br> 
<title>
Xmatch-Genetics login </title>

 
</head>
<body>
<div class="register-form">
<div class="login">
<h1> Log In</h1>

 <h2> Please login, you must be a registered to proceed.</h2>

<br>
<!--form with 2 input text-->

<form name="log"  method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ; ?>" >
<table style="width:75%" cellspacing="0"  cellpadding="0" class="table">
<tr>

  <td colspan="2"> <span class="hebrew"> User name:&nbsp;<input type="text"placeholder=<?php echo $loginPhrase ?> name="fname"/></span><span class="error">*<?php echo $_COOKIE['remember_me'];?></span><P/></td>
</tr>
<tr>
 <td> <span class="hebrew"> Password: &nbsp;&nbsp;<input type="password"  placeholder="Enter password" name="fpass" pattern=".{6,}" required title="6 characters minimum"/></span><span class="error">*</span></br></td>
 <td> <a href="forgot.php">Forgot password</a> </td>
 </tr>
 <tr><td colspan="2" ><br></td></tr>
  <tr>
      <td colspan="2" > <input type="checkbox" 
         name="co" required><label for="remember">I confirm that I have read <a href="conditions.php">the terms and conditions</a> and I accept.</label>
       
       </td>
 </tr>
      <td colspan="2"> <label for="remember"><input name="rememberMe" id="rememberMe" type="checkbox" value="1" />Remember me</label></td>
</tr>
<tr>
         <td colspan="2"> <input type="submit" value="Submit" name="submit"/></td>
</tr>
</table>

</div>
</div>
</form>
</body>
</html>
<?php
$username =$_POST["fname"];
$password =$_POST["fpass"];
$remember = $_POST['remember'];

 if($_SERVER['REQUEST_METHOD']=='POST')
  {
    	$valid=validateFrm();
    	$t=tnc($db, $password);
    	$valid=validateLoginForm($db, $username, $password);
    	if($valid) {
    	           
		  // echo 'validation passed. Redirecting...<br>';
		   header('location:welcome2.php');
	  
		 }   
		 		
	else 
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