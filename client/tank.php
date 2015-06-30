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

if(isset($_GET["order"])){
$order=$_GET["order"].',';
} else {
$order='';
}
 /* 
if(!empty($_REQUEST['search'])) {
   //if(isset($_POST['find'])){
$search=$_POST['search'];
 $sql = "SELECT * FROM `bulls_details` WHERE bull_no LIKE '%".$search."%' "; 
        $searchResult = mysqli_query($db, $sql);
                $result_list = array();
                $searchRow= mysqli_fetch_array($searchResult );
         while($searchRow)
{
$result_list[] = $searchRow;
echo '<br />bull number: ' .$searchRow['bull_no'];  
echo '<br /> bull name: ' .$searchRow['bull_name']; 
} 
}
else 
{
//echo "imnot succeeddd";
}
*/
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="bulls.css" />
    <link rel="stylesheet" type="text/css" href="popup.css" />
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
<body>
<style type="text/css">
.menu a#tank{
  border-bottom: 5px solid;
  border-bottom-color: #7a1519;
  padding-bottom:8px;
}
.menu a#Bulls {
border-bottom: 0px solid;
}
</style>
<div class="content">
    <ul>
        <a href=""><li>Stock Settings</li> </a>
    </ul>
    <ul>
        <a href=""><li id="insemlist">Enter to stock</li> </a>
    </ul>
    <ul>
        <a href=""><li id="insemlist">Exit from stock</li> </a>
    </ul>
    <ul>
        <a href=""><li id="insemlist">The balance of Stock</li> </a>
    </ul>
</div>
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</html>