<?php
include '../functions.php';
include '../home.html';

$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$browserLanguage='he';
$langAllignment=getLangAllingment($db, $browserLanguage);
$username=$_COOKIE["user"];
$userfarm=$_COOKIE["farm"];
$details=  getUserFamily($db, $username);
$program= getUserProgram ($db, $username);
$set1_select1=getMsg($db, $browserLanguage, 'set1_select1');
$set1_select2=getMsg($db, $browserLanguage, 'set1_select2');
$set1_select3=getMsg($db, $browserLanguage, 'set1_select3');
if($program==1)
{$program=$set1_select1;}
 else if($program==2){$program=$set1_select2;} else if($program==3) {$program=$set1_select3;};
$dailyPhrase=getMsg($db, $browserLanguage, 'daily activity');
$cowsPhrase=getMsg($db, $browserLanguage, 'cows');
$bullsPhrase=getMsg($db, $browserLanguage, 'bulls');
$settingsPhrase=getMsg($db, $browserLanguage, 'settings');
$insemPhrase=getMsg($db, $browserLanguage, 'Insemination');
$updatePhrase=getMsg($db, $browserLanguage, 'system updated');
$lastupdatePhrase=getMsg($db, $browserLanguage, 'last update');
$titlePhrase=getMsg($db, $browserLanguage, 'The Matching Program');
$daysPhrase=getMsg($db, $browserLanguage, 'days ago');
$versionPhrase=getMsg($db, $browserLanguage, 'version');
$copyrightPhrase=getMsg($db, $browserLanguage, 'copyright');
$davidPhrase=getMsg($db, $browserLanguage, 'david');
?>
<!DOCTYPE html>
<html>
   <body>
<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="menu.css" />
   
<title>
Xmatch-Genetics new_user </title>

    
  <div class="header" id="header">
<div id="center2">
     <div class="img">  <img src="/assets/logo.jpg"></div>
         <div class="menu" id="menu">
</div>

       <div class="sucess">
      
       <p id="sucess"><?php echo $updatePhrase;?></p>
       <p id="update"><?php echo $lastupdatePhrase;?> 7 <?php echo $daysPhrase;?></p>
     </div>  
  </div>
</head>
<div class="details">
<div id="center2">
   <label>
          <?php echo ' '.$details." ".$userfarm;
          echo '   '."|"." Active Program:".$program;?> 
   </label></div></div>
    <div class="underdetails"></div>
<div class="title">
    <img src="/assets/logo_small.jpg">
    <p class="title1"><?php echo $titlePhrase;?></p>
    <p class="version"><?php echo $versionPhrase;?> 1.0.9</p>
    <p class="title2"><?php echo $davidPhrase;?></p>
    <p class="copyright"><?php echo $copyrightPhrase;?></p>
    <br><br>
</div>
<div class="circlemenu">
<div class="center">
    <div class="part1">  <a href="dailyActivity.php" ><div class="circle">
      </div>
            <label><?php echo $dailyPhrase;?></label></a></div>
        <div class="part1"><a href="cows1.php"><div class="circle"id="manual" >
                </div></a>
        <label><?php echo $cowsPhrase;?></label></div>
    <div class="part1"><a href="bulls.php" > <div class="circle" id="bulls">
                 </div></a>
        <label><?php echo $bullsPhrase;?>                     
        </label></div>
            <div id="setting" class="part1">  <a href="settings1.php" ><div class="circle" id="settings">
      </div>
            <label><?php echo $settingsPhrase;?></label></a></div>
            </div>
</div>
</body>
</html>