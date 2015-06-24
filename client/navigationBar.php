<?php
include '../functions.php';
include '../home.html';

$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$browserLanguage='en';
$username=$_COOKIE["user"];
if(isset($_COOKIE["farm"])){
$userfarm=$_COOKIE["farm"];
} else {
$userfarm=getUserFarm ($db, $username);
}
$set1_select1=getMsg($db, $browserLanguage, 'set1_select1');
$set1_select2=getMsg($db, $browserLanguage, 'set1_select2');
$set1_select3=getMsg($db, $browserLanguage, 'set1_select3');
$set1_select4=getMsg($db, $browserLanguage, 'set1_select4');
$set1_select5=getMsg($db, $browserLanguage, 'set1_select5');
$set1_select6=getMsg($db, $browserLanguage, 'set1_select6');
$set1_select7=getMsg($db, $browserLanguage, 'set1_select7');
$set1_select8=getMsg($db, $browserLanguage, 'set1_select8');
$details=  getUserFamily($db, $username);
$program= getUserProgram ($db, $username,$userfarm);
if($program==1)
{$program=$set1_select1;}
 else if($program==2){$program=$set1_select2;} else if($program==3) {$program=$set1_select3;}
 else if($program==4) {$program=$set1_select4;}  else if($program==5) {$program=$set1_select5;}
 else if($program==6) {$program=$set1_select6;} else if($program==7) {$program=$set1_select7;}
 else if($program==8) {$program=$set1_select8;};
$dailyPhrase=getMsg($db, $browserLanguage, 'daily activity');
$cowsPhrase=getMsg($db, $browserLanguage, 'cows');
$bullsPhrase=getMsg($db, $browserLanguage, 'bulls');
$settingsPhrase=getMsg($db, $browserLanguage, 'settings');
$updatePhrase=getMsg($db, $browserLanguage, 'system updated');
$lastupdatePhrase=getMsg($db, $browserLanguage, 'last update');
$daysPhrase=getMsg($db, $browserLanguage, 'days ago');
?>
<!DOCTYPE html>
<html>
   <body>
<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="navigationBar.css" />
<title>
Xmatch-Genetics new_user </title>

 
  <div class="header" id="header">
    <a href="menu.php">
       <img src="/assets/logo2.jpg" style="padding-left:20px;"></a>
         <div class="menu" id="menu">
<a href="dailyActivity.php" id="Dailyactivity"><?php echo $dailyPhrase ;?></a>

<a href="cows1.php" id="Cows"><?php echo $cowsPhrase ;?></a>

<a href="bulls.php" id="Bulls"><?php echo $bullsPhrase ;?></a>

<a href="settings1.php" id="Settings"><?php echo $settingsPhrase ;?></a>

<a href="farm_Select.php" id="Farms"><?php echo 'CHANGE FARM';?></a>
</div>

       <div class="sucess">
      
  <p id="sucess"><?php echo $updatePhrase;?></p>
       <p id="update"><?php echo $lastupdatePhrase;?> 7 <?php echo $daysPhrase;?></p>
     </div>  
  </div>
</head>
<div class="details">
   <label>
        <label style="color:red";> <?php echo ''.$details."".$userfarm;  ?></label>
          <label> <?php echo ''."|"." Active Program:" ?></label> 
         <label style="color:red;   padding-right: 13px;";> <?php echo $program;?> </label>
         <!--     <label> <?php echo ' '.$details."".$userfarm; 
         echo ''."|"." Active Program:".$program;?> </label>-->
         
   </label></div>
</body>
<div class="right"></div>
<div class="underdetails"></div>
</html>