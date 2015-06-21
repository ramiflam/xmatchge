<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
return;
}

//print_r($_FILES);
$target_path = '../../uploads/';
$uploadFileName = $_FILES['fileToUpload']['name']; 
$message="SORRY, NOT FILE SELECTED.";
    //Checks if a file is selected
if(!$_FILES['fileToUpload']['name'])
{
    echo 'No file selected<br>';
       //header('Location: fileLoad.php');
       return;
} else  echo 'New file selected<br>';
 $uploadOk = 1;

// Check if file already exists
if(isset($_POST["submit"])) {
	$uploadOk = 1;
	if (file_exists($target_path.$uploadFileName )) {
	    echo 'Sorry, file &nbsp;' .  $uploadFileName . '&nbsp; already exists.';
	    $uploadOk = 0;
	}

$user=$_COOKIE["user"];
//echo '<br> User is &nbsp;'.$user;
$format="%Y%m%d%H%M%S";
//  echo '<br>Format is &nbsp;'.$format;
$strf=strftime($format);
//  echo '<br>date and time is &nbsp;'.$strf;
   
//upload the file
if($uploadOk){
         
	// set file name to be <timestaem>_origfilename>
	// $processFileName= $strf . '_' .$user. '_' .$origFileName;
	// echo '<br>'.$processFileName;
	
	// copy file to target location
	// echo '<br> Moving &nbsp;'.$uploadFileName. '&nbsp; to &nbsp;'.$target_path;

	$result = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_path.$uploadFileName);
	if($result) {
	    echo "<br>The file has been uploaded";
	    if($_GET["bulls"]){
	    $tableName = 'bulls_details';
	    }
	    else {
	    $tableName = 'local_cows';
	    }
	    // insert record into file_audit table
	    	$sql="INSERT INTO  file_audit (FileName, FilePath, TimeLoaded, NumberOfRecords, RunStatus, User,tableName) 
	    	VALUES ('$uploadFileName', '$target_path', NOW(), 0, 'NotRun', '$user','$tableName');" ;
	    	
	    	echo $sql;
		// echo '<br>'.$sql;
		$result = mysqli_query($db, $sql);
		
		// checking result
		
		 if($result)
		   {
		     echo '<br> File data loaded in '.$tableName.' table';
		     // return true;
		     if($_GET["bulls"]){
		     updateBulls($db);
		     } else {
		      echo '##############';
		     }
		   }
		   else
		   {
			echo '<br> failed to load File data in '.$tableName.' table';
			// return false;
		   }
	
		}
		else {
		    echo "<br>There was an error uploading the file, please try again!";
		}
	  }
}



function updateBulls($db){

$sql="SELECT * FROM  `file_audit` WHERE RunStatus =  'NotRun' AND tableName='bulls_details'";
$result = mysqli_query($db,$sql);

$resultArr = mysqli_fetch_array($result);
$target_path = $resultArr["FilePath"].$resultArr["FileName"];
echo $target_path;

if($target_path!=''){

$sql="truncate `Herdbook ISR1115`";
$result = mysqli_query($db,$sql);

$query ="LOAD DATA LOCAL INFILE '$target_path'
REPLACE INTO TABLE `Herdbook ISR1115`
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\\n'
IGNORE 1 LINES
(bull_no,bull_name_heb,intebull_no,bull_name_en,sire_isr_no,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,breed_code_isr,@dummy,@dummy,@dummy,brd_milk,@dummy,brd_fat_pre,@dummy,brd_prot_pre,SCC,ECM,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,clving_easy_paternal,@dummy,@dummy,body_size,@dummy,udder,feet_and_legs,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,teat_replacmenat,@dummy,udder_dept,@dummy,@dummy,MGS_no_ISR,@dummy,@dummy,daughter_fertilty,@dummy,@dummy,@dummy,@dummy,CVM,@dummy,@dummy,@dummy,active_sion,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy)";
echo $query;
mysqli_query($db,$query);

$query =" UPDATE  `Herdbook ISR1115`
SET body_size = 100 
WHERE body_size < 60 OR body_size >160;";
mysqli_query($db,$query);

$query ="UPDATE  `Herdbook ISR1115`
SET udder = 100 
WHERE udder < 60 OR udder >160;";
mysqli_query($db,$query);

$query ="UPDATE  `Herdbook ISR1115`
SET feet_and_legs = 100 
WHERE feet_and_legs < 60 OR feet_and_legs >160;";
mysqli_query($db,$query);

$query ="UPDATE  `Herdbook ISR1115`
SET teat_replacmenat = 100 
WHERE teat_replacmenat < 60 OR teat_replacmenat >160;";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115`
SET udder_dept = 100 
WHERE udder_dept < 60 OR udder_dept >160;";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS c,  `STV_per_traits_per_base` AS s
SET c.brd_milk =(1.0*c.brd_milk/s.STV*4 +100) WHERE s.Traits='milk[kg]' AND
(1.0*c.brd_milk/s.STV*4 +100)>60 AND (1.0*c.brd_milk/s.STV*4 +100)<160;";
mysqli_query($db,$query);


$query = "UPDATE  `Herdbook ISR1115` AS c,  `STV_per_traits_per_base` AS s
SET c.brd_fat_pre =(1.0*c.brd_fat_pre/s.STV*4 +100) WHERE s.Traits='fat_percentage' AND
(1.0*c.brd_fat_pre/s.STV*4 +100)>60 AND (1.0*c.brd_fat_pre/s.STV*4 +100)<160;";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS c,  `STV_per_traits_per_base` AS s
SET c.SCC =(1.0*c.SCC/s.STV*4 +100) WHERE s.Traits='SCC' AND
(1.0*c.SCC/s.STV*4 +100)>60 AND (1.0*c.SCC/s.STV*4 +100)<160;";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS c,  `STV_per_traits_per_base` AS s
SET c.clving_easy_maternal =(1.0*c.clving_easy_maternal/s.STV*4 +100) WHERE s.Traits='MCE' AND
(1.0*c.clving_easy_maternal/s.STV*4 +100)>60 AND (1.0*c.clving_easy_maternal/s.STV*4 +100)<160;";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS c,  `STV_per_traits_per_base` AS s
SET c.daughter_fertilty =(1.0*c.daughter_fertilty/s.STV*4 +100) WHERE s.Traits='fertility' AND
(1.0*c.daughter_fertilty/s.STV*4 +100)>60 AND (1.0*c.daughter_fertilty/s.STV*4 +100)<160;";
mysqli_query($db,$query);
$query = "UPDATE  `Herdbook ISR1115` i,  `herdbook nor` n
SET i.brd_milk = n.milk_kg, i.brd_fat_pre = n.fat_pct, i.brd_prot_pre = n.prot_pct, i.SCC = n.mast_indx, i.body_size = 94, i.udder = n.udder_indx, i.feet_and_legs = n.leg_indx,  i.teat_replacmenat = n.fore_pl,  i.udder_dept = n.uddep,  i.daughter_fertilty = n.fert_indx, i.clving_easy_maternal = n.caease_m 
WHERE ((((SUBSTR(i.intebull_no,11,5)) = '0'+n.Sire) OR (SUBSTR(i.intebull_no,11,5)) = n.Sire) AND (SUBSTR(i.intebull_no,1,3))='NOR');";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.brd_milk =i.brd_milk + n.david_adjust
WHERE n.trait='brd_milk' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.brd_fat_pre =i.brd_fat_pre + n.david_adjust
WHERE n.trait='brd_fat_pre'  AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.brd_prot_pre =i.brd_prot_pre + n.david_adjust
WHERE n.trait='brd_prot_pre'  AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);
$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.SCC =i.SCC + n.david_adjust
WHERE n.trait='SCC' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.body_size =i.body_size + n.david_adjust
WHERE n.trait='body_size' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.udder =i.udder + n.david_adjust
WHERE n.trait='udder' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.feet_and_legs =i.feet_and_legs + n.david_adjust
WHERE n.trait='feet_and_legs' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.teat_replacmenat  =i.teat_replacmenat  + n.david_adjust
WHERE n.trait='teat_replacmenat' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.udder_dept =i.udder_dept + n.david_adjust
WHERE n.trait='udder_dept' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.daughter_fertilty =i.daughter_fertilty + n.david_adjust
WHERE n.trait='daughter_fertilty' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);

