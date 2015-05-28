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

$set3_young=getMsg($db, $browserLanguage, 'set3_young');
$set3_meat=getMsg($db, $browserLanguage, 'set3_meat');
$set3_cross=getMsg($db, $browserLanguage, 'set3_cross');
$set3_test=getMsg($db, $browserLanguage, 'set3_test');
$set3_lact=getMsg($db, $browserLanguage, 'set3_lact');
$set3_up=getMsg($db, $browserLanguage, 'set3_up');
$set3_first=getMsg($db, $browserLanguage, 'set3_first');
$set3_last=getMsg($db, $browserLanguage, 'set3_last');
$set3_forbid=getMsg($db, $browserLanguage, 'set3_forbid');
$set3_backup=getMsg($db, $browserLanguage, 'set3_backup');
$set4_backup=getMsg($db, $browserLanguage, 'set4_backup');

$query="SELECT * FROM `user_settings` WHERE `user_id`='$username'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

$query2="SELECT COUNT( last_milk_per_day ) AS count FROM  `local_cows` WHERE 1";
$result2 = mysqli_query($db, $query2);
$row2 = mysqli_fetch_array($result2);
?>
<html>
<body dir="rtl">
<script>

 function showVal(newVal,elmName, elmNameVal){
  	 var slider3Val = document.getElementById('slider1').getAttribute('max') - document.getElementById('slider1').value - document.getElementById('slider2').value;
	 
	  document.getElementById(elmName).innerHTML= Math.round(newVal/document.getElementById('slider1').getAttribute('max') * 100) + '%';
	  document.getElementById(elmNameVal).innerHTML='('+ newVal + ')';
	  if(slider3Val >= 0){
	  document.getElementById('valBox4').innerHTML= Math.round(slider3Val/document.getElementById('slider1').getAttribute('max') * 100) + '%';
	  document.getElementById('valBox41').innerHTML='('+ slider3Val + ')';
	  document.getElementById('slider3').value = slider3Val;
	 } else {
	  document.getElementById('slider3').value = 0;
	 }
}

</script>
<div class="farmsetting">
<form  name="set"  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" user_id="<?php echo $username?>">
    <h1> <?php echo $GenPhrase; ?></h1>
 
    <table>
        <tr>
            <th id="settings5"><?php echo $set3_young ?></th>
            <td>
		<span class="sliderVal" id="valBox1"><?php echo round($row["Bulls_usage_young_bulls"]/$row2[count]*100) ?>%</span>
		<span class="sliderVal2" id="valBox11">(<?php echo $row["Bulls_usage_young_bulls"] ?>)</span>
            <input type="range"id="slider1" value="<?php echo $row["Bulls_usage_young_bulls"] ?>" name="Bulls_usage_young_bulls" min=0 max=<?php echo $row2[count] ?> oninput="showVal(this.value, 'valBox1' , 'valBox11')" onchange="showVal(this.value, 'valBox1', 'valBox11')"/>
            </td>
        </tr>
           <tr>
            <th id="settings5"><?php echo $set3_meat ?></th>
            <td>
            <span class="sliderVal" id="valBox2"><?php echo round($row["Bulls_usage_meat_bulls"]/$row2[count]*100) ?>%</span>
            <span class="sliderVal2" id="valBox21">(<?php echo $row["Bulls_usage_meat_bulls"] ?>)</span>
         <input type="range" id="slider2" value="<?php echo $row["Bulls_usage_meat_bulls"] ?>" name="Bulls_usage_meat_bulls" min=0 max=<?php echo $row2[count] ?> oninput="showVal(this.value, 'valBox2', 'valBox21')" onchange="showVal(this.value, 'valBox2', 'valBox21')" />       
            </td>
        </tr>

                  <tr>
            <th id="settings5"><?php echo $set3_test ?></th>
            <td>
            <span class="sliderVal" id="valBox4"><?php echo  round(($row2[count]-$row["Bulls_usage_young_bulls"]-$row["Bulls_usage_meat_bulls"])/$row2[count]*100)?>%</span>
            <span class="sliderVal2" id="valBox41">(<?php echo $row2[count]-$row["Bulls_usage_young_bulls"]-$row["Bulls_usage_meat_bulls"] ?>)</span>
        <input type="range" id="slider3" value="<?php echo $row2[count]-$row["Bulls_usage_young_bulls"]-$row["Bulls_usage_meat_bulls"]?>" name="" min=0 max=<?php echo $row2[count] ?> oninput="" onchange=""/>
            </td>
        </tr>
