<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
return;
}

/*echo $_POST["farmName"];
$sql="INSERT INTO `farms` (farm_name)
                   VALUES ('".$_POST["farmName"]."')";
                   //echo $sql;
	    	 $result = mysqli_query($db, $sql);*/
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
		     updateCows($db);
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

$query = "UPDATE `bulls_details` SET `Protein_percentage`=100 where Protein_percentage=0 or ISNULL(Protein_percentage)";
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

}
}

function updateCows($db){
$sql="SELECT * FROM  `file_audit` WHERE RunStatus =  'NotRun' AND tableName='local_cows'";
$result = mysqli_query($db,$sql);

$resultArr = mysqli_fetch_array($result);
$target_path = $resultArr["FilePath"].$resultArr["FileName"];
echo $target_path;

if($target_path!=''){

$username=$_COOKIE["user"];
$farmName=$_POST["farmName"];

if(file_exists($target_path)){
	 echo"the file exist "; 
	 
	$sql="DELETE FROM `local_cows` WHERE User_Id='$username' and Farm='".$_POST["farmName"]."'";
	$result = mysqli_query($db,$sql);
	
	$query ="LOAD DATA LOCAL INFILE '$target_path'
	REPLACE INTO TABLE local_cows
	FIELDS TERMINATED BY ',' 
	LINES TERMINATED BY '\\r\\n'
	IGNORE 1 LINES
	(last_milk_per_day,AI_bull_ISR_number,last_SCC,AI_type,not_for_AI,exp_Calving_date,now_at_milk,preg,lact_no,	match_status,barach,groupe,group_name,cull_date,enter_way,breed,MGS,sex,cow_name	,tag_color,no_tag,burn_no,government_no,		sire,Live_sire,computer_no,cow_no,computer_mom,avg_milk_last_10_days,avg_milkig_time_in_last_10_days,brd_milk_kg	,brd_fat_kg,brd_prot_kg,brd_fat_pre,brd_prot_pre,brd_SCC,brd_ECM,brd_udder,brd_legs,brd_milk_mom,brd_fat_kg_mom,	brd_prot_mom,	brd_fat_pre_mom,brd_prot_pre_mom,brd_SCC_mom,brd_ecm_mom,brd_tpi_mom,brd_udder_mom,brd_legs_mom,	brd_milk_sire,brd_fat_kg_sire,	brd_prot_kg_sire,brd_fat_pre_sire,brd_prot_pre_sire,brd_SCC_sire,brd_ecm_sire,brd_tpi_sire,brd_udder_sire,brd_legs_sire,	brd_dau_fertilty,brd_still_birth,brd_calvig_easy,TPI,BirthDate,exit_way,exit_reason,exiy_weight,price_per_kg,exit_price,	bayer,	calving_date,dry_date,last_dhi_date,no_dhi_after_calving,pl_milk_kg,last_AI_date	,pl_Fat_kg,pl_prot_kg,pl_laktuz_miz,	adjust_milk_kg,adjust_fat_kg,adjust_prot_kg,mom_no,mom_name,DIM,days_in_preg,bayer_name,bayer_farm_name,days_after_AI,	days_till_next_calving,days_till_dry,enter_whight,wining_wheight,growth_rate,growth_rate_total,days_after_dry,	BCS_date_after_calvig,total_wight,BCS_pick_milk_date,BCS_pick_milk,BCS_dry_date,BCS_dry,BCS_half_dry_date,	BCS_half_dry,avg_milk,avg_ecm,wested_days_AI,open_days,rest_days,SCC_calc1,ECM_total_at_lact,ecm_according_the_heard,	no_of_milking_by_day,last_DHI_date2,last_heating_date,last_abortion,adjust_ecm,edjust_ecm_prev_lact,adjust_prot_kg_prev_lact,	adjust_milk_prev_lact,adjust_fat_kg_prev_lact,DIM_prev_lact,mate_1,inseminator_name,highet,exp_milk_kg_305,exp_fat_kg_305,	exp_ecm_305,exp_prot_kg,match_bull,exp_exm_305,age_by_month,adjust_ecm2,feed_lot,days_till_dry2,rep,AI_time,fat_pre_DHI,	prot_pre_DHI,supply,pl_prot_pre,efect_preg_date,pl_milk,highet_date,last_calving_days_in_dry,for_cull,pl_fat_pre,preg2,PGS,	date_molk_day,last_calvig_date,fatprot,last_milk1,unknown,last_whight,last_wheight_date,enter_date,enter_last_date,	days_in_last_group,unknown2,last_se,birth_month,whight1,whight2,whight3,whight4,whight5,whight6,whight7,whight8,whight_rate1	,whight_rate2,whight_rate3,	whight_rate4,whight_rate5,whight_rate6,whight_rate7,whight_rate8,whight_date1,whight_date2,whight_date3,	whight_date4,	whight_date5,whight_date6,whight_date7,whight_date8,date_pick_milk,kg_at_pick,bying_price,	unknown3,last_vet,last_vet_diagnosis,sorting,vac_date,vac_drug,last_gov_no,age_in_1_lact,	persistence_1,persistence_1_2,no_live_bull,live_bulld_fate,colestrom_value1,colestrom_value2,refractometers_value,remark	) set User_Id='$username',Farm='".$_POST["farmName"]."';";
	  $result = mysqli_query($db,$query);      
	        If ($result)
	        {
	        echo "thanksssssss succeed!!!!!!!!!<br>";
	        $numrpt = mysqli_num_rows($result); 
	        print_r($result);
	        echo "The data updated!!!!!!!!!<br>";
	        CommonFeatures4Points($db);  
	        $sql="UPDATE `file_audit` SET RunStatus = 'Run' WHERE FileName='".$resultArr["FileName"]."'";
	        echo $sql;
		$result = mysqli_query($db,$sql);
	        }
	     else
	      {
	      echo"...you are not succeed .....-:(<br><br><br>";
	      }
	
	}
	 else
	{
	
	echo"the file not exist ";
	 
	}
	
}
}

