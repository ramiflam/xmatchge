<?php
include "settings.php";
$userfarm=$_COOKIE["farm"];
$userName=  getUserFamily($db, $username);
$userNumber=  getUserNumber($db, $username);
$userLoc=  getUserLocation($db, $username);
$userEmail= getUserEmail($db, $username);
$browserLanguage='he';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$set4_title=getMsg($db, $browserLanguage, 'set4_title');
$set4_farm=getMsg($db, $browserLanguage, 'set4_farm');
$set4_name=getMsg($db, $browserLanguage, 'set4_name');
$set4_email=getMsg($db, $browserLanguage, 'set4_email');
$set4_number=getMsg($db, $browserLanguage, 'set4_number');
$set4_subtitle1=getMsg($db, $browserLanguage, 'set4_subtitle1');
$set4_lastup=getMsg($db, $browserLanguage, 'set4_lastup');
$set4_daysbefore=getMsg($db, $browserLanguage, 'set4_daysbefore');
$set4_daily=getMsg($db, $browserLanguage, 'set4_daily');
$set4_excel=getMsg($db, $browserLanguage, 'set4_excel');
$set4_show=getMsg($db, $browserLanguage, 'set4_show');
$set4_database=getMsg($db, $browserLanguage, 'set4_database');
$set4_location=getMsg($db, $browserLanguage, 'set4_location');
$set4_backloc=getMsg($db, $browserLanguage, 'set4_backloc');
$set4_backup=getMsg($db, $browserLanguage, 'set4_backup');    

$query="SELECT * FROM `user_settings` WHERE `user_id`='$username'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
//echo "1".$row["DailyInseminationUpdate"];
?>
<!DOCTYPE html>
<html>
<body dir="rtl">
<script>
 function uploadFileFun(path){
  document.getElementById("set4_backuplocationtxt").value= path;
}
</script>
<div class="farmsetting">
<form  name="set"  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" user_id="<?php echo $username?>" >
    <h1> <?php echo $GenfarmPhrase; ?></h1>
    <div>
        <label class="title"><?php echo $set4_farm ?></label>
        <li>
            <?php echo $set4_name ?>
            <input type="text" id="set4_inputname" name="name" value="<?php echo $userName?>" required pattern="[A-Za-z0-9]{1,}" disabled><br>
        </li>
    <li>
           <?php echo $set4_number ?>
        <input type="number" id="set4_inputnumber" name="number" value="<?php echo $userNumber?>" required disabled>
    </li>
        <li>
           <?php echo $set4_location ?>
        <input type="text" id="set4_inputLoc" name="name" value="<?php echo $userLoc?>" required disabled>
    </li>
    <li>
           <?php echo $set4_email ?>
        <input type="email" id="set4_inputemail" name="email" value="<?php echo $userEmail?>" required>
    </li>
        </div> <br>
            <label class="title"> <?php echo $set4_subtitle1 ?></label><br>
        <li>
            <?php echo $set4_lastup ?>
            <input type="date" id="set4_inputlast" name="lastinsemupdate" value="<?php $date = explode(' ',$row["Last_insemination_update"]); echo $date[0] ;?>"><br>
        </li>
    <li>
        <?php echo $set4_daysbefore ?>	
        <input type="number" id="set4_inputdays" name="daybefupdate" required min="1" max="31" value="<?php if($row["Days_to_the_warning_on_lack_of_update"]) echo $row["Days_to_the_warning_on_lack_of_update"] ; else echo 10;?>">
    </li>
    <li>
<input type="checkbox" id="day1" name="dayinsemupdate" <?php if( $row["DailyInseminationUpdate"]=='Yes' ) echo checked ?>><label  for="day1"><span></span><?php echo $set4_daily ?></label>
<input type="checkbox" id="day2" name="excfileinsem" <?php if( $row["ExcelfileInsemination"]=='Yes' ) echo checked ?>><label for="day2"><span></span><?php echo $set4_excel ?></label>
</li>
   
   <li>
<input type="checkbox" id="day3" name="showinsem" <?php if( $row["ShowInseminationSummary"]=='Yes' ) echo checked ?>><label for="day3"><span></span><?php echo $set4_show ?></label><br>
   </li><br>
<label class="title"><?php echo $set4_database ?></label><br>
     <li>
    <?php echo $set4_location ?>
    <input type="text" id="set4_locationtxt" name="folder" placeholder="<?php if($row["Folder"]) echo $row["Folder"] ; else echo "c:\Program Files\drorbreeding";?>"  required pattern="[A-Za-z0-9]{1,}" disabled><br>
    </li>
    <li>
    <?php echo $set4_backloc ?>
    <input type="text" id="set4_backuplocationtxt" name="folderback" placeholder="c:\Program Files\drorbreeding" required>
         <button class="button-upload location" >
         	<div class="dots-in-upload">...</div>
         	<input type="file" value="" class="uploadBtn-setting-input upload" onchange ="uploadFileFun(this.value)"/>
         </button>
        
    </li>
    <button class="submit" type="button" name="submit" id="updateDB5"><?php echo $set4_backup ?></button>
</form>
</div>

  <script>
  $(function () {
 //function updateDB()
  $('#updateDB5').click( function(){
 	    var data = {
 	    	func : 'updateSetting3',
 	    	user_id:$(this).parent().attr('user_id'),
 	    	lastinsemupdate: $(this).parent().find('[name=lastinsemupdate]').val(),
 	    	daybefupdate: $(this).parent().find('[name=daybefupdate]').val(),
 	    	dayinsemupdate:$(this).parent().find('[name=dayinsemupdate]')[0].checked,
 	    	excfileinsem:$(this).parent().find('[name=excfileinsem]')[0].checked,
 	    	showinsem:$(this).parent().find('[name=showinsem]')[0].checked,
 	    	folder:$(this).parent().find('[name=folder]').val(),
 	    	folderback:$(this).parent().find('[name=folderback]').val(),
 	    	email: $(this).parent().find('[name=email]').val()
 	    	};
            //var data = {"action":"test"};
            $.ajax({
	      type: "POST",
	      dataType: "json",
	      url: "ajax.php", //Relative or absolute path to response.php file
	      data: data,
	      success: function(data) {
        		location.reload();
      }
      
    });
    });
    });
   /* window.onbeforeunload = function (e) {
  var message = "Your confirmation message goes here.",
  e = e || window.event;
  // For IE and Firefox
  if (e) {
    e.returnValue = message;
  }

  // For Safari
  return message;
};*/
    </script>
</body>
</html>