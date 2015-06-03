<?php
 include "navigationBar.php";
 include "alert.php";

 $db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$browserLanguage='en';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$username = $_COOKIE["user"];
//$userfarm=setUserFarm ('yeruham');
if(isset($_COOKIE["farm"])){
$userfarm=$_COOKIE["farm"];

} else {
$userfarm=getUserFarm ($db, $username);
}
$updatecowPhrase=getMsg($db, $browserLanguage, 'updateC');
$updatePhrase=getMsg($db, $browserLanguage, 'updateCows');
$createPhrase=getMsg($db, $browserLanguage, 'Create Future Insemination List');
$preferedPhrase=getMsg($db, $browserLanguage, 'Prefered Characteristics');
$notesParameters=getMsg($db, $browserLanguage, 'notesParameters');

?>
<!DOCTYPE html>
<html >

<head>
   <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
  <link rel="stylesheet" type="text/css" href="cows.css" />
</head>
<body >
<div class="content">
<form  name="myform" method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" onsubmit="showAll()">
    <ul>
        <a href="cows1.php"><li><?php echo $updatecowPhrase;?></li> </a>
    </ul>
      <ul>
         <a href="cows2.php"><li id="createinsem"><?php echo $createPhrase;?></li></a>
    </ul>
      <ul>
       <a href="cows3.php"> <li id="preferedPhrase" style="color:red;"><?php echo $notesParameters;?></li></a>
    </ul>
</div>

<div class="sidebar" id="sidebar">
<h1><?php echo $notesParameters;?></h1>