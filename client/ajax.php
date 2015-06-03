<?php
include '../functions.php';

$db=getDbConnection();
if ($db->connect_error) {
	echo '<p>connection failed</p>';
}
//else echo 1;
if (is_ajax()) {
	if (isset($_POST["func"]) && ($_POST["func"]=='updateBullActive')) { //Checks if action value exists
		$bull_no=$_POST["bull_no"];
		$isActive = $_POST["active"];
		$strawSize= $_POST["StrawSize"];
		$strawType= $_POST["StrawType"];
		$color= $_POST["Color"];
		$heifer_status= $_POST["heifer_status"];
		$from_insemination= $_POST["from_insemination"];
		$to_insemination= $_POST["to_insemination"];
		$limited= $_POST["limited"];
		$orderBy= $_POST["Order_by_Fertility"];
		$user =$_POST["user"];
		//echo $isActive;
		//echo $bulls_no;
	  	//$query ="UPDATE `bulls_details` SET `Match_status`=".$isActive . ",`Heifer_status`=".$heifer_status. ",`From_insemination`=".$from_insemination. ",`To_insemination`=".$to_insemination.",`StrawColor`= '$color', `Order_by_Fertility`= ".$orderBy.", `Limited`=".$limited.",`StrawSize`=".$strawSize.",`StrawType`='$strawType' WHERE `bull_no`=".$bull_no;
		if(!isset($isActive)){
	  	 $isActive=-1;
	  	}
	  	if(!isset($heifer_status)){
	  	$heifer_status=-1;
	  	}
	  	if(!isset($from_insemination)){
	  	$from_insemination=-1;
	  	}
	  	if(!isset($to_insemination)){
	  	$to_insemination=-1;
	  	}
	  	if(!isset($color)){
	  	$color=NULL;
	  	}
	  	if(!isset($orderBy) or $orderBy==""){
	  	$orderBy=-1;
	  	}
	  	if(!isset($limited)){
	  	$limited=-1;
	  	}
	  	if(!isset($strawSize)){
	  	$strawSize=-1;
	  	}
	  	if(!isset($strawType)){
	  	$strawType=NULL;
	  	}

	  	$query ="INSERT INTO `users_bulls_details` (userID, bull_no, match_status ,heifer_status, from_insemination ,to_insemination ,straw_color ,order_by ,limited ,straw_size,straw_type) 
VALUES
   ('$user',$bull_no,$isActive,$heifer_status,$from_insemination,$to_insemination,'$color',$orderBy,$limited,$strawSize,'$strawType')
ON DUPLICATE KEY UPDATE 
   userID='$user', bull_no=$bull_no, match_status=$isActive ,heifer_status=$heifer_status ,from_insemination=$from_insemination ,to_insemination=$to_insemination ,straw_color='$color' ,order_by=$orderBy ,limited=$limited ,straw_size=$strawSize ,straw_type='$strawType' ";
	  	//echo $query;
	        $result = mysqli_query($db, $query);
	        echo 1;
	
   
  	}
  	if (isset($_POST["func"]) && ($_POST["func"]=='updateCows')) { //Checks if action value exists
		$cow_no=$_POST["cow_no"];
		$isActive = $_POST["active"];
		$lactno= $_POST["lactno"];
		$Insemno= $_POST["Insemno"];
		$forcedBull= $_POST["ForcedBull"];
		//echo $isActive;
		//echo $bulls_no;
	  	$query ="UPDATE `local_cows` SET `lact_no`=".$lactno. ",`match_status`=".$isActive . ",`Last_insemination_no`=".$Insemno. ",`Forced_bull`='$forcedBull' WHERE `cow_no`=".$cow_no;
	  	//echo $query;
	        $result = mysqli_query($db, $query);
	        echo 1;
	
   
  	}

  	if (isset($_POST["func"]) && ($_POST["func"]=='updateforcedbull')) { 
  	$forcedBull= $_POST["ForcedBull"];
  	$cow_no=$_POST["cow_no"];
  	$CheckForConsanguinity=bgfCheckForConsanguinity($db, $cow_no, $forcedBull);
  	return;
  	}
  	if (isset($_POST["func"]) && ($_POST["func"]=='updateSetting3')) { //Checks if action value exists
		$user_id=$_POST["user_id"];
		$farm=$_POST["farm"];
		$lastinsemupdate= $_POST["lastinsemupdate"];
		$daybefupdate= $_POST["daybefupdate"];
		//echo $_POST["dayinsemupdate"];
		if($_POST["dayinsemupdate"]=='true') {$dayinsemupdate='Yes';} else {$dayinsemupdate= 'No';};
		if($_POST["excfileinsem"]=='true') {$excfileinsem='Yes';} else {$excfileinsem= 'No';};
		if($_POST["showinsem"]=='true') {$showinsem='Yes';} else {$showinsem='No';};
		$folder= $_POST["folder"];
		$folderback= $_POST["folderback"];
		$email= $_POST["email"];

	  	$query ="UPDATE `user_settings` SET Last_insemination_update='$lastinsemupdate',Days_to_the_warning_on_lack_of_update='$daybefupdate',DailyInseminationUpdate='$dayinsemupdate',ExcelfileInsemination='$excfileinsem' ,ShowInseminationSummary='$showinsem',Folder='$folder' ,backup_folder='$folderback' WHERE user_id='$user_id'  and FarmName='$farm'";
	  	//echo $query;
	        $result = mysqli_query($db, $query);
	        
	        $query ="UPDATE `users_details` SET `User_E_Mail`='$email' WHERE User_Name='$user_id'";
	  	//echo $query;
	        $result = mysqli_query($db, $query);
	        echo 1;
	
   
  	}
  	if (isset($_POST["func"]) && ($_POST["func"]=='updateSetting5')) { //Checks if action value exists
		$user_id=$_POST["user_id"];
		$farm=$_POST["farm"];
		$Bulls_usage_young_bulls= $_POST["Bulls_usage_young_bulls"];
		$Bulls_usage_meat_bulls= $_POST["Bulls_usage_meat_bulls"];
		$Bulls_usage_genomic_bulls = $_POST["Bulls_usage_genomic_bulls"];
		//echo $_POST["dayinsemupdate"];
		//if($_POST["dayinsemupdate"]=='true') {$dayinsemupdate='Yes';} else {$dayinsemupdate= 'No';};
		//if($_POST["excfileinsem"]=='true') {$excfileinsem='Yes';} else {$excfileinsem= 'No';};
		//if($_POST["showinsem"]=='true') {$showinsem='Yes';} else {$showinsem='No';};
		$Bulls_first_insemination_date= $_POST["Bulls_first_insemination_date"];
		//echo $Bulls_last_insemination_date;
		$Bulls_last_insemination_date= $_POST["Bulls_last_insemination_date"];
		$Meat_bulls_lactation_no = $_POST["Meat_bulls_lactation_no"];
		$Bulls_Forbidden = $_POST["Bulls_Forbidden"];

	  	$query ="UPDATE `user_settings` SET `Bulls_usage_meat_bulls`=$Bulls_usage_meat_bulls, `Bulls_usage_young_bulls`=$Bulls_usage_young_bulls,`Bulls_first_insemination_date`='$Bulls_first_insemination_date' ,`Bulls_last_insemination_date`='$Bulls_last_insemination_date',`Meat_bulls_lactation_no`='$Meat_bulls_lactation_no', `Bulls_usage_genomic_bulls`='$Bulls_usage_genomic_bulls',`Bulls_Forbidden_for_Insemination`='$Bulls_Forbidden'
	  	 WHERE `user_id`='$user_id' and FarmName='$farm'";
	  	//echo $query;
	        $result = mysqli_query($db, $query);
	        echo 1;
	
   
  	}
  	  	if (isset($_POST["func"]) && ($_POST["func"]=='updateSetting1')) { //Checks if action value exists
		$user_id=$_POST["user_id"];
		$farm=$_POST["farm"];
		$program_plan_no= $_POST["program_plan_no"];

	  	$query ="UPDATE `user_settings` SET `program_plan_no`=$program_plan_no WHERE `user_id`='$user_id' and FarmName='$farm'";
	  	//echo $query;
	        $result = mysqli_query($db, $query);
	        echo 1;
	
   
  	}
  	if (isset($_POST["func"]) && ($_POST["func"]=='updateSetting2')) { //Checks if action value exists
		$user_id=$_POST["user_id"];
		$farm=$_POST["farm"];
		if($_POST["size"]=='true') {$Match_judgment_general_size=1;} else {$Match_judgment_general_size= 0;};
		if($_POST["udder"]=='true') {$Match_judgment_general_udder=1;} else {$Match_judgment_general_udder= 0;};
		if($_POST["teatsPlacments"]=='true') {$Match_judgment_teats_location=1;} else {$Match_judgment_teats_location= 0;};
		if($_POST["udderDepth"]=='true') {$Match_judgment_udder_depth=1;} else {$Match_judgment_udder_depth= 0;};
		if($_POST["legs"]=='true') {$Match_judgment_general_legs=1;} else {$Match_judgment_general_legs= 0;};
		if($_POST["pelvicStructure"]=='true') {$Match_judgment_pelvis_stucture=1;} else {$Match_judgment_pelvis_stucture= 0;};
		if($_POST["generalRating"]=='true') {$Match_judgment_overall_grade=1;} else {$Match_judgment_overall_grade= 0;};
		if($_POST["milk"]=='true') {$Match_production_KGmilk=1;} else {$Match_production_KGmilk= 0;};
		if($_POST["fat"]=='true') {$Match_production_fat_per=1;} else {$Match_production_fat_per= 0;};
		if($_POST["protein"]=='true') {$Match_production_protein_per=1;} else {$Match_production_protein_per= 0;};
		if($_POST["scc"]=='true') {$Match_production_SCC=1;} else {$Match_production_SCC= 0;};
		if($_POST["fertility"]=='true') {$Match_production_fertility=1;} else {$Match_production_fertility= 0;};

	  	$query ="UPDATE `user_settings` SET `Match_judgment_general_size`=$Match_judgment_general_size, `Match_judgment_general_udder`=$Match_judgment_general_udder,`Match_judgment_teats_location`=$Match_judgment_teats_location ,`Match_judgment_udder_depth`=$Match_judgment_udder_depth,`Match_judgment_general_legs`=$Match_judgment_general_legs ,`Match_judgment_pelvis_stucture`=$Match_judgment_pelvis_stucture ,`Match_production_KGmilk`=$Match_production_KGmilk ,`Match_judgment_overall_grade`=$Match_judgment_overall_grade ,`Match_production_fat_per`=$Match_production_fat_per ,`Match_production_protein_per`=$Match_production_protein_per ,`Match_production_SCC`=$Match_production_SCC ,`Match_production_fertility`=$Match_production_fertility WHERE `user_id`='$user_id' and FarmName='$farm'";
	  	//echo $query;
	        $result = mysqli_query($db, $query);
	        echo 1;
	
   
  	}
  	if (isset($_POST["func"]) && ($_POST["func"]=='Check')) 
  	{
	  	foreach ($_POST as $cow_no ) {
			if($cow_no!='Check'){
		  	$sql = "SELECT * FROM `local_cows` WHERE cow_no = '$cow_no' "; 
		          $searchResult = mysqli_query($db, $sql);
		          $count = mysqli_num_rows($searchResult);
		         if($count >0){
		         echo 1;
		         }
		         else {
		         echo 0;
		         }
		         }
  		}
         /* $cow_num=$_POST['cow_no'];
          // $cow=$_POST['txtcownum'];
          $sql = "SELECT * FROM `local_cows` WHERE cow_no = '$cow_num' "; 
          $searchResult = mysqli_query($db, $sql);
         if($searchResult){
         echo "<br>i am succeeddd";
         while($row = mysqli_fetch_array($searchResult)) {
        echo "id: " . $row["cow_no"]. " - Name: " . $row["cow_name"]. "<br>";
        echo 1;
    }
} 
else {
    echo 0;
}
 */	
	}
	if (isset($_POST["func"]) && ($_POST["func"]=='setUserFarm')) {
	//print_r($_POST["farm"]);
		//$farm= setUserFarm($_POST["farm"]);	
		//print_r($farm);
		$cookie_name = "farm";
		$cookie_value = $_POST["farm"];
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
		echo 1;
	}

}
function bgfCheckForConsanguinity($db, $vrsCurrentCow, $bullRow)    
{
        
	// No need to read bull record - it is passed as parameter
       
        $bullQuery = "SELECT * FROM `bulls_details` WHERE bull_no='$bullRow';" ;     
        $bullResult = mysqli_query($db, $bullQuery);
        If ($bullResult ->num_rows > 0)    {
        	$bullRow = mysqli_fetch_assoc($bullResult );
        }
        else  {
        	return -1;
        }
        
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
//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>