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
$MatchDailyActivitiesBulls=array();
foreach ($_GET as $cow_no )
 {
 if( $cow_no!= 'true'){
                //to display the data until 6 am 
                //$date=date_default_timezone_set("Israel").date("Ymdhis");
 	  	//$query =" INSERT INTO `daily_insemination_list` (cow_no,date) VALUES (".$cow_no.",".$date.")";
 	  	
	        $result = mysqli_query($db, $query);
 //echo "cows is ".$cow_no."<br>";
 // print_r(gsMatchDailyActivitiesBulls($db,$cow_no,$username,$farm));
// array_push($MatchDailyActivitiesBulls, gsMatchDailyActivitiesBulls($db,$cow_no,$username,$farm));
  //$MatchDailyActivitiesBulls= gsMatchDailyActivitiesBulls($db,$cow_no,$username,$farm);
 $MatchBulls= gsMatchDailyActivitiesBulls($db,$cow_no,$username,$farm);
  $MatchDailyActivitiesBulls[$cow_no]=$MatchBulls;
 // $Check=bgfCheckSensitivity ($db, $vrsCurrentCow, $bullRow,$username);

 //print_r($MatchDailyActivitiesBulls );
  }
 }
 RETURN $MatchDailyActivitiesBulls;
}
 $username=$_COOKIE["user"];
$farm=getUserFarm ($db,$username);

