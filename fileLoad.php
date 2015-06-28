<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}	    
	$sql="SELECT farm_name FROM  `farms`";
	$result = mysqli_query($db, $sql);
	    	 
?>
<!DOCTYPE html>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<div class="register-form">
<form action="upload.php" method="post" enctype="multipart/form-data">
<h1> Select farm: </h1><br/><br/>
<select name="farmName" style="width: 173px;">
                    <?php while($fetch_options = mysqli_fetch_array($result)) { ?> //Loop all the options retrieved from the query
 <!--Added Id for Options Element -->
<option value ="<?php echo $fetch_options['farm_name']; ?>"><?php echo $fetch_options['farm_name']; ?></option><!--Echo out options-->
</selcet><?php } ?><br/>
   <h1> Select file to upload: </h1><br/><br/>
    <input type="file" name="fileToUpload"  id="fileToUpload"  accept=".csv,.xls,.txt" pattern=".{6,}"> 
    <input type="submit" value="Upload file" name="submit"><br/><br/>
   </div>
</form>
</body>
</html>