function CommonFeatures4Points($db)
{      
$username=$_COOKIE["user"];
$farmName=$_POST["farmName"];

         $query="SELECT * FROM `local_cows` where User_Id='$username' and Farm='".$_POST["farmName"]."'";
         $result = mysqli_query($db, $query);
         $result_list = array();
         while($row = mysqli_fetch_array($result)) {
         $result_list[] = $row;
         
}
   foreach($result_list as $row) {
     $currentCow=$row['cow_no'];
     $currentSire=$row['sire'];
     $currentMGS=$row['MGS'];
     
      $query="UPDATE `local_cows` set brd_general_size=100 WHERE brd_general_size=0 or ISNULL(brd_general_size)";
   $result = mysqli_query($db, $query); 
   
   $query="UPDATE `local_cows` set brd_Teats_placement=100 WHERE brd_Teats_placement=0 or ISNULL(brd_Teats_placement)";
   $result = mysqli_query($db, $query); 
   
   $query="UPDATE `local_cows` set brd_legs=100 WHERE brd_legs=0 or ISNULL(brd_legs)";
   $result = mysqli_query($db, $query); 

     $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_milk_kg =c.brd_milk_kg/s.STV*4 +100 WHERE s.Traits='milk[kg]' AND (
(c.brd_milk_kg/s.STV*4 +100)>60 OR (c.brd_milk_kg/s.STV*4 +100)<160) AND c.cow_no='$currentCow' AND c.User_Id='$username' and c.Farm='".$_POST["farmName"]."';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(milk)");
    }
   
  else{echo "<br>the rusult num rows is".$result_num;}
       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
    SET c.brd_fat_pre=c.brd_fat_pre/s.STV*4 +100 WHERE s.Traits='fat_percentage' AND (
(c.brd_fat_pre/s.STV*4 +100)>60 OR (c.brd_fat_pre/s.STV*4 +100)<160) AND c.cow_no='$currentCow' AND c.User_Id='$username' and c.Farm='".$_POST["farmName"]."';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(fat pre)");
    } 
   else{echo "<br>the rusult num rows is".$result_num;}
       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_prot_pre=c.brd_prot_pre/s.STV*4 +100 WHERE s.Traits='protein_percentage'  AND
((c.brd_prot_pre/s.STV*4 +100)>60 AND (c.brd_prot_pre/s.STV*4 +100)<160) AND c.cow_no='$currentCow' AND c.User_Id='$username' and c.Farm='".$_POST["farmName"]."';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      //exit("alert!!! you can't continue ask expert!!!!(protein pre)");
    }
else{echo "<br>the rusult num rows is".$result_num;}
       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_dau_fertilty=c.brd_dau_fertilty/s.STV*4 +100 WHERE s.Traits='fertility' AND
((c.brd_dau_fertilty/s.STV*4 +100)>60 AND (c.brd_dau_fertilty/s.STV*4 +100)<160)AND c.cow_no='$currentCow' AND c.User_Id='$username' and c.Farm='".$_POST["farmName"]."';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      //exit("alert!!! you can't continue ask expert!!!!(fertility)");
    }
    else{echo "<br>the rusult num rows is".$result_num;}


       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_SCC=c.brd_SCC/s.STV*4 +100 WHERE s.Traits='SCC'  AND
