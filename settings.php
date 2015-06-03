<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
return;
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<div  class="register-form" >
<form align="left"  method="post" enctype="multipart/form-data" onSubmit="getPath();">
   <h1> Settings:........</h1><br/><br/>
   <table style="width:70%">
<tr>
       <td><p><label>User_Id : </label></td>
	<td><input id="userid" type="text" name="userid" placeholder="userid"pattern="[A-Za-z0-9]{1,}"required title="must only include letters, or number."/></td> 
 </p></tr>
 <tr>
         <td><p><label>Choose a folder: &nbsp;: </label></td>
	   <td><input id="folder" type="text" name="folder"  value="c:/xmatch" /></p></td>
</tr>
	   
	   <tr><td><p><label>the last time when cows file update from local computer : </label></td>
	 <td><input id="lastupdate" type="date" name="lastupdate" required /></p></td>	
</tr>	 
	  <tr><td><p><label>the last time when our data base are update : </label></td>
	 <td><input id="Lastupdateweb" type="date" name="lastupdateweb" required/></p></td>
</tr>	 
	 <tr> <td><p><label>Days to the warning on lack of update : </label></td>
	 <td><input id="Dayswarningupdate" name="Dayswarningupdate" required type="number" min="1" max="31"/></p></td>
</tr>	 
	 	 <tr><td><p><label>Genetic_protocol &nbsp;&nbsp;&nbsp; : </label></td>
	 <td><select required name="Genetic_protocol" >
	<option selected disabled value=" "> choice a genetic protocol:</option>
        <option value="ICBA">ICBA:</option>
        <option value="VSDA">VSDA</option>
        <option value="Hollow_g">Hollow_g</option>
        <option value="NONE">NONE</option>
        </select></td>
</tr>
             <tr><td> <p><label> update type : </label></td>
          <td><input type="radio" name="updateType"value="0" >manual
          <input type="radio" name="updateType"value="1"required="required">auto</td>
 </tr>          
           
          <tr> <td><p><label>number of cows for beef bulls: </label></td>
	 <td><input id="numcowsbeef" name="numcowsbeef" required type="number" min="1" max="99"/></p></td>
 </tr>          
           <tr><td><p><label>minum lactation for beef bulls: </label></td>
	 <td><input id="minlactbeef" name="minlactbeef" required type="number" min="1" max="99999"/></p></td>
</tr>
          <tr><td><p><label>beef breed to use : </label></td>
	<td> <input id="beefbread" type="text" name="beefbread" pattern="[A-Za-z]{3}"required title="must only include 3 letters"/></p></td>
</tr>
          <tr><td><p><label>prestnge using Sexed semen : </label></td>
	 <td><input id="prestngesexsem" type="text" name="prestngesexsem" pattern="[A-Za-z]{1,}"required title="must only include letters"/></p></td>
</tr>	 
	 <tr> <td><p><label>number of cows for sexed semen: </label></td>
	<td> <input id="numcowsexsem" name="numcowsexsem" required type="number" min="1" max="99"/></p></td>
</tr>	 
	 <tr><td><p><label>rest month for heifers: </label></td>
	<td> <input id="montheifers" name="montheifers" required type="number" min="1" max="12"/></p></td>
</tr>
          <tr><td><p><label>rest days for lact no 1: </label></td>
	 <td><input id="restdaylact1" name="restdaylact1" required type="number" min="1" max="357"/></p></td>
</tr>
         <tr><td><p><label>rest days for adult cows: </label></td>
	 <td><input id="restdayadult" name="restdayadult"required type="number" min="1" max="357"/></p></td>
</tr>
         <tr><td><p><label>crossbreeding program: </label></td>
	 <td><input id="crossbreedingprogram" type="text" name="crossbreedingprogram" pattern="[A-Za-z]{1,}"required title="must only include letters"/></p></td>
</tr>	 
	 
    <tr><td><input type="submit" value="submit" name="submit"><br/><br/></td>
</tr>
   </div>
</form>
</body>
</html>
<?php      
if(isset($_POST["submit"])) {
  $userid = $_POST['userid'];
  $folder = $_POST['folder'];
  $lastUpdate = $_POST['lastupdate'];
  $lastUpdateWeb = $_POST['lastupdateweb'];
  $DaysWarningUpdate = $_POST['Dayswarningupdate'];
  $selectOption = $_POST["Genetic_protocol"]; 
  $updateType=$_POST['updateType'];
  $NumCowsBeef=$_POST['numcowsbeef'];
  $MinLactBeef=$_POST['minlactbeef'];
  $BeefBread=$_POST['beefbread'];
  $PrestngeSexSem=$_POST['prestngesexsem'];
  $NumCowSexSem=$_POST['numcowsexsem'];
  $MontHeifers=$_POST['montheifers'];
  $RestDayLact1=$_POST['restdaylact1s'];
  $RestDayAdult=$_POST['restdayadult'];
  $CrossbreedingProgramt=$_POST['crossbreedingprogram'];
     
	    // insert record into file_audit table
		        $query ="INSERT INTO `user_settings` (user_id,backup_folder,Last_update_local,Last_update_web,Days_to_the_warning_on_lack_of_update,	Genetic_protocol,Update_type,Number_of_cows_for_beef_bulls,Minum_lactation_for_beef_bulls,Beef_breed_to_use,Prestnge_using_sexed_semen,
Number_of_cows_for_sexed_semen,Rest_month_for_heifers,Rest_days_for_lact_no_1,Rest_days_for_adult_cows,Crossbreeding_program)
		         VALUES('$userid','$folder','$lastUpdate','$lastUpdateWeb','$DaysWarningUpdate','$selectOption','$updateType','$NumCowsBeef','$MinLactBeef','$BeefBread',
'$PrestngeSexSem','$NumCowSexSem','$MontHeifers','$RestDayLact','$RestDayAdult','$CrossbreedingProgram');";
                   $result = mysqli_query($db, $query);
                    if($result)
		   {
		     echo '<br> The data was received successfully in  user_settings table';

		     // return true;
		   }
		   else
		   {
			echo '<br> failed  data in user_settings table';
			// return false;
		   }
		
	  }

?>