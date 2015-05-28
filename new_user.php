<?php
include 'functions.php';
include 'home.html';

$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$username=$_COOKIE["user"];
/* $userType=getUserType ($db,$username);*/
$valid=getUserType($db, $username);
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="main.css" />
 <br> <br> 
<title>
Xmatch-Genetics new_user </title>
<div class="register-form">
<h1>New User</h1>
<form align="left" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ; ?>" method="POST">
   <table style="width:70%">
<tr>
    <td><p><label>User Name: </label></td>
	<td><input id="username" type="text" name="username" placeholder="username"pattern="[A-Za-z0-9]{1,}"required title="must only include letters, or number."/> 
 </p></td>  
</tr>
	
<tr>	<td><p><label>E-Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </label></td>
	 <td><input id="email" type="email" name="email"/></p></td>
</tr>
<tr>
     <td><p><label>Password&nbsp;&nbsp; : </label></td>
	<td> <input id="password" type="password" name="password" placeholder="password" pattern="[A-Za-z0-9]{6,}" required title="6 characters minimum"/></p></td>
</tr>
	 <tr><td> <p><label>Address&nbsp;&nbsp; : </label></td>
	<td><input id="address" type="text" name="address"pattern="[A-Za-z0-9]{1,}"required title="must only include letters, or number."/> </td>
	  </p>
</tr>
	
 
<tr>  <td><p><label>Farm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  : </label></td>
 <td><input id="farm" type="text" name="farm" pattern="[A-Za-z0-9]{1,}"required title="must only include letters"/></p></td>
 </tr>
 <tr>
	 <p><td><label>Country &nbsp;&nbsp;&nbsp; : </label></td>
	<td> <select name="country">
  <option value="Israel">Israel:</option>
  <option value="France">France</option>
  <option value="Norway">Norway</option>
  <option value="United States">United States</option>
  <option value="Spain">Spain</option>
  </select></td>
</tr>
  <div> 
  <tr>
  <td> <p><label>Select user type &nbsp; : </label> </td>
  <?php switch ($valid)  { 
   case "Admin":?> 
<td><select name="userstype">
  <option value="">Select user type :</option>
  <option value="ContryDist">ContryDist</option>
  <option value="RegionalDist">RegionalDist</option>
  <option value="FarmManager">FarmManager</option>
  <option value="Enduser">Enduser</option>
  <option value="Distributor">Distributor</option>
  </select>
  <?php  break;?>
  <?php  case "ContryDist":?>
  <select name="userstype">
  <option value="">Select user type:</option>
   <option value="RegionalDist">RegionalDist</option>
  <option value="FarmManager">FarmManager</option>
  <option value="Enduser">Enduser</option>
  </select> 
  <?php break;?>
    <?php case "RegionalDist": ?>
  <select name="userstype">
  <option value="">Select user type:</option>
  <option value="FarmManager">FarmManager</option>
  <option value="Enduser">Enduser</option>
  </select> 
  <?php break;?>
      <?php case "FarmManager": ?>
  <select name="userstype">
  <option value="">Select a type user:</option>
  <option value="Enduser">Enduser</option>
  </select> 
  <?php break;?>
        <?php case "Enduser": ?>
  <select name="userstype">
  <option value="">Select user type:</option>
  </select> 
  <?php break;}?><td></tr>
  <br><br>
  </div>
  <br><br>
  <tr>
 <td><input class="btn" type="submit" name="submit" value="Submit" /></td>
 </tr>
  <td> <a href="welcome.php">login</a> </td>
    </form>
</div>
<?php
if(isset($_POST['submit'])){
 $selectOption = $_POST["userstype"]; 
 $selectContry = $_POST["contry"];
echo " ".$selectOption; 
}
	//require('connect.php');
    // If the values are posted, insert them into the database.
    if (isset($_POST['username']) && isset($_POST['email'])&& isset($_POST['password'])&& isset($_POST['address'])
    && isset($_POST['farm'])&& isset($_POST['submit'])){
        $username = $_POST['username'];
	$email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
	//$date_joined = $_POST['date_joined'];
        $farm = $_POST['farm'];
        $selectOption = $_POST['userstype']; 
        //if user exist 
        $query = "SELECT * FROM `users_details` WHERE user_Name='$username' and Password='$password' and Farm=$farm;" ;     
        $result = mysqli_query($db, $query);
        If ($result->num_rows != 0)
        {
        	echo "Username already exists";
 		
        }
    else
    {    
        $query = "INSERT INTO `users_details` (User_Name, Password, User_E_Mail, User_Address, Date_joined, Farm, Country, User_type)
                   VALUES ('$username', '$password', '$email', ' $address', NOW(), '$farm', '$selectContry','$selectOption')";
                  
        $result = mysqli_query($db, $query);
        
         if($result)
		   {
		     echo '<br> User Created Successfully:-)';  
		       $dirname = "users/".$username."_".date('d-m-Y h-i-s');//Create a new folder for each new user 
                       mkdir($dirname);
                        // insert folder name into user details table
	    	$sql="UPDATE `users_details` SET Folder_name='$dirname'WHERE User_Name='$username'";
	    	 
		$result = mysqli_query($db, $sql);
		// insert user to user_settings table
		$sql="INSERT INTO `user_settings` (user_id, FarmName,program_plan_no)
                   VALUES ('$username', '$farm',1)";
                   //echo $sql;
	    	 $result = mysqli_query($db, $sql);
		     // return true;
		   }
		   else
		   {
			echo '<br> sorry you have a problem:-( .';
			// return false;
		   }
	}
    }
 ?>
    
		