((c.brd_SCC/s.STV*4 +100)>60 AND (c.brd_SCC/s.STV*4 +100)<160)AND c.cow_no='$currentCow' AND c.User_Id='$username' and c.Farm='".$_POST["farmName"]."';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      //exit("alert!!! you can't continue ask expert!!!!(SCC)");
    }
else{echo "<br>the result num rows is".$result_num;}

       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_Ramp_stucture=c.brd_Ramp_stucture/s.STV*4 +100 WHERE s.Traits='MCE'  AND
((c.brd_Ramp_stucture/s.STV*4 +100)>60 AND (c.brd_Ramp_stucture/s.STV*4 +100)<160)AND c.cow_no='$currentCow' AND c.User_Id='$username' and c.Farm='".$_POST["farmName"]."';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      //exit("alert!!! you can't continue ask expert!!!!(MCE)");
    }
  else{echo "<br>the result num rows is".$result_num;}


$sql="select BreedCode_2_ch,bull_no,breed_code_isr from `table_breeds` AS TB, `bull_file_israel` AS BI where BI.breed_code_isr= TB.ISRcode and bull_no='$currentSire'" ;
$result = mysqli_query($db, $sql);
if($result){

        	$row = mysqli_fetch_assoc($result);
 		$cowDetails = $row["BreedCode_2_ch"];
 		$sire = $row["bull_no"];
 		//echo "<br>THE breed code ISSS".$cowDetails."and the sire is".$sire ;

}
        if($cowDetails =='NR')
        {
          //   the cow's sire == NRF 
           //descendantsOfNRF($db,$currentCow,$sire,$currentMGS);
        }
        else
        {
         //echo "<br>no!!!";
        }
}
}

function descendantsOfNRF($db,$currentCow,$sire,$currentMGS)
{
         $query="SELECT * FROM `bulls_details` WHERE sire='$sire' ";
         $result = mysqli_query($db, $query);
         $sireRow = mysqli_fetch_assoc($result);
        
   $sql="select BreedCode_2_ch,bull_no,breed_code_isr from `table_breeds` AS TB, `bull_file_israel` AS BI where BI.breed_code_isr= TB.ISRcode and bull_no='$currentMGS'" ;
$result = mysqli_query($db, $sql);
      if($result)
        {
        	$row = mysqli_fetch_assoc($result);
 		$mgsDetails = $row["BreedCode_2_ch"];
 		$MGS = $row["bull_no"];
        }
        // the cow's MGS and the sire = NRF
        if($mgsDetails =='NR')
   {

         $query="SELECT * FROM `bulls_details` WHERE sire='$MGS'";
         $result = mysqli_query($db, $query);
         $MGSRow = mysqli_fetch_assoc($result); 

      $query="UPDATE  local_cows AS lc,  `herdbook nor` AS hn
      SET lc.brd_milk_kg = ".$sireRow['milk_kg']."*0.67+".$MGSRow['milk_kg']."*0.33 , 
      lc.brd_fat_pre=".$sireRow['fat_pct']."*0.67+".$MGSRow['fat_pct']."*0.33 ,
      lc.brd_prot_pre=".$sireRow['prot_pct']."*0.67+".$MGSRow['prot_pct']."*0.33 ,
      lc.brd_dau_fertilty=".$sireRow['fert_indx']."*0.67+".$MGSRow['fert_indx']."*0.33 ,
      lc.brd_SCC=".$sireRow['mast_indx']."*0.67+".$MGSRow['mast_indx']."*0.33,
      lc.brd_dau_fertilty=".$sireRow['caease_m']."*0.67+".$MGSRow['caease_m']."*0.33
      WHERE cow_no='$currentCow' AND lc.User_Id='$username' and lc.Farm='".$_POST["farmName"]."';";
      $result = mysqli_query($db, $query);
              if($result)
        {
        echo "<br>succeed";
        }
        else
        {
         echo "<br>no!!!succeed";
        }
   }
  
   //only the sire are NRF
else

   {
      $query="UPDATE  local_cows AS lc
      SET lc.brd_milk_kg= ".$sireRow['milk_kg'].", 
      lc.brd_fat_pre= ".$sireRow['fat_pct'].",
      lc.brd_prot_pre= ".$sireRow['prot_pct'].",
      lc.brd_dau_fertilty= ".$sireRow['fert_indx'].",
      lc.brd_SCC= ".$sireRow['mast_indx'].",
      lc.brd_dau_fertilty=".$sireRow['caease_m']."
      WHERE cow_no='$currentCow' AND cl.User_Id='$username' and lc.Farm='".$_POST["farmName"]."';";
      $result = mysqli_query($db, $query);
         if($result)
        {
        echo "<br>succeed";
        }
        else
        {
         echo "<br>no succeed";
        }
   } 
    
}
?>