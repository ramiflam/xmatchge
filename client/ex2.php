<?php
include "navigationBar.php";
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$username=$_COOKIE["user"];
$gnMagicNumber = 50; // this is fake value need to get real one from tipuchit - not in the code
$gnBullsInseminationTotal = 0; // need to update the value taken as sum of ActualInseminationsfrom bulls table for foreign bulls (see fileio.bas)
$gnBullsInseminationYoungBulls = 0;  // need to update the value taken as sum of ActualInseminationsfrom bulls table for young bulls (see fileio.bas)
$gnBullsInseminationMeatBulls = 0; // need to update the value taken as sum of ActualInseminationsfrom bulls table for meat bulls (see fileio.bas)
$gnBullsInseminationOtherBulls = 0; // need to update the value taken as sum of ActualInseminationsfrom bulls table for other bulls (see fileio.bas)

//The main function is sent from Dailyactivities  All the cows that the user has selected.
//function getCow($db,$cowList)
function getCow($db)
{
$username=$_COOKIE["user"];
$farm=getUserFarm ($db,$username);
foreach ($_GET as $cow_no )
 {
 if( $cow_no!= 'true'){
 echo "cows is ".$cow_no."<br>";

 $MatchBulls= gsMatchDailyActivitiesBulls($db,$cow_no,$username,$farm);
  $MatchDailyActivitiesBulls[$cow_no]=$MatchBulls;
   print_r($MatchDailyActivitiesBulls );
  }
 }
 RETURN $MatchDailyActivitiesBulls;
}
 $username=$_COOKIE["user"];
$farm=getUserFarm ($db,$username);

/*
echo"the farm is ".$farm."and the user name is ".$username."<br>";
 $vrsCurrentCow='995';
 $a=array();
$a=gsMatchDailyActivitiesBulls($db, $vrsCurrentCow, $userId,$farm);
for($x = 0; $x < 4; $x++)
{
    echo "the number a is ".$a[$x];
    echo "<br>";
}
echo "the a is ".$a;

*/

