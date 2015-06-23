<?php
include 'functions.php';
include 'home.html';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
$username=$_COOKIE["user"];
}
/*
$target_path ='namme.csv';
$sql = "SELECT * FROM `file_audit` WHERE FileName ='$target_path' ";
$result = mysqli_query($db,$sql);
if($result)
     {
                $returnMsg = " ";
        	$row = mysqli_fetch_assoc($result);
        	$returnMsg = $row["FileName"];
 		echo "<br> the result is".$returnMsg ;
        }

/**************************************
(@name,@family,@age,@no) set name=@family,family=@name,number=@no,age=@age
$target_path ='uploads/users_details (2).csv';
$query ="LOAD DATA LOCAL INFILE '$target_path'
REPLACE INTO TABLE users_details
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\\r\\n'
IGNORE 1 LINES
(User_Name,Password,User_type,User_E_Mail,User_Address,Date_joined,Farm,User_First_Name,User_Last_Name,Language,Farm_location,Country,Last_Location,Distrbuter_User_Id,Genetic_protocol,TNC_accepted,Folder_name,User_No)";
  $result = mysqli_query($db,$query);      
        If ($result)
        {
        echo "thanksssssss succeed!!!!!!!!!<br>";
        $numrpt = mysqli_num_rows($result); 
        }
     else
      {
      echo"...you are not succeed .....-:(<br><br><br>";
      }
if(file_exists($target_path)){
 echo"the file exist";   
}
 else
{
echo"the file not exist"; 
}
    if (!mysqli_query()) {
        printf("<br>Erreur : %s\n", mysqli_error($db));
    }
    mysqli_free_result($result);
/**************************************
$username=$_COOKIE["user"];

$target_path ='uploads/cows_noa.csv';
$sql="truncate local_cows";
$result = mysqli_query($db,$sql);

$query ="LOAD DATA LOCAL INFILE '$target_path'
REPLACE INTO TABLE local_cows
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\\r\\n'
IGNORE 1 LINES
(last_milk_per_day,AI_bull_ISR_number,last_SCC,AI_type,not_for_AI,exp_Calving_date,now_at_milk,preg,lact_no,match_status,barach,groupe,group_name,cull_date,enter_way,breed,MGS,sex,cow_name,tag_color,no_tag_plasic,no_tag,burn_no,government_no,sire,Live_sire,computer_no,cow_no,computer_mom,avg_milk_last_10_days,avg_milkig_time_in_last_10_days,brd_milk_kg,brd_fat_kg,brd_prot_kg,brd_fat_pre,brd_prot_pre,brd_SCC,brd_ECM,brd_udder,brd_Teats_placement,brd_legs,
brd_milk_mom,brd_fat_kg_mom,brd_prot_mom,brd_fat_pre_mom,brd_prot_pre_mom,brd_SCC_mom,brd_ecm_mom,
brd_tpi_mom,brd_udder_mom,brd_legs_mom,brd_milk_sire,brd_fat_kg_sire,brd_prot_kg_sire,brd_fat_pre_sire,brd_prot_pre_sire,brd_SCC_sire,brd_ecm_sire,brd_tpi_sire,brd_udder_sire,brd_legs_sire,brd_dau_fertilty,brd_still_birth,brd_calvig_easy,
BirthDate,exit_way,exit_reason,exiy_weight,price_per_kg,exit_price,bayer,calving_date,dry_date,last_dhi_date,no_dhi_after_calving,pl_milk_kg,last_AI_date,pl_Fat_kg,pl_prot_kg,pl_laktuz_miz,adjust_milk_kg,adjust_fat_kg,adjust_prot_kg,mom_no,mom_name,DIM,days_in_preg,bayer_name,bayer_farm_name,days_after_AI,days_till_next_calving,days_till_dry,enter_whight,wining_wheight,growth_rate,growth_rate_total,days_after_dry,BCS_date_after_calvig,total_wight,BCS_pick_milk_date,BCS_pick_milk,BCS_dry_date,BCS_dry,BCS_half_dry_date,BCS_half_dry,avg_milk,avg_ecm,wested_days_AI,
open_days,rest_days,SCC_calc1,ECM_total_at_lact,ecm_according_the_heard,no_of_milking_by_day,last_DHI_date2,last_heating_date,last_abortion,adjust_ecm,edjust_ecm_prev_lact,adjust_prot_kg_prev_lact,adjust_milk_prev_lact,adjust_fat_kg_prev_lact,DIM_prev_lact,mate_1,inseminator_name,highet,exp_milk_kg_305,exp_fat_kg_305,exp_ecm_305,exp_prot_kg,match_bull,exp_exm_305,age_by_month,adjust_ecm2,feed_lot,days_till_dry2,rep,AI_time,fat_pre_DHI,prot_pre_DHI,supply,pl_prot_pre,efect_preg_date,pl_milk,highet_date,last_calving_days_in_dry,for_cull,pl_fat_pre,preg2,PGS,date_molk_day,last_calvig_date,fatprot,last_milk1,unknown,last_whight,last_wheight_date,enter_date,enter_last_date,days_in_last_group,unknown2,last_se,birth_month,whight1,whight2,whight3,whight4,whight5,whight6,whight7,whight8,whight_rate1,whight_rate2,whight_rate3,whight_rate4,whight_rate5,whight_rate6,whight_rate7,whight_rate8,whight_date1,whight_date2,whight_date3,whight_date4,whight_date5,whight_date6,whight_date7,whight_date8,date_pick_milk,kg_at_pick,bying_price,unknown3,last_vet,last_vet_diagnosis,sorting,vac_date,vac_drug,last_gov_no,age_in_1_lact,persistence_1,persistence_1_2,no_live_bull,live_bulld_fate,colestrom_value1,colestrom_value2,refractometers_value,remark)";
  $result = mysqli_query($db,$query);      
        If ($result)
        {
        echo "thanksssssss succeed!!!!!!!!!<br>";
        $numrpt = mysqli_num_rows($result); 
        }
     else
      {
      echo"...you are not succeed .....-:(<br><br><br>";
      }
if(file_exists($target_path)){
 echo"the file exist ";

 $farm=getUserFarm($db,$username);
 echo"the file exist  $farm";
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

echo"the file not exist ";
 
}

*/
CommonFeatures4Points($db);
function CommonFeatures4Points($db)
{      

         $query="SELECT * FROM `local_cows`";
         $result = mysqli_query($db, $query);
         $result_list = array();
         while($row = mysqli_fetch_array($result)) {
         $result_list[] = $row;
         
}
   foreach($result_list as $row) {
     $currentCow=$row['cow_no'];
     $currentSire=$row['sire'];
     $currentMGS=$row['MGS'];
     

     $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_milk_kg =c.brd_milk_kg/s.STV*4 +100 WHERE s.Traits='milk[kg]' AND (
(c.brd_milk_kg/s.STV*4 +100)>60 OR (c.brd_milk_kg/s.STV*4 +100)<160)AND c.cow_no='$currentCow' ;";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(milk)");
    }
   
  else{echo "<br>the rusult num rows is".$result_num;}
       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
    SET c.brd_fat_pre=c.brd_fat_pre/s.STV*4 +100 WHERE s.Traits='fat_percentage' AND (
(c.brd_fat_pre/s.STV*4 +100)>60 OR (c.brd_fat_pre/s.STV*4 +100)<160) AND c.cow_no='$currentCow';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(fat pre)");
    } 
   else{echo "<br>the rusult num rows is".$result_num;}
       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_prot_pre=c.brd_prot_pre/s.STV*4 +100 WHERE s.Traits='protein_percentage'  AND
