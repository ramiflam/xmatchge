<?php
include 'functions.php';

$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
?>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="main.css" />
 <br> <br> 
<title>
Xmatch-Genetics new_user </title>
<div class="register-form">
<h1>reset your password </h1>
</head>
<form method=post>
 <p><label>Password&nbsp;&nbsp; : </label>
	 <input id="password" type="password" name="password" 
	 placeholder="password" pattern="[A-Za-z0-9]{6,}" required title="6 characters minimum"  /></p>
	 
	 <p><label>Confirm your password &nbsp; : </label>
	 <input id="confirmpass" type="password" name="confirmpass" 
	 placeholder="password" pattern="[A-Za-z0-9]{6,}" required title="6 characters minimum"  /></p>
	
<input type="submit" value="Submit" name="submit"/>
</div
</form>
</html>
<?php
$username=$_COOKIE['users'];
//echo "the username is:".$username;
if(isset($_POST['submit']))
{
$password = $_POST['password'];
$ConfirmPass = $_POST['confirmpass'];
if($password==$ConfirmPass){
      $query="UPDATE users_details SET Password='$password' WHERE User_Name='$username';";
        $result = mysqli_query($db, $query);
    if($result)
		   {
		     echo '<br> Your password changed sucessfully';
		      //ret();
		     // return true;
		   }
		 
		   else
		   {
			echo '<br> Invalid password please try again .';
			// return false;
		   }
}
     function ret()
     {
       header('location:welcome.php');
     }  
     }
     else 
     {
     echo"These passwords do not match. Maybe you try again?";
     } 
?>