function gsMatchDailyActivitiesBulls($db, $vrsCurrentCow, $userId,$farm)
{
//echo "the USERNAME IS  is ".$userId;
	$bullsList = array("");
	$bullsCount = 0;
	$bBullsFound = false;
	$T=0;
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow' and Farm='$farm'  and User_ID='$userId' " ;  
       //echo $cowQuery ;
        $cowResult = mysqli_query($db, $cowQuery ); 
        $num = mysqli_num_rows($cowResult);
          //echo "the result num2 is ".$num;
         If ($num > 0)    {
        	$cowRow = mysqli_fetch_assoc($cowResult ); 
        }

        else  {
        	return $bullsList;
        	echo "hi3";
        }
        
        $userSettingsQuery = "SELECT * FROM `user_settings` WHERE user_id='$userId' and FarmName='$farm';" ;     
        //echo $userSettingsQuery ;
        $userSettingsResult = mysqli_query($db, $userSettingsQuery);
        If ($userSettingsResult->num_rows > 0)    {
        $num = mysqli_num_rows($userSettingsResult);
      // echo "<br>the result num3 is ".$num;
        	$userSettingsRow = mysqli_fetch_assoc($userSettingsResult);
        }
        else  {
        	return $bullsList;
        }
        
        $bBullsFound = False;
        $bullsCount = 0;
        
       // calculate total working cows
        $query = "SELECT * FROM `local_cows` WHERE brd_kg_ecm Is Not Null AND match_status=1 and Farm='$farm';" ;     
        //echo $query;
        $totalCowResult = mysqli_query($db, $query ); 
        If ($totalCowResult->num_rows > 0)    {
         $num = mysqli_num_rows($totalCowResult );
       //echo "<br>the result num4 is".$num;
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
        $query= "SELECT * FROM `local_cows` WHERE brd_kg_ecm Is Not Null AND match_status=1 AND lact_no>= '$cboLactationNumber' and Farm='$farm';";
        //echo $query;
        $result = mysqli_query($db, $query );
         If ($result ->num_rows > 0)    {
         $num = mysqli_num_rows($result );
        //echo "<br>the result num5 is".$num;
        $nTotalWorkingCowsLactationAboveMeatBulls = $result->num_rows;
}
       if ($nTotalWorkingCowsLactationAboveMeatBulls == $nTotalWorkingCows) {
        // in original VB - close the query looks like no other action
        }
        
     /*   if (($userSettingsRow['Bulls_usage_meat_bulls'] > 0) and 
             ($nTotalWorkingCowsLactationAboveMeatBulls > 0) and
             ($cowRow['lact_no'] >= $userSettingsRow['Meat_bulls_lactation_no'])) {
             
             $dParameter1 = 100 - $userSettingsRow['Bulls_usage_meat_bulls'];
             $dParameter1 = 0.01 * ($dParameter1 * $nTotalWorkingCowsLactationAboveMeatBulls);
             If ($dParameter1 <= $cowRow['ECMRankForMatchedCows']) {
            //echo "<br>the result num6 is";
                 // $bullsList[0] = "init string";    // check what is sgfGetINIString(gsLanguageFile, "BULLS", "48") stands for
             
              $bBullsFound = True; echo "<br>the result num7.2 is";
             }*/
    //echo "<br>the result num7 is";
         if ($bBullsFound == false) {
         //echo "<br>the result num8 is";
       //  $dParameter1 = 100 - $gnMagicNumber;
       //  $dParameter1 = ($dParameter1 * $nTotalWorkingCows) / 100;
         //$youngbulls=youngbulls();
       //  echo "<br>hi8";
            // get bulls breed per breeding program and cows parent and grand parent
            $breedType= getBullBreedPerProgram($db, $cowRow, $userSettingsRow['program_plan_no']);
             //echo "the breed type is ".$breedType;
            //$program_plan_no=["","",1,3,35,39,9,36];
            // Get bulls list from bulls table
$found=0;
$i=0;
 while (($i<2) and ($found<3)){
 //echo "the is is".$i;
 // $bullsQuery="select * FROM `bulls_details` WHERE Match_status=1";
            $bullsQuery = "SELECT b.bull_no, `bull_name`, `sire`, `PGS`, `MGS`, `Actuall_inseminations`, `Hazday`, `Repetition`, `KG_ECM`, `KG_milk`, `Fertility`, `Fat_percentage`, `KG_protein`, `Protein_percentage`, `SCC`, `General_size`, `General_udder`, `Teats_location`, `Udder_depth`, `General_legs`, `Overall_grade`, `Pelvis_stucture`, `Planned_usage`, `CVM`, `Bull_type`, `Visible`, `Usage_order`, `Breed`, `bull_foreign_no`, `bull_foreign_name`, CASE WHEN u.match_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  '$userId' THEN u.match_status ELSE b.Match_status END AS Match_status, CASE WHEN u.heifer_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  '$userId' THEN u.heifer_status ELSE b.Heifer_status END AS Heifer_status, 
CASE WHEN u.from_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.from_insemination
ELSE b.From_insemination
END AS From_insemination, 
CASE WHEN u.to_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.to_insemination
ELSE b.To_insemination
END AS To_insemination, 
CASE WHEN u.limited!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.limited
ELSE b.Limited
END AS Limited, 
CASE WHEN u.straw_color!=''
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.straw_color
ELSE b.StrawColor
END AS StrawColor, 
CASE WHEN u.straw_size!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.straw_size
ELSE b.StrawSize
END AS StrawSize, 
CASE WHEN u.straw_type!=''
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.straw_type
ELSE b.StrawType
END AS StrawType, 
CASE WHEN u.order_by!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.order_by ELSE b.Order_by_Fertility END AS Order_by_Fertility FROM  `bulls_details` AS b LEFT JOIN  `users_bulls_details` AS u ON b.bull_no = u.bull_no WHERE ((('$userId' NOT IN (select userID from `users_bulls_details` where b.bull_no = bull_no) AND b.match_status=1)) OR (u.match_status=1  AND u.userID = '$userId'))  and Breed = $breedType ORDER BY Order_by_Fertility DESC,Usage_order ASC, Fertility DESC ";
           //$bullsQuery = "SELECT * FROM `bulls_details` WHERE Match_status=1   ORDER BY Order_by_Fertility DESC,Usage_order ASC, Fertility DESC ;" ; 
             // SELECT * FROM `bulls_details` b, `users_bulls_details` u WHERE ((u.match_status=-1 AND //b.Match_status=1) OR //u.match_status=1 )  and Breed = '0' ORDER BY Order_by_Fertility DESC,Usage_order ASC, Fertility DESC
             //echo  $bullsQuery;
            $bullsResult = mysqli_query($db, $bullsQuery);
                     If ($bullsResult ->num_rows > 0)    {
         $num = mysqli_num_rows($bullsResult );
        //echo "<br>the result num9 is".$num;
            $bullsCount = $bullsResult->num_rows;
}
 // ECHO "<br>THE T IS    ...".$T;
            while (($bullRow = mysqli_fetch_assoc($bullsResult)) and ($T < 3) ) {
        	//echo "<br>'THE bullrow IS:::".$bullRow['bull_no'];
        	$B = false;
        	if ($gnBullsInseminationTotal > 0) {
                  $dActualUsagePercentage = ($bullRow['Actuall_inseminations'] / $dParameter2) * 100;
                  $B = ($dActualUsagePercentage < $bullRow['Planned_usage']);
               	} // (gnBullsInseminationTotal>0)

           //ECHO "THE I IS:".$i;
                if (false == $bullRow['Limited']) {
                   $B = true;
                }$q=$bullRow['Planned_usage'];
             //echo "<br>hi33total is".$gnBullsInseminationTotal;
               if (($gnBullsInseminationTotal == 0) or $B) {
                   
                   if (($bullRow['Planned_usage'] > 0) and ($bullRow['Match_status'] == 1)) {
                     $B = (! bgfCheckForConsanguinity($db, $vrsCurrentCow, $bullRow,$farm));
                  //  echo "pop".$B;
                     if ($B) {
                   //  echo "<br>hi4";
                        $B = (($bullRow['From_insemination'] <= ($cowRow['Last_insemination_no'] + 1)) and ($bullRow['To_insemination'] > $cowRow['Last_insemination_no']));
                        
                     }
                     if ($B) {
                    //  echo "<br>hi4".$B;
                        $B = ($bullRow['Heifer_status'] == 0) and ($cowRow['lact_no'] > 0);
                        $B = ($B Or (($bullRow['Heifer_status'] == 1) and ($cowRow['lact_no'] == 0)));
                        $B = ($B Or ($bullRow['Heifer_status'] == 2));
                      //  echo " the cow num isppone".$B;
                        if ($B==1) {
                     //   echo " the cow num ispptwo".$i;
                           If ($bullRow['Repetition'] > $gnMagicNumber) {
                           if($i==0){
                            $vrsCurrentBull=$bullRow['bull_no'];
                            $B = bgfCheckSensitivity($db,$vrsCurrentCow,$vrsCurrentBull,$userId,$farm);
                             }
                              if ($B==1) {
                              // echo "<br>the b  ".$B."the bull num is".$bullRow['bull_no'];
                                 if(!in_array($bullRow['bull_no'],$bullsList)){
                                 $bullsList[$T] = $bullRow['bull_no'];
                                 $T = $T + 1;
                                 $found=$found+1;
                                 // $found=true;
                              }
                              }
                           } // if ($bullRow['Repetition'] > $gnMagicNumber)
                        } // if B 
                     } // if Not bgfCheckForConsanguinity
                   } // if ($bullRow['PlannedUsage'] > 0) and ($bullRow['MatchStatus'] == 1)
               } //  If (($gnBullsInseminationTotal == 0) Or $B) 

            } // while (($bullsCount > 0) and ($T < 3) ) 
           // if ($T == 3){
           
           // }
         //  echo "end 1 while".$i;
            $i=$i+1;
        //   echo "end while".$i;
            }//while
         } // if ($bBullsFound == false)
       
      //  } // if ($bBullsFound == 0)
      
   // return bulls array
 // echo "End of gsMatchDailyActivitiesBulls <br>";
    //print_r($bullsList);
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
        //$program_plan_no=["","",1,3,35,39,9,36];   
    if ($programNo == 3) {
          // program is pur holstein
          //$breedType='HO'; 
          $breedType='1'; 
    }
    else if ($programNo == 4) {
          // program is pur mon/flv

          $breedType='3'; 
    }
    else if ($programNo == 5) {
          // program is pur jersy

          $breedType='35'; 
    }
    else if ($programNo == 6) {
          // program is pur nrf

          $breedType='39'; 
    }
    else if ($programNo == 7) {
          // program is pur brown swiss

          $breedType='9'; 
    }
    else if ($programNo == 8) {
          // program is pur red holstein

          $breedType='36'; 
    }
    else if ($programNo == 1) {
       // plan is two plus
       if ($sireBreed == 'HO') {
         //$breedType='NR';
         $breedType='39';
       }
       if ($sireBreed  == 'NR') {
         $breedType='1';
       }
     } // two plus
     
 else if ($programNo == 2) {
       // plan is two plus extra
       if ($sireBreed  == 'HO') {
         $breedType='39';
       }
       else if ($sireBreed  == 'NR') {
         if ($MGSBreed == 'NR'){
           $breedType='1';
           }
         else if ($MGSBreed == 'HO')
          { $breedType='39';
         }
       }
       } // two plus extra  
       
       return  $breedType;
} // getBullBreedPerProgram
//echo "the bull breed per program is".$breedType;
function bgfCheckForConsanguinity($db, $vrsCurrentCow, $bullRow,$farm)    
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
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow' and Farm='$farm';" ;     
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
function bgfCheckSensitivity ($db, $vrsCurrentCow, $vrsCurrentBull,$username,$farm)    
{
       // $vrsCurrentBull='5464';
      // $vrsCurrentCow='1239';
       
        $cowQuery = "SELECT * FROM `local_cows` WHERE cow_no='$vrsCurrentCow' and Farm='$farm';" ;     
        $cowResult = mysqli_query($db, $cowQuery );
       // echo "test db ";
       // print_r($cowResult);
       If ($cowResult ->num_rows > 0)    {
        	$cowRow = mysqli_fetch_assoc($cowResult );
        	//echo"select cows succed<br>".$vrsCurrentCow;
        }
        else  {
        	return false;
        }
       
        $tekenQuery = "SELECT * FROM `tblTeken` where RecordType='1';" ;     
        $tekenResult = mysqli_query($db, $tekenQuery );
       /* If ($tekenResult ->num_rows > 0)    {*/
       If ($tekenResult){
        	$tekenRow = mysqli_fetch_assoc($tekenResult );
        	//echo"select teken succed<br>";
      }
        else  {
        	return -1;
        }
              // $bullQuery = "SELECT * FROM `bulls_details` where bull_no='$vrsCurrentBull';" ;     
             $bullQuery = " SELECT b.bull_no, bull_name, KG_milk, KG_protein, Fertility, CVM, KG_ECM, Planned_usage, Actuall_inseminations, Usage_order, General_size, General_udder, Teats_location, Udder_depth, General_legs, Pelvis_stucture, Fat_percentage, Protein_percentage, MGS, PGS, SCC, sire, breed, Actuall_inseminations, Planned_usage, Repetition, Overall_grade, CASE WHEN u.match_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  '$userId' THEN u.match_status ELSE b.Match_status END AS Match_status, CASE WHEN u.heifer_status!=-1 AND u.bull_no = b.bull_no AND u.userID =  '$userId' THEN u.heifer_status ELSE b.Heifer_status END AS Heifer_status, 
CASE WHEN u.from_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.from_insemination
ELSE b.From_insemination
END AS From_insemination, 
CASE WHEN u.to_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.to_insemination
ELSE b.To_insemination
END AS To_insemination, 
CASE WHEN u.limited!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.limited
ELSE b.Limited
END AS Limited, 
CASE WHEN u.straw_color!=''
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.straw_color
ELSE b.StrawColor
END AS StrawColor, 
CASE WHEN u.straw_size!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.straw_size
ELSE b.StrawSize
END AS StrawSize, 
CASE WHEN u.straw_type!=''
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.straw_type
ELSE b.StrawType
END AS StrawType, 
CASE WHEN u.order_by!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$userId'
THEN u.order_by ELSE b.Order_by_Fertility END AS Order_by_Fertility FROM  `bulls_details` AS b LEFT JOIN  `users_bulls_details` AS u ON b.bull_no = u.bull_no WHERE b.bull_no='$vrsCurrentBull' ";
//echo $bullQuery;
            $bullsResult = mysqli_query($db, $bullQuery);
                   //  If ($bullsResult ->num_rows > 0) 
                     // {
       //  $num = mysqli_num_rows($bullsResult );
      //      $bullsCount = $bullsResult->num_rows;}
                  // echo "<br>the num isss";
      
      //  else  {
        //	return -1;
       // }
       $bullRow = mysqli_fetch_assoc($bullsResult);
            //while ($bullRow = mysqli_fetch_assoc($bullsResult)){
        	//echo "<br>select bull succedthe bull no is:::".$bullRow['bull_no'];
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
   	$Query = "SELECT * FROM `user_settings` WHERE user_id='$username' and FarmName='$farm';" ;     
        $Result = mysqli_query($db, $Query);
        If ($Result)
        {
                   //echo"select useername succed<br>";
        	$settingsRow = mysqli_fetch_assoc($Result);
 		$returnMsg = $settingsRow["FarmName"];
        	}
// next check is dependent in the VB code on frmMain.chkMatchProductionKGMilk.Value (if it was checked)
        if($settingsRow['Match_production_KGmilk']==1){	 
      	If ($cowRow['brd_milk_kg'] == null)  {     	    
            $dKGMilk = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software 1(milk!!!)")';
            echo '</script>';
            }
	 else {
      	 //echo "milk 1".$cowRow['brd_milk_kg'];
            $dKGMilk = $cowRow['brd_milk_kg'];
            
         } 
         //echo"<br> the bull no is:".$bullRow['bull_no'];   	
         //echo "milk 2".$bullRow['KG_milk'];
      	if ($dKGMilk <> 0) {
      	$dKGMilk = ($dKGMilk + $bullRow['KG_milk']) / 2;
//echo "milk 3".$dKGMilk;
      	}}
      	else {
      	$dKGMilk =9999;
      	//echo "milk 4";
      	     }

      	// next check is dependent in original VB code on frmMain.chkMatchProductionFertility.Value  (if it is checked)
   	  if($settingsRow['Match_production_fertility']==1){
   	//  echo "<br>1cowRow['brd_dau_fertilty'is:".$cowRow['brd_dau_fertilty'];
      	if ($cowRow['brd_dau_fertilty'] == null) {
         $dFertility = 0;
      	    echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_dau_fertilty!!!)")';
            echo '</script>';
      	}
      	
      	else {
      	$dFertility = $cowRow['brd_dau_fertilty'];
      	}
      	if ($dFertility <> 0) {
      	$dFertility = ($dFertility + $bullRow['Fertility']) / 2;
      	}
      	}
      	else {
      	$dFertility = 9999;
      	}

// next check is dependent in original VB code on frmMain.chkMatchProductionFatPercentage (that it is checked)
        if($settingsRow['Match_production_fat_per']==1){
      	If ($cowRow['brd_fat_pre'] == null) {
        $dFatPercentage = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_fat_pre!!!)")';
            echo '</script>';
        }

        else {
        $dFatPercentage = $cowRow['brd_fat_pre'];
        }

	if ($dFatPercentage <> 0) {
	$dFatPercentage = ($dFatPercentage + $bullRow['Fat_percentage']) / 2;
	}}
	else {
	$dFatPercentage = 9999;
	     }

        // next check is dependent in original VB code on frmMain.chkMatchProductionProteinPercentage.Value  (if it is checked)
                if($settingsRow['Match_production_protein_per']==1){	
	If ($cowRow['brd_prot_pre'] == null) {
            $ProteinPercentage= 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_prot_pre!!!)")';
            echo '</script>';
        }
        else {
        $ProteinPercentage= $cowRow['brd_prot_pre'];
      //  echo "brd_prot_pre".$ProteinPercentage;
        }
 	if ($ProteinPercentage <> 0) {
	$ProteinPercentage= ($ProteinPercentage+ $bullRow['Protein_percentage']) / 2;
	}}
	else {
	$ProteinPercentage = 9999;
	     }
        // next check is dependent in original VB code on frmMain.chkMatchProductionSCC.Value (if it is checked)
          if($settingsRow['Match_production_SCC']==1){
	
	If ($cowRow['brd_SCC'] == null) {
           $dSCC = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_SCC!!!)")';
            echo '</script>';
        }
        else {
        $dSCC = $cowRow['brd_SCC'];
        }
 	if ($dSCC <> 0) { /*CHECK */
	$dSCC = ($dSCC + $bullRow['SCC']) / 2;
	}}
	else {
	$dSCC = 9999;
	     }
	// next check is dependent in original VB code on frmMain.chkMatchJudgmentGeneralSize.Value (if it is checked)
	if($settingsRow['Match_judgment_general_size']==1){
	If ($cowRow['brd_general_size'] == null) {
        $dGeneralSize = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_general_size!!!)")';
            echo '</script>';
        }
        else {
        $dGeneralSize = $cowRow['brd_general_size'];
        }
 	if ($dGeneralSize <> 0) {
	$dGeneralSize = ($dGeneralSize + $bullRow['General_size']) / 2;
	}
	}
	else {
	$dGeneralSize = 9999;
	     }

 // next check is dependent in original VB code on frmMain.chkMatchJudgmentGeneralUdder.Value (if it is checked)
         if($settingsRow['Match_judgment_general_udder']==1){
	If ($cowRow['brd_udder'] ==null ) {
           $dGeneralUdder = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_udder!!!)")';
            echo '</script>';
        }
        else {
        $dGeneralUdder = $cowRow['brd_udder'];
        }
 	if ($dGeneralUdder <> 0) {
	$dGeneralUdder = ($dGeneralUdder + $bullRow['General_udder']) / 2;
	}
	}
	else {
	$dGeneralUdder = 9999;
	     }

  // next check is dependent in original VB code on frmMain.chkMatchJudgmentNippleLocation.Value (if it is checked)
          if($settingsRow['Match_judgment_teats_location']==1){
	If ($cowRow['brd_Teats_placement'] == null) {
        $dNippleLocation = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_Teats_placement!!!)")';
            echo '</script>';
        }
        else {
        $dNippleLocation = $cowRow['brd_Teats_placement'];
        }
 	if ($dNippleLocation <> 0) {
	$dNippleLocation = ($dNippleLocation + $bullRow['Teats_location']) / 2;
	}
	}
	else {
	$dNippleLocation = 9999;
	     }
	     
        // next check is dependent in original VB code on frmMain.chkMatchJudgmentUdderDepth.Value (if it is checked)
        if($settingsRow['Match_judgment_udder_depth']==1){     
	If ($cowRow['brd_Udder_depth'] == null) {
           $dUdderDepth = 0;
            echo '<script language="javascript">';
           echo 'alert("Match cows may be incorrect please contact Software(brd_Udder_depth!!!)")';
            echo '</script>';
        }
        else {
        $dUdderDepth = $cowRow['brd_Udder_depth'];
        }
 	if ($dUdderDepth <> 0) {
	$dUdderDepth = ($dUdderDepth + $bullRow['Udder_depth']) / 2;
	}
	}
	else {
	$dUdderDepth = 9999;
	     }

        // next check is dependent in original VB code on frmMain.chkMatchJudgmentGeneralLegs.Value (if it is checked)	
        if($settingsRow['Match_judgment_general_legs']==1){
	If ($cowRow['brd_legs'] == 'null') {
             $dGeneralLegs = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_legs!!!)")';
            echo '</script>';
        }
        else {
        $dGeneralLegs = $cowRow['brd_legs'];
        }
 	if ($dGeneralLegs <> 0) {
	$dGeneralLegs = ($dGeneralLegs + $bullRow['General_legs']) / 2;
	}
	}
	else {
	$dGeneralLegs = 9999;
	     }
	
	// next check is dependent in original VB code on frmMain.chkMatchJudgmentPelvisStructure.Value (if it is checked)
	           if($settingsRow['Match_judgment_pelvis_stucture']==1){    
	If ($cowRow['brd_Ramp_stucture'] == null) {
            $dPelvisStructure = 0;
            echo '<script language="javascript">';
            echo 'alert("Match cows may be incorrect please contact Software(brd_Ramp_stucture!!!)")';
            echo '</script>';
        }

        else {
        $dPelvisStructure = $cowRow['brd_Ramp_stucture'];
        }
 	if ($dPelvisStructure <> 0) {
	$dPelvisStructure = ($dPelvisStructure + $bullRow['Pelvis_stucture']) / 2;
	}
	}
	else {
	$dPelvisStructure = 9999;
	 	}

        // echo"HI WAS ON THE END OF THE FUNC";
	// Now comes a long condition to decide if sensitivity is true or not
	//D$usernamed said to get it from
          if ( ($dKGMilk >= ($tekenRow['TEKEN_MILK'] * $tekenRow['HIGH_SENS'])) and 
	     ($dFertility >= ($tekenRow['TEKEN_FAT'] * $tekenRow['HIGH_SENS'])) and 
	     ($dFatPercentage >= ($tekenRow['TEKEN_FATP'] * $tekenRow['HIGH_SENS'])) and 
/*($dKGProtein >= ($tekenRow['TEKEN_PRT'] * $tekenRow['HIGH_SENS'])) and*/
	     ($ProteinPercentage >= ($tekenRow['TEKEN_PRTP'] * $tekenRow['HIGH_SENS'])) and
	     ($dSCC >= ($tekenRow['TEKEN_SCC'] * $tekenRow['LOW_SENS'])) and
	     ($dGeneralSize >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dGeneralUdder >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dNippleLocation >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dUdderDepth >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	     ($dGeneralLegs >= $tekenRow['SHIPUT_HIGH_SENS'] ) and
	    /* ($dOverallGrade >= $tekenRow['SHIPUT_HIGH_SENS'] ) and*/
	     ($dPelvisStructure >= $tekenRow['TEKEN_AGAN'] )
	) 
	 {
	 //echo "<br>thedKGMilk ".$dKGMilk." 1the teken row milk".$tekenRow['TEKEN_MILK'];
	return 1;  // return true for check sensitivity
	}
	else 
	{
	/*echo "<br>thedKGMilk ".$dKGMilk;
	echo "<br>dFertility ".$dFertility;
	echo "<br>dFatPercentage ".$dFatPercentage;
	 echo "<br>ProteinPercentage ".$ProteinPercentage;
	 echo "<br>dSCC ".$dSCC;
	 echo "<br>the teken row TEKEN_SCC".$tekenRow['TEKEN_SCC'];
	 echo "<br>dPelvisStructure ".$dPelvisStructure ;
	 echo "<br>dGeneralLegs ".$dGeneralLegs;
	 echo "<br>dUdderDepth".$dUdderDepth;
	 echo "<br>dNippleLocation ".$dNippleLocation;
	 echo "<br>dGeneralUdder".$dGeneralUdder;
	 echo "<br>dGeneralSize ".$dGeneralSize;*/
	return 0;
	}
	//} //while bull result
	//}*/


}

  // bgfCheckSensitivity 
?>