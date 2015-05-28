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
$set2_title=getMsg($db, $browserLanguage, 'set2_title');
$set2_subtitle1=getMsg($db, $browserLanguage, 'set2_subtitle1');
$set2_subtitle2=getMsg($db, $browserLanguage, 'set2_subtitle2');
$set2_subtitle3=getMsg($db, $browserLanguage, 'set2_subtitle3');

$set2_juris1=getMsg($db, $browserLanguage, 'set2_juris1');
$set2_juris2=getMsg($db, $browserLanguage, 'set2_juris2');
$set2_juris3=getMsg($db, $browserLanguage, 'set2_juris3');
$set2_juris4=getMsg($db, $browserLanguage, 'set2_juris4');
$set2_juris5=getMsg($db, $browserLanguage, 'set2_juris5');
$set2_juris6=getMsg($db, $browserLanguage, 'set2_juris6');
$set2_juris7=getMsg($db, $browserLanguage, 'set2_juris7');

$set2_manufacture1=getMsg($db, $browserLanguage, 'set2_manufacture1');
$set2_manufacture2=getMsg($db, $browserLanguage, 'set2_manufacture2');
$set2_manufacture3=getMsg($db, $browserLanguage, 'set2_manufacture3');
$set2_manufacture4=getMsg($db, $browserLanguage, 'set2_manufacture4');
$set2_manufacture5=getMsg($db, $browserLanguage, 'set2_manufacture5');
$set4_backup=getMsg($db, $browserLanguage, 'set4_backup'); 

$query="SELECT * FROM `user_settings` WHERE `user_id`='$username'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
 ?>
<!DOCTYPE html>
<html>
<body dir="rtl">
<div class="sidebar" user_id="<?php echo $username?>">
    <h1><?php echo $set2_title ?></h1>
<table style="width:55%">
                    <tr>
                
               <th><?php echo $set2_subtitle1 ?></th>
                <th><?php echo $set2_subtitle2 ?></th>  
                
            </tr>
        <td id="first">
<input type="checkbox" id="juris1" <?php if( $row["Match_judgment_general_size"]==1 ) echo checked ?> name="size"/><label for="juris1"><span></span><?php echo $set2_juris1 ?></label><br>
<input type="checkbox" id="juris2" <?php if( $row["Match_judgment_general_udder"]==1 ) echo checked ?>  name="udder"/><label for="juris2"><span></span><?php echo $set2_juris2 ?></label><br>
<input type="checkbox" id="juris3" <?php if( $row["Match_judgment_teats_location"]==1 ) echo checked ?>  name="teatsPlacments"/><label for="juris3"><span></span><?php echo $set2_juris3 ?></label><br>
<input type="checkbox" id="juris4" <?php if( $row["Match_judgment_udder_depth"]==1 ) echo checked ?>  name="udderDepth"/><label for="juris4"><span></span><?php echo $set2_juris4 ?></label><br>
<input type="checkbox" id="juris5" <?php if( $row["Match_judgment_general_legs"]==1 ) echo checked ?>  name="legs"/><label for="juris5"><span></span><?php echo $set2_juris5 ?></label><br>

    <input type="checkbox" id="juris7" <?php if( $row["Match_judgment_overall_grade"]==1 ) echo checked ?>  name="generalRating"/><label for="juris7"><span></span><?php echo $set2_juris7 ?></label>

        </td>
        <td id="second">
            <div><input type="checkbox" id="manufacture1" name="milk" <?php if( $row["Match_production_KGmilk"]==1 ) echo checked ?>   ><label for="manufacture1"><span></span><?php echo $set2_manufacture1 ?></label><br></div>
            <div><input type="checkbox" id="manufacture2" name="fat" <?php if( $row["Match_production_fat_per"]==1 ) echo checked ?>   ><label for="manufacture2"><span></span><?php echo $set2_manufacture2 ?></label><br></div>
            <div><input type="checkbox" id="manufacture3" name="protein" <?php if( $row["Match_production_protein_per"]==1 ) echo checked ?>  ><label for="manufacture3"><span></span><?php echo $set2_manufacture3 ?></label><br></div>
            
            
          <div  id="reproduc" name="" ><label id="reproduc"><?php echo $set2_subtitle3 ?></label><br> </div>                                         
            
            
            <div><input type="checkbox" id="manufacture4" name="scc" <?php if( $row["Match_production_SCC"]==1 ) echo checked ?>  ><label for="manufacture4"><span></span><?php echo $set2_manufacture4 ?></label><br></div>
            <div><input type="checkbox" id="manufacture5" name="fertility" <?php if( $row["Match_production_fertility"]==1 ) echo checked ?>  ><label for="manufacture5"><span></span><?php echo $set2_manufacture5 ?></label></div><br>
            <input type="checkbox" id="juris6" <?php if( $row["Match_judgment_pelvis_stucture"]==1 ) echo checked ?>  name="pelvicStructure"/><label for="juris6"><span></span><?php echo $set2_juris6 ?></label><br>
       
     </td>
        </table><br>
        <button class="submit" type="button" name="button" id="updateDB2"><?php echo $set4_backup ?></button>
 

</div>

  <script>
  $(function () {
 //function updateDB()
  $('#updateDB2').click( function(){
 	    var data = {
 	    	func : 'updateSetting2',
 	    	user_id:$(this).parent().find('[class=sidebar]').attr('user_id'),
 	    	size: $(this).parent().find('[name=size]')[0].checked,
 	    	udder: $(this).parent().find('[name=udder]')[0].checked,
 	    	teatsPlacments: $(this).parent().find('[name=teatsPlacments]')[0].checked,
 	    	udderDepth:$(this).parent().find('[name=udderDepth]')[0].checked,
 	    	legs:$(this).parent().find('[name=legs]')[0].checked,
 	    	pelvicStructure:$(this).parent().find('[name=pelvicStructure]')[0].checked,
 	    	generalRating:$(this).parent().find('[name=generalRating]')[0].checked,
 	    	milk :$(this).parent().find('[name=milk ]')[0].checked,
 	    	fat:$(this).parent().find('[name=fat]')[0].checked,
 	    	protein :$(this).parent().find('[name=protein]')[0].checked,
 	    	scc:$(this).parent().find('[name=scc]')[0].checked,
 	    	fertility:$(this).parent().find('[name=fertility]')[0].checked
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