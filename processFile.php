<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
return;
}
// echo "starting files processing files" . PHP_EOL;
$sql = "SELECT TimeLoaded,FileName  FROM file_audit WHERE RunStatus='NotRun'";
$result = mysqli_query($db, $sql);
// $row = mysqli_fetch_assoc($result);
$count=$result->num_rows;
if ($count > 0) 
{
    $proc = array();
    while($row = $result->fetch_assoc())
     {
      $timeLoaded=$row['TimeLoaded'];
      $fileName = $row['FileName'];
      //echo $timeLoaded . " " . $fileName . PHP_EOL;
      $status = processFile($db,$fileName, $timeLoaded);
     }
 }
else
{
	echo "No files found for processing " . PHP_EOL;
}
    
   // processFile($db,$re);    
function processFile($db,$fileName, $timeLoaded)
{

	$query = "UPDATE file_audit SET RunStatus='Run',TimeProcess=now() WHERE FileName='$fileName' and TimeLoaded='$timeLoaded' ;" ; 
	echo $query . PHP_EOL;
	$result = mysqli_query($db, $query);  
	if($result)
	{   
            //Write action to txt log
            {
             $log  = "Processing of ". $fileName . "  " . " completed successfully at ".date("Y/m/d h:m:s").PHP_EOL.
            "-------------------------".PHP_EOL;
     
    		file_put_contents('xmatch_logs/'.date("Ymd").'_xmatch.log', $log, FILE_APPEND);
    		return TRUE;
             }
        }
        else {
        	// echo "DB update failed for " . $fileName . PHP_EOL;
        	$log  = "Processing of ". $fileName . "  " . " completed with ERROR at ".date("Y/m/d h:m:s").PHP_EOL.
            	"-------------------------".PHP_EOL;
     
    		file_put_contents('xmatch_logs/'.date("Ymd").'_xmatch.log', $log, FILE_APPEND);
        	return FALSE;
        }
}
?>