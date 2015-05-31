<?php
include 'functions.php';
include 'home.html';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
//$reurnvall=NULL;
//$command ="mysqldump  -uxmatchge_nom  -pjourno359 xmatchge_Gen > xmatch_general.sql 2>&1";
//exec($command);
//$command ="mysqldump  -uxmatchge_nom  -pjourno359 xmatchge_test > xmatch_test.sql 2>&1";
//exec($command);
/*
$command ="mysqldump  -uxmatchge_rami  -pmaganoya0p xmatchge_Gen > xmatch_general_tables.sql 2>&1";
exec($command);
*/
//echo"the output is:".$OUTPUTmaganoya0p;
//echo"the returnval is:".$returnval;
 
?>