((c.brd_prot_pre/s.STV*4 +100)>60 AND (c.brd_prot_pre/s.STV*4 +100)<160) AND c.cow_no='$currentCow';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(protein pre)");
    }
else{echo "<br>the rusult num rows is".$result_num;}
       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_dau_fertilty=c.brd_dau_fertilty/s.STV*4 +100 WHERE s.Traits='fertility' AND
((c.brd_dau_fertilty/s.STV*4 +100)>60 AND (c.brd_dau_fertilty/s.STV*4 +100)<160)AND c.cow_no='$currentCow';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(fertility)");
    }
    else{echo "<br>the rusult num rows is".$result_num;}


       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_SCC=c.brd_SCC/s.STV*4 +100 WHERE s.Traits='SCC'  AND
((c.brd_SCC/s.STV*4 +100)>60 AND (c.brd_SCC/s.STV*4 +100)<160)AND c.cow_no='$currentCow';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(SCC)");
    }
else{echo "<br>the result num rows is".$result_num;}

       $query="UPDATE  local_cows AS c,  `STV_per_traits_per_base` AS s
SET c.brd_Ramp_stucture=c.brd_Ramp_stucture/s.STV*4 +100 WHERE s.Traits='MCE'  AND
((c.brd_Ramp_stucture/s.STV*4 +100)>60 AND (c.brd_Ramp_stucture/s.STV*4 +100)<160)AND c.cow_no='$currentCow';";
   $result = mysqli_query($db, $query); 
   $result_num=mysqli_affected_rows($db);
    if($result_num==0)
    {
      exit("alert!!! you can't continue ask expert!!!!(MCE)");
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

         $query="SELECT * FROM `herdbook nor` WHERE sire='$MGS'";
         $result = mysqli_query($db, $query);
         $MGSRow = mysqli_fetch_assoc($result); 

      $query="UPDATE  local_cows AS lc,  `herdbook nor` AS hn
      SET lc.brd_milk_kg = ".$sireRow['milk_kg']."*0.67+".$MGSRow['milk_kg']."*0.33 , 
      lc.brd_fat_pre=".$sireRow['fat_pct']."*0.67+".$MGSRow['fat_pct']."*0.33 ,
      lc.brd_prot_pre=".$sireRow['prot_pct']."*0.67+".$MGSRow['prot_pct']."*0.33 ,
      lc.brd_dau_fertilty=".$sireRow['fert_indx']."*0.67+".$MGSRow['fert_indx']."*0.33 ,
      lc.brd_SCC=".$sireRow['mast_indx']."*0.67+".$MGSRow['mast_indx']."*0.33,
      lc.brd_dau_fertilty=".$sireRow['caease_m']."*0.67+".$MGSRow['caease_m']."*0.33
      WHERE cow_no='$currentCow';";
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
      WHERE cow_no='$currentCow';";
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

/* to upload Noa file
lc.brd_Ramp_stucture=".$sireRow['']."*0.67+".$MGSRow['']."*0.33 ,
lc.brd_Ramp_stucture=".$sireRow[''].",
$username=$_COOKIE["user"];

$target_path ='uploads/Noa.csv';
$sql="truncate local_cows";
$result = mysqli_query($db,$sql);

$query ="LOAD DATA LOCAL INFILE '$target_path'
REPLACE INTO TABLE local_cows
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\\r\\n'
IGNORE 1 LINES
(last_milk_per_day,AI_bull_ISR_number,last_SCC,AI_type,not_for_AI,exp_Calving_date,now_at_milk,preg,lact_no,match_status,barach,groupe,group_name,enter_way,breed,MGS,sex,cow_name,tag_color,no_tag,burn_no,government_no,sire,Live_sire,computer_no,cow_no,computer_mom,avg_milk_last_10_days,avg_milkig_time_in_last_10_days,brd_milk_kg,brd_fat_kg,brd_prot_kg,brd_fat_pre,brd_prot_pre,brd_SCC,brd_ECM,brd_udder,brd_legs,
brd_milk_mom,brd_fat_kg_mom,brd_prot_mom,brd_fat_pre_mom,brd_prot_pre_mom,brd_SCC_mom,brd_ecm_mom,
brd_tpi_mom,brd_udder_mom,brd_legs_mom,brd_milk_sire,brd_fat_kg_sire,brd_prot_kg_sire,brd_fat_pre_sire,brd_prot_pre_sire,brd_SCC_sire,brd_ecm_sire,brd_tpi_sire,brd_udder_sire,brd_legs_sire,DIM,days_in_preg,bayer_name,bayer_farm_name,days_after_AI,days_till_dry,enter_whight,wining_wheight,growth_rate,growth_rate_total,days_after_dry,BCS_date_after_calvig,total_wight,BCS_pick_milk_date,BCS_pick_milk,BCS_dry_date,BCS_dry,BCS_half_dry_date,BCS_half_dry,avg_milk,avg_ecm,wested_days_AI,
open_days,rest_days,SCC_calc1,ECM_total_at_lact,ecm_according_the_heard,no_of_milking_by_day,last_DHI_date2,last_heating_date,last_abortion,adjust_ecm,edjust_ecm_prev_lact,adjust_prot_kg_prev_lact,adjust_milk_prev_lact,adjust_fat_kg_prev_lact,DIM_prev_lact,mate_1,inseminator_name,highet,exp_milk_kg_305,exp_fat_kg_305,exp_ecm_305,exp_prot_kg,match_bull,exp_exm_305,age_by_month,adjust_ecm2,feed_lot,days_till_dry2,rep,AI_time,fat_pre_DHI,prot_pre_DHI,supply,pl_prot_pre,efect_preg_date,pl_milk,highet_date,last_calving_days_in_dry,for_cull,pl_fat_pre,preg2,PGS,date_molk_day,last_calvig_date,fatprot,last_milk1,unknown,last_whight,last_wheight_date,enter_date,enter_last_date,days_in_last_group,unknown2,last_se,birth_month,whight1,whight2,whight3,whight4,whight5,whight6,whight7,whight8,whight_rate1,whight_rate2,whight_rate3,whight_rate4,whight_rate5,whight_rate6,whight_rate7,whight_rate8,whight_date1,whight_date2,whight_date3,whight_date4,whight_date5,whight_date6,whight_date7,whight_date8,date_pick_milk,kg_at_pick,bying_price,unknown3,last_vet,last_vet_diagnosis,sorting,vac_date,vac_drug,last_gov_no,persistence_1,persistence_1_2,no_live_bull,live_bulld_fate,colestrom_value1,colestrom_value2,refractometers_value,remark)";
  $result = mysqli_query($db,$query);      
        If ($result)
        {
        echo "thanksssssss succeed!!!!!!!!!<br>";
        $numrpt = mysqli_num_rows($result); 
        }
     else
      {
      echo"...you are not succeed .....-:(<br><br><br>";
      }
if(file_exists($target_path)){
 echo"the file exist ";

 $farm=getUserFarm($db,$username);
 echo"the file exist  $farm";
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

echo"the file not exist ";
 
}
*/
/*
//to upload Noa2 file
$username=$_COOKIE["user"];

$target_path ='uploads/Noa2.csv';
$sql="truncate local_cows";
$result = mysqli_query($db,$sql);

$query ="LOAD DATA LOCAL INFILE '$target_path'
REPLACE INTO TABLE local_cows
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\\r\\n'
IGNORE 1 LINES
(match_status,breed,MGS,sex,sire,cow_no,brd_milk_kg,brd_fat_pre,brd_SCC)";
  $result = mysqli_query($db,$query);      
        If ($result)
        {
        echo "thanksssssss succeed!!!!!!!!!<br>";
        $numrpt = mysqli_num_rows($result); 
        }
     else
      {
      echo"...you are not succeed .....-:(<br><br><br>";
      }
if(file_exists($target_path)){
 echo"the file exist ";

 $farm=getUserFarm($db,$username);
 echo"the file exist  $farm";
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

echo"the file not exist ";
 
}
*//*
//to upload Noa file
$username=$_COOKIE["user"];

$target_path ='uploads/Noa.csv';
$sql="truncate local_cows";
$result = mysqli_query($db,$sql);

$query ="LOAD DATA LOCAL INFILE '$target_path'
REPLACE INTO TABLE local_cows
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\\r\\n'
IGNORE 1 LINES
(last_milk_per_day,AI_bull_ISR_number,last_SCC,AI_type,not_for_AI,exp_Calving_date,now_at_milk,preg,lact_no,	match_status,barach,groupe,group_name,cull_date,enter_way,breed,MGS,sex,cow_name	,tag_color,no_tag,burn_no,government_no,		sire,Live_sire,computer_no,cow_no,computer_mom,avg_milk_last_10_days,avg_milkig_time_in_last_10_days,brd_milk_kg	,brd_fat_kg,brd_prot_kg,brd_fat_pre,brd_prot_pre,brd_SCC,brd_ECM,brd_udder,brd_legs,brd_milk_mom,brd_fat_kg_mom,	brd_prot_mom,	brd_fat_pre_mom,brd_prot_pre_mom,brd_SCC_mom,brd_ecm_mom,brd_tpi_mom,brd_udder_mom,brd_legs_mom,	brd_milk_sire,brd_fat_kg_sire,	brd_prot_kg_sire,brd_fat_pre_sire,brd_prot_pre_sire,brd_SCC_sire,brd_ecm_sire,brd_tpi_sire,brd_udder_sire,brd_legs_sire,	brd_dau_fertilty,brd_still_birth,brd_calvig_easy,TPI,BirthDate,exit_way,exit_reason,exiy_weight,price_per_kg,exit_price,	bayer,	calving_date,dry_date,last_dhi_date,no_dhi_after_calving,pl_milk_kg,last_AI_date	,pl_Fat_kg,pl_prot_kg,pl_laktuz_miz,	adjust_milk_kg,adjust_fat_kg,adjust_prot_kg,mom_no,mom_name,DIM,days_in_preg,bayer_name,bayer_farm_name,days_after_AI,	days_till_next_calving,days_till_dry,enter_whight,wining_wheight,growth_rate,growth_rate_total,days_after_dry,	BCS_date_after_calvig,total_wight,BCS_pick_milk_date,BCS_pick_milk,BCS_dry_date,BCS_dry,BCS_half_dry_date,	BCS_half_dry,avg_milk,avg_ecm,wested_days_AI,open_days,rest_days,SCC_calc1,ECM_total_at_lact,ecm_according_the_heard,	no_of_milking_by_day,last_DHI_date2,last_heating_date,last_abortion,adjust_ecm,edjust_ecm_prev_lact,adjust_prot_kg_prev_lact,	adjust_milk_prev_lact,adjust_fat_kg_prev_lact,DIM_prev_lact,mate_1,inseminator_name,highet,exp_milk_kg_305,exp_fat_kg_305,	exp_ecm_305,exp_prot_kg,match_bull,exp_exm_305,age_by_month,adjust_ecm2,feed_lot,days_till_dry2,rep,AI_time,fat_pre_DHI,	prot_pre_DHI,supply,pl_prot_pre,efect_preg_date,pl_milk,highet_date,last_calving_days_in_dry,for_cull,pl_fat_pre,preg2,PGS,	date_molk_day,last_calvig_date,fatprot,last_milk1,unknown,last_whight,last_wheight_date,enter_date,enter_last_date,	days_in_last_group,unknown2,last_se,birth_month,whight1,whight2,whight3,whight4,whight5,whight6,whight7,whight8,whight_rate1	,whight_rate2,whight_rate3,	whight_rate4,whight_rate5,whight_rate6,whight_rate7,whight_rate8,whight_date1,whight_date2,whight_date3,	whight_date4,	whight_date5,whight_date6,whight_date7,whight_date8,date_pick_milk,kg_at_pick,bying_price,	unknown3,last_vet,last_vet_diagnosis,sorting,vac_date,vac_drug,last_gov_no,age_in_1_lact,	persistence_1,persistence_1_2,no_live_bull,live_bulld_fate,colestrom_value1,colestrom_value2,refractometers_value,remark	)";
  $result = mysqli_query($db,$query);      
        If ($result)
        {
        echo "thanksssssss succeed!!!!!!!!!<br>";
        $numrpt = mysqli_num_rows($result); 
        }
     else
      {
      echo"...you are not succeed .....-:(<br><br><br>";
      }
if(file_exists($target_path)){
 echo"the file exist ";

 $farm=getUserFarm($db,$username);
 echo"the file exist  $farm";
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

echo"the file not exist ";
 
}*/


?>																																																																			