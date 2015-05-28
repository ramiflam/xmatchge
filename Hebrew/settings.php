<?php
 include "navigationBar.php";
$browserLanguage='he';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$activePhrase=getMsg($db, $browserLanguage, 'Active Genetic Plan');
$preferedPhrase=getMsg($db, $browserLanguage, 'Prefered Characteristics');
$GenPhrase=getMsg($db, $browserLanguage, 'General Bulls Matching Settings');
$GenfarmPhrase=getMsg($db, $browserLanguage, 'General Farm Settings');
$manualPhrase=getMsg($db, $browserLanguage, 'Manual Import');
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="settings.css" />
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
</head>
<body>
<div class="content">
    <ul>
        <a href="settings1.php"><li class="activePhrase"><?php echo $activePhrase;?></li> </a>
    </ul>
      <ul>
          <a href="settings2.php"><li class="preferedPhrase"><?php echo $preferedPhrase ;?></li></a>
    </ul>
       <ul>
           <a href="settings5.php"><li class="GenPhrase"><?php echo $GenPhrase;?></li> </a>
    </ul>
      <ul>
          <a href="settings3.php"><li class="GenfarmPhrase"><?php echo $GenfarmPhrase;?></li></a>
    </ul>
         <ul>
             <a href="settings4.php"><li class="manualPhrase"><?php echo $manualPhrase;?></li></a>
    </ul>
</div>
<script>
	var windowHeight = $( window ).height();
	var headerHeight = $("#header").height() + $(".details").height();
	var wantedHeight = windowHeight - headerHeight;
	$(".content").css("height", wantedHeight);
</script>
</body>
</html>