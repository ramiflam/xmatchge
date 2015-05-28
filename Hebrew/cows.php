<?php
 include "navigationBar.php";
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
$updatePhrase=getMsg($db, $browserLanguage, 'updateCows');
$updatecowPhrase=getMsg($db, $browserLanguage, 'updateC');
$createPhrase=getMsg($db, $browserLanguage, 'Create Future Insemination List');
$backPhrase=getMsg($db, $browserLanguage, 'Back');
$clearPhrase=getMsg($db, $browserLanguage, 'Clear');
$printPhrase=getMsg($db, $browserLanguage, 'Print');
 ?>
<!DOCTYPE html>
<html>
<body>
<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="cows.css" />

</head>
<div class="content">
    <ul>
        <a href="cows1.php"><li><?php echo $updatecowPhrase;?></li> </a>
    </ul>
      <ul>
          <a href="cows2.php"><li id="createinsem" ><?php echo $createPhrase;?></li></a>
    </ul>
</div>
<div class="sidebar">
<h1><?php echo $updatePhrase;?></h1>
</div>
