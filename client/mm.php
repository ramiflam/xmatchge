<?php
include "navigationBar.php";
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
/*
$browserLanguage='en';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}*/
$username=$_COOKIE["user"];
$gnMagicNumber = 50; // this is fake value need to get real one from tipuchit - not in the code
$gnBullsInseminationTotal = 0; // need to update the value taken as sum of ActualInseminationsfrom bulls table for foreign bulls (see fileio.bas)
$gnBullsInseminationYoungBulls = 0;  // need to update the value taken as sum of ActualInseminationsfrom bulls table for young bulls (see fileio.bas)
$gnBullsInseminationMeatBulls = 0; // need to update the value taken as sum of ActualInseminationsfrom bulls table for meat bulls (see fileio.bas)
$gnBullsInseminationOtherBulls = 0; // need to update the value taken as sum of ActualInseminationsfrom bulls table for other bulls (see fileio.bas)

  //to get Bull Row
   $query="SELECT * FROM `bulls_details` WHERE bull_no='589'";
   $result = mysqli_query($db, $query);
   If ($result ->num_rows > 0)  
   {
   $bullRow = mysqli_fetch_assoc($result);
   }
 //  echo "<br>the bull row sire its".$bullRow['sire'];
   
     //to get Cow Row
   $query="SELECT * FROM `local_cows` WHERE cow_no='cow_no'";
   $result = mysqli_query($db, $query);
   If ($result ->num_rows > 0)  
   {
   $cowRow = mysqli_fetch_assoc($result);
   }
      	
	
function getCow($db,$cowList)
{
foreach ($_GET as $cow_no )
 {
   $query="SELECT * FROM `local_cows` WHERE cow_no='$cow_no'";
   $result = mysqli_query($db, $query);
   If ($result ->num_rows > 0)  
   {
   $cowRow = mysqli_fetch_assoc($result);
   
   }
  echo " the cow is.<br>".$cow_no;
 }
}
$getSireBreed=getSireBreed($db, $cowRow);
function getSireBreed($db, $cowRow)
{ 
  // return breed of cow sire (father)
 $bullQuery = "SELECT Breed FROM `bulls_details` WHERE bull_no=".$cowRow['sire'].";" ;
  $bullResult = mysqli_query($db, $bullQuery);
  If ($bullResult ->num_rows > 0)    {
        $bullRow = mysqli_fetch_assoc($bullResult );
        return $bullRow['Breed'];
  }
  else  {
      return "-89";
  }
} 
echo "<br>the sire breed is".$getSireBreed;
echo "the user name is".$username;
$getMGSBreed=getMGSBreed($db, $cowRow);
function getMGSBreed($db, $cowRow)
{
  // return breed of cow MGS (Maternal grand father)
  $bullQuery = "SELECT Breed FROM `bulls_details` WHERE bull_no=".$cowRow['MGS'].";" ;
  $bullResult = mysqli_query($db, $bullQuery);
  If ($bullResult ->num_rows > 0)    {
        $bullRow = mysqli_fetch_assoc($bullResult );
        return $bullRow['Breed'];
  }
  else  {
      return "-98";
  }
} // getMGSBreed
echo "<br>the MGS breed is".$getMGSBreed;

