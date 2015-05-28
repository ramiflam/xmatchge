<?php
include '../functions.php';
include '../home.html';

$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$browserLanguage='he';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$username=$_COOKIE["user"];
$userfarm=$_COOKIE["farm"];
$set1_select1=getMsg($db, $browserLanguage, 'set1_select1');
$set1_select2=getMsg($db, $browserLanguage, 'set1_select2');
$set1_select3=getMsg($db, $browserLanguage, 'set1_select3');
$details=  getUserFamily($db, $username);
$program= getUserProgram ($db, $username);
if($program==1)
{$program=$set1_select1;}
 else if($program==2){$program=$set1_select2;} else if($program==3) {$program=$set1_select3;};
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
    <a href="menu.php"  style="float: left;">
       <img src="/assets/logo.jpg"  style="padding-left:20px;"></a>
         <div class="menu" id="menu">
<a href="dailyActivity.php" id="Dailyactivity"><?php echo $dailyPhrase ;?></a>

<a href="cows1.php" id="Cows"><?php echo $cowsPhrase ;?></a>

<a href="bulls.php" id="Bulls"><?php echo $bullsPhrase ;?></a>

<a href="settings1.php" id="Settings"><?php echo $settingsPhrase ;?></a>
</div>

       <div class="sucess">
      
  <p><?php echo $updatePhrase;?></p>
       <p id="update"><?php echo $lastupdatePhrase;?> 7 <?php echo $daysPhrase;?></p>
     </div>  
  </div>
</head>
<div class="details" dir="rtl">
   <label>
          <?php echo ' '.$details." ".$userfarm;
          echo '   '."|"." התוכנית הפעילה:".$program;?> 
   </label></div>
</body>
<div class="right"></div>
</html>