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
// $browserLanguage=getBrowserLanguage();
$browserLanguage='he';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}

$loginPhrase=getMsg($db, $browserLanguage, 'Login');
$passwordPhrase=getMsg($db, $browserLanguage, 'password');
?>

<?php
$cookie_name = "user";
$cookie_value = $_POST["fname"];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
$nameErr =$passErr = "";
$username =$_POST["fname"];
?>
<html>

</<head>
 <meta http-equiv="Content-Type" content="text/html/php" charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="main.css" />
 <br> <br> 
<title>
Xmatch-Genetics login </title>
<div class="register-form">

 <h1> please login, you must be a registered to proceed.</h1>
</head>
<body>
<pre>
<!--form with 2 input text-->

<form name="log"  method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ; ?>" >
<table style="width:100%">
<tr>
<!-- /*<?php echo $loginPhrase; ?>*/ password &nbsp;: -->
  <td> <span class=<?php echo $class ;?>> <input type="text" placeholder="<?php echo $loginPhrase; ?>" name="fname"/></span><span class="error">*<?php echo $_COOKIE['remember_me'];?></span><P/></td>
</tr>
<tr>
 <td> <span class=<?php echo $class ;?>> <input type="password"  placeholder="<?php echo $passwordPhrase; ?>" name="fpass" pattern=".{6,}" required title="6 characters minimum"/></span><span class="error">*</span></br></td>
 </tr>
  <tr>
      <td> <input type="checkbox" 
         name="co" required><label for="remember">I confirm that I have read <a href="conditions.php">the terms and conditions </a> and I accept:</label>
       <td> <a href="forgot.php">forgot password</a> </td>
       <br></td>
 </tr>
      <td> <label for="remember"><input name="rememberMe" id="rememberMe" type="checkbox" value="1" /> &nbsp;Remember me</label></td>
</tr>
<tr>
         <td> <input type="submit" value="Submit" name="submit"/></td>
        
</tr>
</table>
</pre>
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