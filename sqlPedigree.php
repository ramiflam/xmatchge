<?php
include 'functions.php';
include 'home.html';
include 'ajax.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}

/*$query = "UPDATE pedigree_bull_israel SET PGS='(SELECT sire_isr_no from `pedigree_bull_israel` WHERE bull_no =(SELECT sire_isr_no from `pedigree_bull_israel` WHERE bull_no =11))'WHERE bull_no =11;";     
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
                echo "thankssssssssssss";
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["PGS"];
 		echo "the result is".$UserType;
        }
        else 
        echo "not succeed";
  $query = "SELECT COUNT(*) FROM table_name;"; 
  $resultt = mysqli_query($db, $query);
  echo "the count of rows".$resultt;
  
//update the PGS on the pedigree table (PGS=Grandfather of the bull Father's father)
  
        $query="SELECT bull_no FROM `pedigree_bull_israel`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result)) {
         $result_list[] = $row;
         
}
    foreach($result_list as $row) {

        $i=$row["bull_no"];
        $query = "SELECT sire_isr_no from `pedigree_bull_israel` WHERE bull_no =(SELECT sire_isr_no from `pedigree_bull_israel`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["sire_isr_no"];
        }
        else 
        echo "not succeed";
        $query = "UPDATE pedigree_bull_israel SET PGS='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);
        If ($resultt->num_rows >0)
        {
                echo "succeed :-)";
        }
        else 
        echo "not succeed";
 
}

//update the PPGS on the pedigree table (ppgs= pgs סבא רבה של הפר אבא של )
        $query="SELECT bull_no FROM `pedigree_bull_israel`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result)) {
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
        $i=$row["bull_no"];
        $query = "SELECT sire_isr_no from `pedigree_bull_israel` WHERE bull_no =(SELECT PGS from `pedigree_bull_israel`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["sire_isr_no"];
 		echo "the result sire isr no".$UserType;
        }
        else 
        echo "not succeed";
     
        $query = "UPDATE pedigree_bull_israel SET PPGS='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);
}
//update the MGS on the pedigree table (mgs= דור 4  סבא רבה רבה מצד האמא סבא של הסבא של הפר)
        $query="SELECT bull_no FROM `pedigree_bull_israel`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result)) {
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT MGS_no_ISR from `pedigree_bull_israel` WHERE bull_no =(SELECT MGS_no_ISR from `pedigree_bull_israel`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["MGS_no_ISR"];
        }
        $query = "UPDATE pedigree_bull_israel SET MGS='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}
?>*/
/*
//update the PP2 on the pedigree table (pp2= סבא רבה של הפר אבא של הסבא מצד האמא)
        $query="SELECT bull_no FROM `bull_israel_pedigree`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT sire_isr_no from `bull_israel_pedigree` AS p WHERE bull_no =(SELECT MGS_no_ISR from `bull_israel_pedigree`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["sire_isr_no"];
        }
        $query = "UPDATE bull_israel_pedigree SET PP2='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}
//update the PPPGS on the pedigree table(pppgs= סבא רבה רבה של הפר מצד האבא)
        $query="SELECT bull_no FROM `bull_israel_pedigree`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT sire_isr_no from `bull_israel_pedigree` AS p WHERE bull_no =(SELECT PPGS from `bull_israel_pedigree`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["sire_isr_no"];
        }
        $query = "UPDATE bull_israel_pedigree SET PPPGS='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}
//update the PP3 on the pedigree table(pp3=סבא רבה רבה של הפר מצד האמא אבא של PP2)
        $query="SELECT bull_no FROM `bull_israel_pedigree`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT sire_isr_no from `bull_israel_pedigree` AS p WHERE bull_no =(SELECT PP2 from `bull_israel_pedigree`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["sire_isr_no"];
        }
        $query = "UPDATE bull_israel_pedigree SET PP3='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}
//update the PM2 on the pedigree table
        $query="SELECT bull_no FROM `bull_israel_pedigree`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT MGS_no_ISR from `bull_israel_pedigree` WHERE bull_no =(SELECT sire_isr_no from `bull_israel_pedigree`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["MGS_no_ISR"];
        }
        $query = "UPDATE bull_israel_pedigree SET PM2='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}
//update the PM3 on the pedigree table
        $query="SELECT bull_no FROM `bull_israel_pedigree`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT sire_isr_no from `bull_israel_pedigree` WHERE bull_no =(SELECT PM2 from `bull_israel_pedigree`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["sire_isr_no"];
        }
        $query = "UPDATE bull_israel_pedigree SET PM3='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}
//update the MGG3 on the pedigree table
        $query="SELECT bull_no FROM `bull_israel_pedigree`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT sire_isr_no from `bull_israel_pedigree` WHERE bull_no =(SELECT MGGS from `bull_israel_pedigree`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["sire_isr_no"];
        }
        $query = "UPDATE bull_israel_pedigree SET MGG3='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}
//update the PPP3 on the pedigree table
        $query="SELECT bull_no FROM `bull_israel_pedigree`";
        $result = mysqli_query($db, $query);

         $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
        
}
    foreach($result_list as $row) {
      
        $i=$row["bull_no"];
        $query = "SELECT MGS_no_ISR from `bull_israel_pedigree` WHERE bull_no =(SELECT PGS from `bull_israel_pedigree`WHERE bull_no='$i');";        
        $result = mysqli_query($db, $query);
        If ($result->num_rows >0)
        {
        	$row = mysqli_fetch_assoc($result);
 		$UserType = $row["MGS_no_ISR"];
        }
        $query = "UPDATE bull_israel_pedigree SET PPP3='$UserType' WHERE bull_no='$i';"; 
        $resultt = mysqli_query($db, $query);      
 
}*/
//update the PPP3 on the pedigree table
        $query="SELECT User_Name,User_Address,Password FROM `users_details`";
        $result = mysqli_query($db, $query);
        
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result_list = array();
         while($row = mysqli_fetch_array($result))
{
         $result_list[] = $row;
         func($row["User_Name"],$row["User_Address"],$row["Password"]);
        
}
        printf ("%s %s %d",$row["User_Name"],$row["User_Address"],$row["Password"]);
         func($row["User_Name"],$row["User_Address"],$row["Password"]);

         function func($name,$row2,$row3)
         {
            echo "the username is ".$name."<br/>";
         }