<tr>
    <th id="settings5"><?php echo $set3_lact ?></th>
    <td>
<select name="Meat_bulls_lactation_no">
  <option value="1" <?php if($row['Meat_bulls_lactation_no']=="1") echo selected?> >1</option>
  <option value="2" <?php if($row['Meat_bulls_lactation_no']=="2") echo selected?> >2</option>
  <option value="3" <?php if($row['Meat_bulls_lactation_no']=="3") echo selected?> >3</option>
  <option value="4" <?php if($row['Meat_bulls_lactation_no']=="4") echo selected?> >4</option>
  <option value="5" <?php if($row['Meat_bulls_lactation_no']=="5") echo selected?> >5</option>
  <option value="6" <?php if($row['Meat_bulls_lactation_no']=="6") echo selected?> >6</option>
  <option value="7" <?php if($row['Meat_bulls_lactation_no']=="7") echo selected?> >7</option>
  <option value="8" <?php if($row['Meat_bulls_lactation_no']=="8") echo selected?> >8</option>
  <option value="9" <?php if($row['Meat_bulls_lactation_no']=="9") echo selected?> >9</option>
  <option value="10" <?php if($row['Meat_bulls_lactation_no']=="10") echo selected?> >10</option>
</select>
    </td>
    <th id="settings5"><?php echo $set3_up ?></th>
    <td>
<select title="Ask an expert!" onchange="if(this.value!='10%') document.getElementById('tooltip').style.display = 'block'; else document.getElementById('tooltip').style.display = 'none';">
  <option value="5%">5%</option>
  <option value="10%" selected>10%</option>
  <option value="15%">15%</option>
  <option value="20%">20%</option>
  <option value="25%">25%</option>
  <option value="30%">30%</option>
  <option value="35%">35%</option>
  <option value="40%">40%</option>
  <option value="45%">45%</option>
  <option value="50%">50%</option>
</select>
<div class="tooltip" id="tooltip">Ask an expert!</div>
    </td>
 </tr>

  <tr>
    <th id="settings5"><?php echo $set3_first ?></th>
    <td>
        <input type="date" name="Bulls_first_insemination_date" required value="<?php $date = explode(' ',$row["Bulls_first_insemination_date"]); echo $date[0] ;?>">
    </td>
 </tr>
  <tr>
    <th id="settings5"><?php echo $set3_last ?></th>
    <td>
        <input type="date" name="Bulls_last_insemination_date" value="<?php $date = explode(' ',$row["Bulls_last_insemination_date"]); echo $date[0] ;?>" required>
    </td>
 </tr>
  <tr>
    <th id="settings5"><?php echo $set3_forbid ?></th>
    <td>
     <input type="text" name="name" placeholder="Raffaello" required>   
    </td>
 </tr>
    </table><br>
       <button class="submit" type="button" id="updateDB5"><?php echo $set4_backup ?></button>
       <div>
 	
</div>
  <script>
  var flag = 0;
  $(function () {
 //function updateDB()
  $('#updateDB5').click( function(){
 	    var data = {
 	    	func : 'updateSetting5',
 	    	user_id:$(this).parent().attr('user_id'),
 	    	Bulls_usage_young_bulls: $(this).parent().find('[name=Bulls_usage_young_bulls]').val(),
 	    	Bulls_usage_meat_bulls: $(this).parent().find('[name=Bulls_usage_meat_bulls]').val(),
 	    	//dayinsemupdate:$(this).parent().find('[name=dayinsemupdate]')[0].checked,
 	    	Bulls_first_insemination_date:$(this).parent().find('[name=Bulls_first_insemination_date]').val(),
 	    	Bulls_last_insemination_date:$(this).parent().find('[name=Bulls_last_insemination_date]').val(),
 	    	Meat_bulls_lactation_no:$(this).parent().find('[name=Meat_bulls_lactation_no]').val()
 	    	//folderback:$(this).parent().find('[name=folderback]').val()
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
    if (flag == 0){
    /*window.onbeforeunload = function (e) {
  var message = "You did not save your data",
  e = e || window.event;
  // For IE and Firefox
  if (e) {
    e.returnValue = message;
  }

  // For Safari
  return message;
};*/
};
    </script>