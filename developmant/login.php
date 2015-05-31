<?php
    $db = mysqli_connect('localhost','xmatchge','$Xmatch)0p','xmatchge_Gen');
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
?>

<html>
<meta http-equiv="Content-Type" content="text/html/php" charset="utf-16le" />
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
else { 
	echo '<p>Connection success</p>';
	echo 'Language is &nbsp;' . $lang;
	echo '<br>';
	$query = "SELECT * FROM `messages`;";
        $result = mysqli_query($db, $query);
       
       
        while($row = mysqli_fetch_assoc($result)) {
	        // Display your datas on the page
		echo 'Type is &nbsp;' . $row["type"];
		echo 'lang is &nbsp; ' . $row["lang"];
		echo '&nbsp; message is &nbsp;' . $row["message"];
		echo '<br>';
        }
        // get message for login in english
        $query1 = "SELECT message FROM `messages` where type='Login' and lang='$lang';";
        echo 'query1 is &nbsp;' . $query1;
       $result1 = mysqli_query($db, $query1);
        $row = mysqli_fetch_assoc($result1);
	// Display your datas on the page
	echo 'message for Login in English is &nbsp;' . $row["message"];
	echo '<br>';

	mysqli_close($db);
}
 ?> 
 </body>
</html>