$query = "UPDATE  `Herdbook ISR1115` AS i,  `add_to_nor` AS n
SET i.clving_easy_maternal =i.clving_easy_maternal + n.david_adjust
WHERE n.trait='clving_easy_maternal' AND (SUBSTR(i.intebull_no,1,3))='NOR';";
mysqli_query($db,$query);


$query = "truncate `bulls_details`;";
mysqli_query($db,$query);

$query = "INSERT INTO `bulls_details` (`bull_no`, `bull_name`, `bull_foreign_no`, `bull_foreign_name`, `sire`, `Breed`, `KG_milk`, `Fat_percentage`, `Protein_percentage`,`SCC`, `KG_ECM`, `General_size`, `General_udder`, `General_legs`,  `Teats_location`, `Udder_depth`, `MGS`, `Fertility`, `CVM`, `Match_status`, `Pelvis_stucture`) 
SELECT `bull_no`,`bull_name_heb`, `intebull_no`, `bull_name_en`, `sire_isr_no`, `breed_code_isr`, `brd_milk`, `brd_fat_pre`, `brd_prot_pre`, `SCC`, `ECM`, `body_size`, `udder`, `feet_and_legs`, `teat_replacmenat`, `udder_dept`, `MGS_no_ISR`, `daughter_fertilty`, `CVM`,  `active_sion`, `clving_easy_maternal`
  FROM `Herdbook ISR1115`;";
  mysqli_query($db,$query);
  
$query = "UPDATE  `Herdbook ISR1115` i,  `bulls_details` b
SET b.bull_foreign_no = i.intebull_no, b.Visible=1
WHERE i.bull_no=b.bull_no;";
mysqli_query($db,$query);

$query = "UPDATE `bulls_details` SET `strawType`='Regular'";
mysqli_query($db,$query);
     
       // if ($result)
       // {
        echo "thanksssssss succeed!!!!!!!!!<br>";

	//$result = mysqli_query($db,$query);
	//if ($result)
        //{
		//$result = mysqli_query($db,$query3);
		print_r($result);
	        echo "The data updated!!!!!!!!!<br>";  
	        $sql="UPDATE `file_audit` SET RunStatus = 'Run' WHERE FileName='".$resultArr["FileName"]."'";
	        echo $sql;
		$result = mysqli_query($db,$sql);
	//}
        //}
     //else
     // {
     // echo"...you are not succeed .....-:(<br><br><br>";
     // }
if(file_exists($target_path)){
 echo "the file exist ";

 $farm=getUserFarm($db,$username);
 echo "the file exist  $farm";
echo "the farm name is ".$farm." ";
 $sql="UPDATE local_cows SET Farm='$farm' " ;
$result2 = mysqli_query($db,$sql);  
 $user_ID=getUserId($db,$username);
echo "the user id is ".$user_ID." ";
 $sql="UPDATE local_cows SET  User_ID='$user_ID' " ;
$result2 = mysqli_query($db,$sql);  
}

 else
{

echo "the file not exist ";
 
}
}
}

?>