$CheckSensitivity=bgfCheckSensitivity ($db, $vrsCurrentCow, $bullRow,$username);
function bgfCheckSensitivity ($db, $vrsCurrentCow, $bullRow,$username)    
{
        $vrsCurrentBull='589';
        $vrsCurrentCow='1011';
     
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow';" ;     
        $cowResult = mysqli_query($db, $cowQuery );
       If ($cowResult ->num_rows > 0)    {
        	$cowRow = mysqli_fetch_assoc($cowResult );
        	echo"select cows succed<br>";
        }
        else  {
        	return false;
        }
       
        $tekenQuery = "SELECT * FROM `tblTeken` where RecordType='1';" ;     
        $tekenResult = mysqli_query($db, $tekenQuery );
       // If ($tekenResult ->num_rows > 0)    {
       If ($tekenResult){
        	$tekenRow = mysqli_fetch_assoc($tekenResult );
        	echo"select teken succed<br>";
      }
        else  {
        	return -1;
        }
 /****
        If (($bullRow['Heifer_status'] == 0) and ($cowRow['brd_Ramp_stucture'] <  $tekenRow['TEKEN_AGAN2'])) {
	      	$nPelvis2 = 1;
	      	return false;
	      	}
	   	else {
	   	
	      	$nPelvis2 = 2;
  	}
****/
    	// rest of check happends if $nPelvis2 == 2(So I put it in a comment only to check)
   	$Query = "SELECT * FROM `user_settings` WHERE user_id='$username';" ;     
        $Result = mysqli_query($db, $Query);
        If ($Result)
        {
        	$settingsRow = mysqli_fetch_assoc($Result);
 		$returnMsg = $settingsRow["FarmName"];
        	}

        	 
      	If ($cowRow['brd_milk_kg'] == null)  {     	    
            $dKGMilk = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software 1(milk!!!)")';
            echo '</script>';
            }
      	 else {
            $dKGMilk = $cowRow['brd_milk_kg'];
            
         }     	
         if($settingsRow['Match_production_KGmilk']==1){
     	// next check is dependent in the VB code on frmMain.chkMatchProductionKGMilk.Value (if it was checked)
     	echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software 2(milk!!!)")';
            echo '</script>';
      	if ($dKGMilk <> 0) {
      	$dKGMilk = ($dKGMilk + $bullRow['KG_milk']) / 2;

      	}
      	else {
      	$dKGMilk =9999;
      	     }
      	}
      	
      	if ($cowRow['brd_dau_fertilty'] == null) {
      	$dFertility = 0;
      	    echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_dau_fertilty!!!)")';
            echo '</script>';
      	}
      	else {
      	$dFertility = $cowRow['brd_dau_fertilty'];
      	}
      	
      	 if($settingsRow['Match_production_fertility']==1){
      	// next check is dependent in original VB code on frmMain.chkMatchProductionFertility.Value  (if it is checked)
      	if ($dFertility <> 0) {
      	$dFertility = ($dFertility + $bullRow['Fertility']) / 2;
      	}
      	else {
      	$dFertility = 0;
      	}
      }	
      	If ($cowRow['brd_fat_pre'] == null) {
        $dFatPercentage = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_fat_pre!!!)")';
            echo '</script>';
        }
        else {
        $dFatPercentage = $cowRow['brd_fat_pre'];
        }
        
        if($settingsRow['Match_production_fat_per']==1){
        // next check is dependent in original VB code on frmMain.chkMatchProductionFatPercentage (that it is checked)
	if ($dFatPercentage  == 0) {
	$dFatPercentage = ($dFatPercentage + $bullRow['Fat_percentage']) / 2;
	}
	else {
	$dFatPercentage = 9999;
	     }
	}
	If ($cowRow['brd_prot_kg'] == null) {
        $dKGProtein = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_prot_kg!!!)")';
            echo '</script>';
        }
        else {
        $dKGProtein = $cowRow['brd_prot_kg'];
        }
        
 	if ($dKGProtein == 0) {
	$dKGProtein = ($dKGProtein + $bullRow['KG_protein']) / 2;
	}
	else {
	$dKGProtein = 9999;
	}
	If ($cowRow['brd_prot_pre'] == null) {
        $ProteinPercentage= 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_prot_pre!!!)")';
            echo '</script>';
        }
        else {
        $ProteinPercentage= $cowRow['brd_prot_pre'];
        }
        
        if($settingsRow['Match_production_protein_per']==1){
        // next check is dependent in original VB code on frmMain.chkMatchProductionProteinPercentage.Value  (if it is checked)
 	if ($ProteinPercentage== 0) {
	$ProteinPercentage= ($ProteinPercentage+ $bullRow['Protein_percentage']) / 2;
	}
	else {
	$ProteinPercentage = 9999;
	     }
	}
	If ($cowRow['brd_SCC'] == null) {
        $dSCC = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_SCC!!!)")';
            echo '</script>';
        }
        else {
        $dSCC = $cowRow['brd_SCC'];
        }
        
        if($settingsRow['Match_production_SCC']==1){
        // next check is dependent in original VB code on frmMain.chkMatchProductionSCC.Value (if it is checked)
 	if ($dSCC == 0) {
	$dSCC = ($dSCC + $bullRow['SCC']) / 2;
	}
	else {
	$dSCC = 9999;
	     }
	}
	
	If ($cowRow['brd_general_size'] == null) {
        $dGeneralSize = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_general_size!!!)")';
            echo '</script>';
        }
        else {
        $dGeneralSize = $cowRow['brd_general_size'];
        }
        
        if($settingsRow['Match_judgment_general_size']==1){
          // next check is dependent in original VB code on frmMain.chkMatchJudgmentGeneralSize.Value (if it is checked)
 	if ($dGeneralSize == 0) {
	$dGeneralSize = ($dGeneralSize + $bullRow['General_size']) / 2;
	}
	else {
	$dGeneralSize = 9999;
	     }
	}

	If ($cowRow['brd_udder'] ==null ) {
        $dGeneralUdder = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_udder!!!)")';
            echo '</script>';
        }
        else {
        $dGeneralUdder = $cowRow['brd_udder'];
        }
        
        if($settingsRow['Match_judgment_general_udder']==1){
        // next check is dependent in original VB code on frmMain.chkMatchJudgmentGeneralUdder.Value (if it is checked)
 	if ($dGeneralUdder == 0) {
	$dGeneralUdder = ($dGeneralUdder + $bullRow['General_udder']) / 2;
	}
	else {
	$dGeneralUdder = 9999;
	     }
        }
	If ($cowRow['brd_Teats_placement'] == null) {
        $dNippleLocation = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_Teats_placement!!!)")';
            echo '</script>';
        }
        else {
        $dNippleLocation = $cowRow['brd_Teats_placement'];
        }
        
        if($settingsRow['Match_judgment_teats_location']==1){
        // next check is dependent in original VB code on frmMain.chkMatchJudgmentNippleLocation.Value (if it is checked)
 	if ($dNippleLocation == 0) {
	$dNippleLocation = ($dNippleLocation + $bullRow['Teats_location']) / 2;
	}
	else {
	$dNippleLocation = 9999;
	     }
	}
	If ($cowRow['brd_Udder_depth'] == null) {
        $dUdderDepth = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_Udder_depth!!!)")';
            echo '</script>';
        }
        else {
        $dUdderDepth = $cowRow['brd_Udder_depth'];
        }
        
        if($settingsRow['Match_judgment_udder_depth']==1){
        // next check is dependent in original VB code on frmMain.chkMatchJudgmentUdderDepth.Value (if it is checked)
 	if ($dUdderDepth == 0) {
	$dUdderDepth = ($dUdderDepth + $bullRow['Udder_depth']) / 2;
	}
	else {
	$dUdderDepth = 9999;
	     }
	}
	If ($cowRow['brd_legs'] == null) {
        $dGeneralLegs = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_Udder_depth!!!)")';
            echo '</script>';
        }
        else {
        $dGeneralLegs = $cowRow['brd_legs'];
        }
        
        if($settingsRow['Match_judgment_general_legs']==1){
        // next check is dependent in original VB code on frmMain.chkMatchJudgmentGeneralLegs.Value (if it is checked)
 	if ($dGeneralLegs == 0) {
	$dGeneralLegs = ($dGeneralLegs + $bullRow['General_legs']) / 2;
	}
	else {
	$dGeneralLegs = 9999;
	     }
	}
	If ($cowRow['brd_Overrall_grade'] == null) {
        $dOverallGrade = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_Overrall_grade!!!)")';
            echo '</script>';
        }
        else {
        $dOverallGrade = $cowRow['brd_Overrall_grade'];
        }
        
        if($settingsRow['Match_judgment_general_legs']==1){
        // next check is dependent in original VB code on frmMain.chkMatchJudgmentGeneralLegs.Value (if it is checked)
 	if ($dOverallGrade == 0) {
	$dOverallGrade = ($dOverallGrade + $bullRow['Overall_grade']) / 2;
	}
	else {
	$dOverallGrade = 9999;
	     }
	}
	If ($cowRow['brd_Ramp_stucture'] == null) {
        $dPelvisStructure = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_Ramp_stucture!!!)")';
            echo '</script>';
        }
        else {
        $dPelvisStructure = $cowRow['brd_Ramp_stucture'];
        }
        
        if($settingsRow['Match_judgment_pelvis_stucture']==1){
       // next check is dependent in original VB code on frmMain.chkMatchJudgmentPelvisStructure.Value (if it is checked)
 	if ($dPelvisStructure == 0) {
	$dPelvisStructure = ($dPelvisStructure + $bullRow['Pelvis_stucture']) / 2;
	}
	else {
	$dPelvisStructure = 9999;
	 	}
         }
	// Now comes a long condition to decide if sensitivity is true or not
	if ( ($dKGMilk >= ($tekenRow['TEKEN_MILK'] * $tekenRow['HIGH_SENS'])) and 
	     ($dFertility >= ($tekenRow['TEKEN_FAT'] * $tekenRow['HIGH_SENS'])) and 
	     ($dFatPercentage >= ($tekenRow['TEKEN_FATP'] * $tekenRow['HIGH_SENS'])) and 
	     ($dKGProtein >= ($tekenRow['TEKEN_PRT'] * $tekenRow['HIGH_SENS'])) and
	     ($dProteinPercentage >= ($tekenRow['TEKEN_PRTP'] * $tekenRow['HIGH_SENS'])) and
	     ($dSCC >= ($tekenRow['TEKEN_SCC'] * $tekenRow['LOW_SENS'])) and
	     ($dGeneralSize >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dGeneralUdder >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dNippleLocation >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dUdderDepth >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dGeneralLegs >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dOverallGrade >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dPelvisStructure >= $tekenRow['TEKEN_AGAN'] )
	)  {
	return true;  // return true for check sensitivity
	}
	else {
	return false;
	}

}  // bgfCheckSensitivity 
echo "<br>THE RESULT IS".$CheckSensitivity;
 $breed=getBullBreedPerProgram($db, $cowRow, $programNo);
 function getBullBreedPerProgram($db, $cowRow, $programNo)
{
   $breedType = "";
    // get sire breed from bulls and MGS breed from bulls
   // $sireBreed = getSireBreed($db, $cowRow);
    $MGSBreed = getMGSBreed($db, $cowRow);
           $sireBreed='HO'; 
           
    if ($programNo == 1) {
          // program is pur holstein
          $breedType='HO'; 
    }
    else if ($programNo == 2) {
       // plan is two plus
       if ($sireBreed == 'HO') {
         $breedType='NR';
       }
       if ($sireBreed  == 'NR') {
         $breedType='HO';
       }
     } // two plus
     
 else if ($programNo == 3) {
       // plan is two plus extra
       if ($sireBreed  == 'HO') {
         $breedType='NR';
       }
       else if ($sireBreed  == 'NR') {
         if ($MGSBreed == 'NR'){
           $breedType='HO';
           }
         else if ($MGSBreed == 'HO')
          { $breedType='NR';
         }
       }
       } // two plus extra  
       
       return  $breedType;
} // getBullBreedPerProgram
//echo "<br>the bull breed type per program".$breed;
$check=bgfCheckForConsanguinity($db, 1011, $bullRow);
function bgfCheckForConsanguinity($db, $vrsCurrentCow, $bullRow)    
{
        
	// No need to read bull record - it is passed as parameter
        /***
        $bullQuery = "SELECT * FROM `bulls_details` WHERE bull_no='$vrsCurrentBull';" ;     
        $bullResult = mysqli_query($db, $bullQuery);
        If ($bullResult ->num_rows > 0)    {
        	$bullRow = mysqli_fetch_assoc($bullResult );
        }
        else  {
        	return -1;
        }
        ***/
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow';" ;     
        $cowResult = mysqli_query($db, $cowQuery );
        If ($cowResult ->num_rows > 0)    {
        	$cowRow = mysqli_fetch_assoc($cowResult );
        }
        else  {
        	return -1;
        }
        // check if accumulated CVM values are more then 1
        $cowParam = $cowRow['Genetic_defect'];
        if ($cowParam > 1) {
        $cowParam = 1;
        }
	$bullParam= $bullRow['CVM'];
	if (($bullParam + $cowParam) > 1) {
	return 1;
	}
		
	// check parents
	$cowParam = $cowRow['sire']; 
	$bullParam= $bullRow['sire'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	// check cow grandfathers vs bull father
	$cowParam = $cowRow['PGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	$cowParam = $cowRow['MGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	$cowParam = $cowRow['sire']; 
	$bullParam= $bullRow['sire'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	$cowParam = $cowRow['PGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	$cowParam = $cowRow['MGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	$cowParam = $cowRow['sire']; 
	$bullParam= $bullRow['PGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}

	$cowParam = $cowRow['PGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}

	$cowParam = $cowRow['MGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	$cowParam = $cowRow['sire']; 
	$bullParam= $bullRow['MGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	$cowParam = $cowRow['PGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}

	$cowParam = $cowRow['MGS'];
	if ($bullParam == $cowParam) {
	return 1;
	}
	
	// if arrived here then there is no blood relation - return 0 for false
	return 0;
}
// bgfCheckForConsanguinity
//echo "hi the  check for consanguinity".$check;

$MatchDailyActivitiesBulls=gsMatchDailyActivitiesBulls($db, 1011, $username);
function gsMatchDailyActivitiesBulls($db, $vrsCurrentCow, $userId)
{

	$bullsList = array("");
	$bullsCount = 0;
	$bBullsFound = false;
	$T=0;
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow';" ;     
        $cowResult = mysqli_query($db, $cowQuery );
        If ($cowResult ->num_rows > 0)    {
        	$cowRow = mysqli_fetch_assoc($cowResult );
        	echo" <br>how are you select local cows";
        }
        else  {
        echo" <br>how are you noooooo select local cows";
        	return $bullsList;
        	
        }
        
        $userSettingsQuery = "SELECT * FROM `user_settings` WHERE user_id='$userId';" ;     
        $userSettingsResult = mysqli_query($db, $userSettingsQuery);
        If ($userSettingsResult->num_rows > 0)    {
        	$userSettingsRow = mysqli_fetch_assoc($userSettingsResult);
        	echo" <br>how are you select user settings";
        }
        else  {
        	return $bullsList;echo" <br>how are you select nooooo user setting";
        }
        
        $bBullsFound = False;
        $bullsCount = 0;
        
       // calculate total working cows
        $query = "SELECT * FROM `local_cows` WHERE brd_kg_ecm Is Not Null AND match_status=1;" ;     
        $totalCowResult = mysqli_query($db, $query );
        If ($totalCowResult->num_rows > 0)    {
        	$nTotalWorkingCows = $totalCowResult->num_rows;echo" <br>how are you select brd_kg_ecm cows";
        }
        else {
        $nTotalWorkingCows = 0;echo"<br>how are you select noooooooooo brd_kg_ecm cows";
        }
        // if no working cows then return empty list
        if ($nTotalWorkingCows == 0) {
        return $bullsList;
        }
        
       // continue if there are working cows
        
        // get nTotalWorkingCowsLactationAboveMeatBulls from db
        $cboLactationNumber = $userSettingsRow['Meat_bulls_lactation_no'];
        $query= "SELECT * FROM `local_cows` WHERE brd_kg_ecm Is Not Null AND match_status=1 AND lact_no>= '$cboLactationNumber';"; 
        $result = mysqli_query($db, $query );
        $nTotalWorkingCowsLactationAboveMeatBulls = $result->num_rows;
            echo" <br>how are you select 22222 brd_kg_ecm cows";
       if ($nTotalWorkingCowsLactationAboveMeatBulls == $nTotalWorkingCows) {
        // in original VB - close the query looks like no other action
        }
        
        if (($userSettingsRow['Bulls_usage_meat_bulls'] > 0) and 
             ($nTotalWorkingCowsLactationAboveMeatBulls > 0) and
             ($cowRow['lact_no'] >= $userSettingsRow['Meat_bulls_lactation_no'])) {
             echo" <br>how are you select bull usage meat bulls";
             $dParameter1 = 100 - $userSettingsRow['Bulls_usage_meat_bulls'];
             $dParameter1 = 0.01 * ($dParameter1 * $nTotalWorkingCowsLactationAboveMeatBulls);
             If ($dParameter1 <= $cowRow['ECMRankForMatchedCows']) {
                  $bullsList[0] = "init string";    // check what is sgfGetINIString(gsLanguageFile, "BULLS", "48") stands for
             ;
              $bBullsFound = True;
             }

        
         if ($bBullsFound == false) {
         
         $dParameter1 = 100 - $gnMagicNumber;
         $dParameter1 = ($dParameter1 * $nTotalWorkingCows) / 100;
         //$youngbulls=youngbulls();
         
            // get bulls breed per breeding program and cows parent and grand parent
            $breedType= getBullBreedPerProgram($db, $cowRow, $userSettingsRow['program_plan_no']);
              echo "the breed type is ".$breedType;
            
            // Get bulls list from bulls table
           $bullsQuery = "SELECT * FROM `bulls_details`  WHERE Match_status=1 and Breed = '$breedType' ORDER BY Order_by_Fertility DESC,Usage_order ASC, Fertility DESC ;" ;     
            $bullsResult = mysqli_query($db, $bullsQuery);
            $bullsCount = $bullsResult->num_rows;
            while (($bullRow = mysqli_fetch_assoc($bullsResult)) and ($T < 3) ) {
        	$B = false;
        	if ($gnBullsInseminationTotal > 0) {
        	echo "<br>the select to bull insemination total  BH".$B;
                  $dActualUsagePercentage = ($bullRow['Actuall_inseminations'] / $dParameter2) * 100;
                  $B = ($dActualUsagePercentage < $bullRow['Planned_usage']);
               	} // (gnBullsInseminationTotal>0)

                if (false == $bullRow['Limited']) {
                   $B = true;
                }
               if (($gnBullsInseminationTotal == 0) or $B) {
               echo "<br>the select to bull insemination total shave BH".$B;
                   if (($bullRow['Planned_usage'] > 0) and ($bullRow['Match_status'] == 1)) {
                     $B = (! bgfCheckForConsanguinity($db, $vrsCurrentCow, $bullRow));
                     if ($B) {
                        $B = (($bullRow['From_insemination'] <= ($cowRow['Last_insemination_no'] + 1)) and ($bullRow['To_insemination'] > $cowRow['Last_insemination_no']));
                     }
                     
                     if ($B) {
                        $B = ($bullRow['Heifer_status'] == 0) and ($cowRow['lact_no'] > 0);
                        $B = $B Or (($bullRow['Heifer_status'] == 1) and ($cowRow['lact_no'] == 0));
                        $B = $B Or ($bullRow['Heifer_status'] == 2);
                        if ($B) {
                           If ($bullRow['Repetition'] > $gnMagicNumber) {
                              $B = bgfCheckSensitivity($db,$vrsCurrentCow, $bullRow,$username);
                              if ($B) {
                                 $bullsList[$T] = $bullRow['bull_name'];
                                 $T = $T + 1;
                              }
                           } // if ($bullRow['Repetition'] > $gnMagicNumber)
                        } // if B 
                     } // if Not bgfCheckForConsanguinity
                   } // if ($bullRow['PlannedUsage'] > 0) and ($bullRow['MatchStatus'] == 1)
               } //  If (($gnBullsInseminationTotal == 0) Or $B) 

            } // while (($bullsCount > 0) and ($T < 3) ) 
         } // if ($bBullsFound == false)
       
        } // if ($bBullsFound == 0)
      
   // return bulls array
   return $bullsList;
              
}
echo"Match  Dail  yActivitie  sBulls".$MatchDailyActivitiesBulls;
//$arrlength = count($MatchDailyActivitiesBulls);

for($x = 0; $x < 4; $x++) {
    echo $MatchDailyActivitiesBulls[$x];
    echo "<br>";
}


 // gsMatchDailyActivitiesBulls
//echo "<br>the match daily activity bulls is ".$MatchDailyActivitiesBulls;
/*function youngBulls()
{
 if ($bBullsFound == false) {
         $dParameter1 = 100 - $gnMagicNumber;
         $dParameter1 = ($dParameter1 * $nTotalWorkingCows) / 100;
         $dParameter2 = $gnBullsInseminationTotal + $gnBullsInseminationYoungBulls + $gnBullsInseminationMeatBulls + $gnBullsInseminationOtherBulls;
         
         If ($gnBullsInseminationYoungBulls > 0) {
            $dParameter3 = ($gnBullsInseminationYoungBulls / $dParameter2) * 100;
           
         }
         else {
            $dParameter3 = 0;
         }
         
         If ($userSettingsRow['Bulls_usage_young_bulls'] > 0) {
            If (False and ($cowRow['lact_no'] == 1) and ($dParameter3 < $gnBullsUsageYoungBulls)) {
               $bullsList[0] = "relevant text"; // find out what is - sgfGetINIString(gsLanguageFile, "BULLS", "49")
               $bullsCount = 1;
            }
           
         } // $userSettingsRow['BullsUsageYoungBulls'] > 0
         /***
         if ($bBullsFound == false) {
            $B = false; 
            If ($cowRow['ECM_rank_all'] <> null) {
               If ($cowRow['ECM_rank_all'] > $dParameter1) {
                  $B = true;
               }
            }
            
            If ($B == false) { 
               $S = "DESC";
            }
            Else {
               $S = "ASC";
            }
              ***
                          if ($userSettingsRow['Bulls_usage_young_bulls']  > 0) {
               If (($cowRow['lact_no'] == 1) and ($dParameter3 < $gnBullsUsageYoungBulls)) {
               
               // not sure what this part is about and why - reverse order on the array
               /****
                  For J = UBound(rasBulls) To 1 Step -1
                     rasBulls(J) = rasBulls(J - 1)
                  Next J
                  rasBulls(0) = "[" & sgfGetINIString(gsLanguageFile, "BULLS", "49") & "]"
                  T = T + 1
                  ***
             *   }// ($cowRow['LactationNumber'] == 1) and ($dParameter3 < $gnBullsUsageYoungBulls)
                             
               $bBullsFound = true;
             }// $userSettingsRow['BullsUsageYoungBulls']  > 0
            // get bulls breed per breeding program and cows parent and grand parent
}
*/

 ?>