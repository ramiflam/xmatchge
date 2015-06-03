<?php

 //include "navigationBar.php";
  include "matchFunctions.php";
 //include "ex2.php";
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}

        $query = "TRUNCATE TABLE `daily_insemination_list`;" ;     
        $result = mysqli_query($db, $query);

?>