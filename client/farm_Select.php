<?php
include '../functions.php';
include '../home.html';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';}
$username=$_COOKIE["user"];
?>
<html>
<body>
<head>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" type="text/css" href="farms.css" />
 <br> <br> 
<title>
Xmatch-Genetics new_user </title>
<div>
<!--<h1>select_a_farm please</h1>-->
<div class="farms-title">CHOOSE FARM</div>

<form method="post" action="">

<!--<p><label>select_a_farm&nbsp;&nbsp;&nbsp; : </label>-->
<div class="farms-container">
    
<?php
//$query = "SELECT * FROM `users_details`"; 
$type = getUserType($db,$username);
if($type!='Admin'){
$query = "SELECT * FROM `farms_to_users` WHERE user_name='$username'";
$result = mysqli_query($db, $query);
} else {
$query = "SELECT DISTINCT(farm_name) FROM `farms_to_users` ";
$result = mysqli_query($db, $query);
}
?>
<!--<select required name="select_a_farm"><option selected disabled value=" "> select_a_farm:</option>-->
<a href="menu.php"  style="text-decoration:none;" id="creatHref"></a>
<?php
while($fetch_options = mysqli_fetch_array($result)) { //Loop all the options retrieved from the query
?>
 <!--Added Id for Options Element -->
 <div class="single-farm"><?php echo $fetch_options['farm_name']; ?></div>
<!--<option value ="<?php echo $fetch_options['farm_name']; ?>"><?php echo $fetch_options['farm_name']; ?></option>--><!--Echo out options-->
<?php } ?>
<!-- </select> -->
</div>
  <?php
  //$selectFarm = $_POST['select_a_farm'];
  ?>
 <!--<br><br> <input type="submit" value="Submit" name="submit" />-->
  <?php
  //if(isset($_POST['select_a_farm'])){checck();}
  function checck(){
  $selectFarm = $_POST['select_a_farm'];
  if(!$selectFarm){
  echo nl2br("\n \n you are not select a farm");}
  else
  {
  header("location:menu.php");
  }
}
  ?>
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(".single-farm").click( function(){
//alert($(this).text());
var data = {
    	func : 'setUserFarm',
    	farm: $(this).text()
    	};
    //var data = {"action":"test"};
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax.php", //Relative or absolute path to response.php file
      data: data,
      success: function(data) {
      window.location.href = "menu.php";
      	//$("#creatHref").click();//alert(data);
      }
	});
});
</script>
</body>
</html>