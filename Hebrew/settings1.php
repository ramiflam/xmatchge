<?php
include "settings.php";
$browserLanguage='he';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$activePhrase=getMsg($db, $browserLanguage, 'Active Genetic Plan');
$preferedPhrase=getMsg($db, $browserLanguage, 'Prefered Characteristics');
$GenPhrase=getMsg($db, $browserLanguage, 'General Bulls Matching Settings');
$GenfarmPhrase=getMsg($db, $browserLanguage, 'General Farm Settings');
$manualPhrase=getMsg($db, $browserLanguage, 'Manual Import');
$set1_label=getMsg($db, $browserLanguage, 'set1_label');
$set1_select1=getMsg($db, $browserLanguage, 'set1_select1');
$set1_select2=getMsg($db, $browserLanguage, 'set1_select2');
$set1_select3=getMsg($db, $browserLanguage, 'set1_select3');
$set3_backup=getMsg($db, $browserLanguage, 'set4_backup');
$query="SELECT program_plan_no FROM `user_settings` WHERE `user_id`='$username'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
 ?>
<!DOCTYPE html>
<html>
<head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  </head>
<body>

	<script>
		$( window ).unload(function() {
			alert("רוצה לצאת");
			
		});
	</script>

   <div class="sidebar" user_id="<?php echo $username?>">
       <h1><?php echo $activePhrase ?></h1><br><br><br>
	<label></label>
	
	<select id="mySelect" onchange="change()" onload="loadd" value="<?php $row['program_plan_no']?>">
	<option value="1" <?php if($row['program_plan_no']==1) echo selected?> ><?php echo $set1_select1?></option>
	<option value="2" <?php if($row['program_plan_no']==2) echo selected?>><?php echo $set1_select2?></option>
	<option value="3" <?php if($row['program_plan_no']==3) echo selected?>><?php echo $set1_select3?></option>
	<option value="4" <?php if($row['program_plan_no']==4) echo selected?> ><?php echo"Pure Montbeliard" ?></option>
	<option value="5" <?php if($row['program_plan_no']==5) echo selected?>><?php echo "Pure Jersey" ?></option>
	<option value="6" <?php if($row['program_plan_no']==6) echo selected?>><?php echo "Pure Brown Swiss" ?></option>
	</select>
	
	<div class="imgSelect" id="imgSelect">
	
    </div>
    <button class="submit" type="button" id="updateDB"><?php echo $set3_backup ?></button>
    <script>
    /*
    window.onload = function() {
     function() loadd{
     
         if(document.getElementById("mySelect").value == "1"){
            	imgSelect = document.getElementById("imgSelect");
            	imgSelect.style.background ='url( "/assets/graph.jpg")  left top no-repeat';
            	imgSelect.style.backgroundSize = "320px auto";
            } else 
            if(document.getElementById("mySelect").value == "2"){
            	imgSelect = document.getElementById("imgSelect");
            	imgSelect.style.background ='url( "/assets/Twoplus extra fitness plan.jpg") left top no-repeat';
            	imgSelect.style.backgroundSize = "300px auto";
            } else imgSelect.style.background = '';
    };
    };*/
    if(document.getElementById("mySelect").value == "1"){
            	imgSelect = document.getElementById("imgSelect");
            	imgSelect.style.background ='url( "/assets/graph1.jpg") 320px right no-repeat';
            	imgSelect.style.backgroundSize = " 320px auto";
            } else 
            if(document.getElementById("mySelect").value == "2"){
            	imgSelect = document.getElementById("imgSelect");
            	imgSelect.style.background ='url( "/assets/Twoplus extra fitness plan.jpg") right top no-repeat';
            	imgSelect.style.backgroundSize = "300px auto";
            } else imgSelect.style.background = '';
        function change(){
            if(document.getElementById("mySelect").value == "1"){
            	imgSelect = document.getElementById("imgSelect");
            	imgSelect.style.background ='url( "/assets/graph1.jpg") right top no-repeat';
            	imgSelect.style.backgroundSize = " 320px auto";
            } else 
            if(document.getElementById("mySelect").value == "2"){
            	imgSelect = document.getElementById("imgSelect");
            	imgSelect.style.background ='url( "/assets/Twoplus extra fitness plan.jpg") right top no-repeat';
            	imgSelect.style.backgroundSize = "300px auto";
            } else imgSelect.style.background = '';

            }
           $('#updateDB').click( function(){
             var data = {
            	func:"updateSetting1",
            	user_id:$(this).parent().attr('user_id'),
            	program_plan_no: $(this).parent().find('[id=mySelect]').val()
            };
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
/*window.onbeforeunload = function (e) {
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