function gsMatchDailyActivitiesBulls($db, $vrsCurrentCow, $userId,$farm)
{
echo "the USERNAME IS  is ".$userId;
	$bullsList = array("");
	$bullsCount = 0;
	$bBullsFound = false;
	$T=0;
	//$cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow'  and Farm='$farm'  and User_ID='$userId'  ;" ;
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow' ;" ;  
      //  echo "cow__query = " . $cowQuery;  this is correct
        $cowResult = mysqli_query($db, $cowQuery ); 
       //  $result_num=mysqli_affected_rows($db);
        $num = mysqli_num_rows($cowResult);
          //$num = $cowResult->num_rows;
          echo "the result num2 is ".$num;
         If ($num > 0)    {
     //   If ($cowResult->num_rows > 0)    { not work 
        	$cowRow = mysqli_fetch_assoc($cowResult ); 
        }

        else  {
        	return $bullsList;
        	echo "hihiihihihih3";
        }
        
        $userSettingsQuery = "SELECT * FROM `user_settings` WHERE user_id='$userId';" ;     
        $userSettingsResult = mysqli_query($db, $userSettingsQuery);
        If ($userSettingsResult->num_rows > 0)    {
        $num = mysqli_num_rows($userSettingsResult);
        echo "<br>the result num3 is ".$num;
        	$userSettingsRow = mysqli_fetch_assoc($userSettingsResult);
        }
        else  {
        	return $bullsList;
        }
        
        $bBullsFound = False;
        $bullsCount = 0;
        
       // calculate total working cows
        $query = "SELECT * FROM `local_cows` WHERE brd_kg_ecm Is Not Null AND match_status=1;" ;     
        $totalCowResult = mysqli_query($db, $query ); 
        If ($totalCowResult->num_rows > 0)    {
         $num = mysqli_num_rows($totalCowResult );
        echo "<br>the result num4 is".$num;
        	$nTotalWorkingCows = $totalCowResult->num_rows;
        }
        
        else {
        $nTotalWorkingCows = 0;
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
         If ($result ->num_rows > 0)    {
         $num = mysqli_num_rows($result );
        echo "<br>the result num5 is".$num;
        $nTotalWorkingCowsLactationAboveMeatBulls = $result->num_rows;
}
       if ($nTotalWorkingCowsLactationAboveMeatBulls == $nTotalWorkingCows) {
        // in original VB - close the query looks like no other action
        }
        
        if (($userSettingsRow['Bulls_usage_meat_bulls'] > 0) and 
             ($nTotalWorkingCowsLactationAboveMeatBulls > 0) and
             ($cowRow['lact_no'] >= $userSettingsRow['Meat_bulls_lactation_no'])) {
              echo "<br>the result num6.1 is";
             $dParameter1 = 100 - $userSettingsRow['Bulls_usage_meat_bulls'];echo "<br>the result num6.2 is".$dParameter1;
             $dParameter1 = 0.01 * ($dParameter1 * $nTotalWorkingCowsLactationAboveMeatBulls);echo "<br>the result num6.3 is".$dParameter1;
            // If ($dParameter1 <= $cowRow['ECMRankForMatchedCows']) {
          //   echo "<br>the result num6 is".$dParameter1;
                 // $bullsList[0] = "init string";    // check what is sgfGetINIString(gsLanguageFile, "BULLS", "48") stands for
             
             // $bBullsFound = True;
       //      }
    echo "<br>the result num7 is";
         if ($bBullsFound == false) {
         echo "<br>the result num8 is";
         $dParameter1 = 100 - $gnMagicNumber;
         $dParameter1 = ($dParameter1 * $nTotalWorkingCows) / 100;
         //$youngbulls=youngbulls();
         echo "<br>hiiiii888888888";
            // get bulls breed per breeding program and cows parent and grand parent
            $breedType= getBullBreedPerProgram($db, $cowRow, $userSettingsRow['program_plan_no']);
             echo "the breed type is ".$breedType;
            
            // Get bulls list from bulls table
            $bullsQuery = "SELECT b.bull_no, `bull_name`, `sire`, `PGS`, `MGS`, `Actuall_inseminations`, `Hazday`, `Repetition`, `KG_ECM`, `KG_milk`, `Fertility`, `Fat_percentage`, `KG_protein`, `Protein_percentage`, `SCC`, `General_size`, `General_udder`, `Teats_location`, `Udder_depth`, `General_legs`, `Overall_grade`, `Pelvis_stucture`, `Planned_usage`, `CVM`, `Bull_type`, `Visible`, `Usage_order`, `Breed`, `bull_foreign_no`, `bull_foreign_name`, CASE WHEN u.match_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  'Avi' THEN u.match_status ELSE b.Match_status END AS Match_status, CASE WHEN u.heifer_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  'Avi' THEN u.heifer_status ELSE b.Heifer_status END AS Heifer_status, 
CASE WHEN u.from_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.from_insemination
ELSE b.From_insemination
END AS From_insemination, 
CASE WHEN u.to_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.to_insemination
ELSE b.To_insemination
END AS To_insemination, 
CASE WHEN u.limited!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.limited
ELSE b.Limited
END AS Limited, 
CASE WHEN u.straw_color!=''
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.straw_color
ELSE b.StrawColor
END AS StrawColor, 
CASE WHEN u.straw_size!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.straw_size
ELSE b.StrawSize
END AS StrawSize, 
CASE WHEN u.straw_type!=''
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.straw_type
ELSE b.StrawType
END AS StrawType, 
CASE WHEN u.order_by!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.order_by ELSE b.Order_by_Fertility END AS Order_by_Fertility FROM  `bulls_details` AS b LEFT JOIN  `users_bulls_details` AS u ON b.bull_no = u.bull_no WHERE ((ISNULL(u.match_status) AND b.match_status=1)) OR (u.match_status=1  AND u.userID = 'Avi')  and Breed = '1' ORDER BY Order_by_Fertility DESC,Usage_order ASC, Fertility DESC ";
           //$bullsQuery = "SELECT * FROM `bulls_details` WHERE Match_status=1   ORDER BY Order_by_Fertility DESC,Usage_order ASC, Fertility DESC ;" ; 
             // SELECT * FROM `bulls_details` b, `users_bulls_details` u WHERE ((u.match_status=-1 AND //b.Match_status=1) OR //u.match_status=1 )  and Breed = '0' ORDER BY Order_by_Fertility DESC,Usage_order ASC, Fertility DESC
            $bullsResult = mysqli_query($db, $bullsQuery);
                     If ($bullsResult ->num_rows > 0)    {
         $num = mysqli_num_rows($bullsResult );
        echo "<br>the result num9 is".$num;
            $bullsCount = $bullsResult->num_rows;
}
            while (($bullRow = mysqli_fetch_assoc($bullsResult)) and ($T < 3) ) {
        	echo "<br>hiiiii12121212987";
        	$B = false;
        	if ($gnBullsInseminationTotal > 0) {
        	echo "nomi";
                  $dActualUsagePercentage = ($bullRow['Actuall_inseminations'] / $dParameter2) * 100;
                  $B = ($dActualUsagePercentage < $bullRow['Planned_usage']);
               	} // (gnBullsInseminationTotal>0)

          
                if (false == $bullRow['Limited']) {
                   $B = true;
                }$q=$bullRow['Planned_usage'];
             echo "<br>hiiiii333333333333total is".$gnBullsInseminationTotal;
               if (($gnBullsInseminationTotal == 0) or $B) {echo "nomi222"."  and  ".$q;
                   
                   if (($bullRow['Planned_usage'] > 0) and ($bullRow['Match_status'] == 1)) {
                     $B = (! bgfCheckForConsanguinity($db, $vrsCurrentCow, $bullRow));
                     echo "pop".$B;
                     if ($B) {
                     echo "<br>hiiiii44444".$B;
                        $B = (($bullRow['From_insemination'] <= ($cowRow['Last_insemination_no'] + 1)) and ($bullRow['To_insemination'] > $cowRow['Last_insemination_no']));
                        echo "<br>hiiiii44444".$B;
                     }
                     if($B==1)
                     { 
                     echo "true";
                     }
                     else {echo "false";}
                     echo "<br>hiiiii444";
                     if ($B) {
                      echo "<br>hii444".$B;
                        $B = ($bullRow['Heifer_status'] == 0) and ($cowRow['lact_no'] > 0);
                        $B = $B Or (($bullRow['Heifer_status'] == 1) and ($cowRow['lact_no'] == 0));
                        $B = $B Or ($bullRow['Heifer_status'] == 2);echo " the cow num isppone".$B;
                        if ($B==1) {
                        echo " the cow num ispptwo";
                           If ($bullRow['Repetition'] > $gnMagicNumber) {
                            // $B = bgfCheckSensitivity($db,$vrsCurrentCow,$bullRow,$userId);
                              ECHO "CHEK SENSITIVITY .".$B;
                              if ($B==1) {
                               echo "t shave le...".$T;
                                 $bullsList[$T] = $bullRow['bull_no'];
                                 $T = $T + 1;
                                 echo "t shave le...".$T;
                              }
                             /*  else
                              {
                                echo "telsee ".$T."<br>";
                              echo "<br>the b  ".$B;
                              }*/
                           } // if ($bullRow['Repetition'] > $gnMagicNumber)
                        } // if B 
                     } // if Not bgfCheckForConsanguinity
                   } // if ($bullRow['PlannedUsage'] > 0) and ($bullRow['MatchStatus'] == 1)
               } //  If (($gnBullsInseminationTotal == 0) Or $B) 

            } // while (($bullsCount > 0) and ($T < 3) ) 
             $bBullsFound = true;
         } // if ($bBullsFound == false)
       
        } // if ($bBullsFound == 0)
      
   // return bulls array
   echo "End of gsMatchDailyActivitiesBulls <br>";
    print_r($bullsList);
   return $bullsList;
              
}
//echo"Match  Daily Activities Bulls is ".$MatchDailyActivitiesBulls;

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
      return false;
  }
} 
//echo "<br>the sire breed is".$getSireBreed;

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
      return false;
  }
} // getMGSBreed
//echo "<br>the MGS breed is".$getMGSBreed;
 function getBullBreedPerProgram($db, $cowRow, $programNo)
{
   $breedType = "";
    // get sire breed from bulls and MGS breed from bulls
    $sireBreed = getSireBreed($db, $cowRow);
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
//echo "the bull breed per program is".$breedType;
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

function bgfCheckSensitivity ($db, $vrsCurrentCow, $bullRow,$username)    
{
        //$vrsCurrentBull='5453';
       //$vrsCurrentCow='995';
       echo "sensitivity";
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow';" ;     
        $cowResult = mysqli_query($db, $cowQuery );
       If ($cowResult ->num_rows > 0)    {
        	$cowRow = mysqli_fetch_assoc($cowResult );
        	echo"select cows succed<br>".$vrsCurrentCow;
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
               //bullQuery = "SELECT * FROM `bulls_details` where bull_no='$vrsCurrentBull';" ;     
               $bullQuery = " SELECT b.bull_no, bull_name, KG_milk, KG_protein, Fertility, CVM, KG_ECM, Planned_usage, Actuall_inseminations, Usage_order, General_size, General_udder, Teats_location, Udder_depth, General_legs, Pelvis_stucture, Fat_percentage, Protein_percentage, MGS, PGS, SCC, sire, breed, Actuall_inseminations, Planned_usage, Repetition, Overall_grade, CASE WHEN u.match_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  'Avi' THEN u.match_status ELSE b.Match_status END AS Match_status, CASE WHEN u.heifer_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  'Avi' THEN u.heifer_status ELSE b.Heifer_status END AS Heifer_status, 
CASE WHEN u.from_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.from_insemination
ELSE b.From_insemination
END AS From_insemination, 
CASE WHEN u.to_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.to_insemination
ELSE b.To_insemination
END AS To_insemination, 
CASE WHEN u.limited!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.limited
ELSE b.Limited
END AS Limited, 
CASE WHEN u.straw_color!=''
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.straw_color
ELSE b.StrawColor
END AS StrawColor, 
CASE WHEN u.straw_size!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.straw_size
ELSE b.StrawSize
END AS StrawSize, 
CASE WHEN u.straw_type!=''
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.straw_type
ELSE b.StrawType
END AS StrawType, 
CASE WHEN u.order_by!=-1
AND u.bull_no = b.bull_no
AND u.userID =  'Avi'
THEN u.order_by ELSE b.Order_by_Fertility END AS Order_by_Fertility FROM  `bulls_details` AS b LEFT JOIN  `users_bulls_details` AS u ON b.bull_no = u.bull_no WHERE b.bull_no='$vrsCurrentBull' ";
        $bullResult = mysqli_query($db, $bullQuery );
       // If ($tekenResult ->num_rows > 0)    {
       If ($bullResult){
        	$bullRow = mysqli_fetch_assoc($bullResult );
        	echo"select bull succed<br>";
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
                   echo"select useername succed<br>";
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
	/*
	If ($cowRow['brd_prot_kg'] == null) {
        $dKGProtein = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_prot_kg!!!)")';
            echo '</script>';
        }
        else {
        $dKGProtein = $cowRow['brd_prot_kg'];
        }
        */
        
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
        echo"select brd ssssscccccccccc suvccj<br>";
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
	
	If ($cowRow['brd_legs'] == 'null') {
        $dGeneralLegs = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_legs!!!)")';
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
         echo"HI WAS ON THE END OF THE FUNC";
	// Now comes a long condition to decide if sensitivity is true or not
	//David said to get it from
	if ( ($dKGMilk >= ($tekenRow['TEKEN_MILK'] * $tekenRow['HIGH_SENS'])) and 
	     ($dFertility >= ($tekenRow['TEKEN_FAT'] * $tekenRow['HIGH_SENS'])) and 
	     ($dFatPercentage >= ($tekenRow['TEKEN_FATP'] * $tekenRow['HIGH_SENS'])) and 
	    /* ($dKGProtein >= ($tekenRow['TEKEN_PRT'] * $tekenRow['HIGH_SENS'])) and*/
	     ($dProteinPercentage >= ($tekenRow['TEKEN_PRTP'] * $tekenRow['HIGH_SENS'])) and
	     ($dSCC >= ($tekenRow['TEKEN_SCC'] * $tekenRow['LOW_SENS'])) and
	     ($dGeneralSize >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dGeneralUdder >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dNippleLocation >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dUdderDepth >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dGeneralLegs >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dOverallGrade >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dPelvisStructure >= $tekenRow['TEKEN_AGAN'] )
	) 
	 {
	return 1;  // return true for check sensitivity
	}
	else 
	{
	return 0;
	}
	//}

}
  // bgfCheckSensitivity 
?>