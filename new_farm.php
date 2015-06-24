<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}

if(isset($_POST['submit'])){
//echo $_POST['username']." ".$_POST['farm'];

$sql="INSERT INTO `farms` (farm_name) VALUES ('".$_POST['farm']."')";
                   //echo $sql;
	    	 $result = mysqli_query($db, $sql);
	    	 	    	 }
		     
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
                    <td><p><label>Farm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  : </label></td>
                    <td><input id="farm" type="text" name="farm" /></p></td>
                </tr>
                <td><input class="btn" type="submit" name="submit" value="Submit" /></td>
            </table>
        </form>
    </div>
</body>
</html>