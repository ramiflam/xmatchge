<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';

}
?>
<?php
$cookie_name = "users";
$cookie_value = $_POST["fname"];
setcookie($cookie_name, $cookie_value, time() + (30), "/");
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="main.css" />
 <br> <br> 
<title>
Xmatch-Genetics new_user </title>
<div class="register-form">
<h1>you forget your password </h1>
</head>
<form action="forgot.php" method="post">
  <span class="hebrew"> user name:<input type="text"placeholder="Enter login" name="fname"/></span><span class="error"></span><P/>
Enter you email ID: <input type="email" name="email">
<br><br>
  <span class="hebrew">
<input type="submit" name="submit" value="Send">
</div
</form>
</html>
<?php 
if(isset($_POST['submit']))
{
$email=$_POST["email"];
echo"your email is:".$email;
$qw=validatepass($db, $cookie_value,$email);
}
function validatepass($db, $cookie_value,$email)
{
	$query = "SELECT * FROM `users_details` WHERE User_Name='$cookie_value' and User_E_Mail='$email';" ;
	 $result = mysqli_query($db,$query);
		  If ($result->num_rows > 0)
	   {
	     echo '<br>user  exist';
	     $row = mysqli_fetch_assoc($result);
 	     $em=$row['User_E_Mail'];
            header('location:resetpass.php');
	   }
	   else
	   {
		echo '<br>user not exist';
		return false;
	   }
}
?>