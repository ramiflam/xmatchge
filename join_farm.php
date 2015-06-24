<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}

if(isset($_POST['submit'])){
//echo $_POST['username']." ".$_POST['farm'];

$sql="INSERT INTO `user_settings` (user_id, FarmName,program_plan_no) VALUES ('".$_POST['username']."', '".$_POST['farm']."',1)";
                   //echo $sql;
	    	 $result = mysqli_query($db, $sql);
	    	 	    	 
	    	 //insert farm to farms_to_users table
	    	 $sql="INSERT INTO `farms_to_users` (farm_name, user_name)
                   VALUES ('".$_POST['farm']."','".$_POST['username']."')";
                   //echo $sql;
	    	 $result = mysqli_query($db, $sql);
		     // return true;
		     }
		    
		     $sql="SELECT farm_name FROM  `farms`";
	    	 $result = mysqli_query($db, $sql);
	    	 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="main.css" />
    </head>
    <body>
    <br>
    <br>
    <title>
Xmatch-Genetics new farm </title>
    <div class="register-form">
        <h1>New Farm</h1>
        <form align="left" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ; ?>" method="POST">
            <table style="width:70%">
                <tr>
                    <td><p><label>User Name: </label></td>
                    <td><input id="username" type="text" name="username" placeholder="username" pattern="[A-Za-z0-9]{1,}" required title="must only include letters, or number." />
 </p></td>

                <tr>
                    <td><p><label>Farm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  : </label></td>
                    <td><select name="farm" style="width: 173px;">
                    <?php while($fetch_options = mysqli_fetch_array($result)) { ?> //Loop all the options retrieved from the query
 <!--Added Id for Options Element -->
<option value ="<?php echo $fetch_options['farm_name']; ?>"><?php echo $fetch_options['farm_name']; ?></option><!--Echo out options-->
</selcet>
<?php } ?></p></td>
                </tr>
                <td><input class="btn" type="submit" name="submit" value="Submit" /></td>
            </table>
        </form>
    </div>
</body>
</html>