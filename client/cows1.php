<?php
 include "navigationBar.php";
 include "alert.php";

 $db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$browserLanguage='en';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$username = $_COOKIE["user"];
//$userfarm=setUserFarm ('yeruham');
if(isset($_COOKIE["farm"])){
$userfarm=$_COOKIE["farm"];
} else {
$userfarm=getUserFarm ($db, $username);
}
//echo $userfarm;
$updatecowPhrase=getMsg($db, $browserLanguage, 'updateC');
$updatePhrase=getMsg($db, $browserLanguage, 'updateCows');
$createPhrase=getMsg($db, $browserLanguage, 'Create Future Insemination List');
$matchPhrase=getMsg($db, $browserLanguage, 'match');
$clearPhrase=getMsg($db, $browserLanguage, 'Clear');
$showPhrase=getMsg($db, $browserLanguage, 'show all');
$sendPhrase=getMsg($db, $browserLanguage, 'send to');
$set2_title=getMsg($db, $browserLanguage, 'set2_title');
$set2_subtitle1=getMsg($db, $browserLanguage, 'set2_subtitle1');
$set2_subtitle2=getMsg($db, $browserLanguage, 'set2_subtitle2');

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

$notesParameters=getMsg($db, $browserLanguage, 'notesParameters');


if(isset($_GET["order"])){
$order=$_GET["order"];
} else {
$order='brd_dau_fertilty  DESC';
}
 ?>
<!DOCTYPE html>
<html >

<head>
   <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
  <link rel="stylesheet" type="text/css" href="cows.css" />
  <link rel="stylesheet" type="text/css" href="popup.css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
/*$(document).ready(function(){
$("information").hide();});
$("#cow_pic").click(function (e) {
    $("#information").show();
    e.stopPropagation();
});*/
$(document).ready(function() {
$(".information").hide();
  // Bind click event to a link
  $("tr").click(function(e) {
    //e.preventDefault();
    //  Show my popup with slide effect, this can be a simple .show() or .fadeToggle()
    if( !$(e.target).is("[type=checkbox]")) {
    $(this).find('[class=information]').show();
    }
  /*  $(".cow_pic).toggle();*/
  });
  // Cancel the mouseup event in the popup
  $("#information").mouseup(function() {
    return false;
  });

  // Bind mouseup event to all the document
  $(document).mouseup(function(e) {
    // Check if the click is outside the popup
    if( !$(e.target).is("#information")) {
      // Hide the popup
     $(".information").hide();
    }
});
});


function showAll(){                               
//document.body.style.overflow ='scroll';
	if(document.myform.showall.value=='true'){
	document.myform.showall.value = 'false';
	return false;
	}
	else{
	document.myform.showall.value ='true';
	return true;
	}
  
}

</script>
</head>
<body >
<div class="content">
<form  name="myform" method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" onsubmit="showAll()">
    <ul>
        <li><?php echo $updatecowPhrase;?></li> 
    </ul>
      <ul>
       <a href="cows2.php"> <li id="createinsem"><?php echo $createPhrase;?></li></a>
    </ul>
      <ul>
       <a href="cows3.php"> <li id="preferedPhrase" style="color:red;"><?php echo $notesParameters;?></li></a>
    </ul>
</div>
<div class="wrapper">
<div class="sidebar" id="sidebar">
<h1><?php echo $updatePhrase;?></h1>
<input type="text" name="search" id="search" placeholder=" cows Name/Number" onkeypress=" searchKeyPress(event)" searchWord="<?php echo $searchNum['cow_no'] ?>">
<button class="submit" type="submit" id="find" name="find">Find</button>



        <table style="width:100%" id="heading" class="scroll">
        <thead>
            <tr>
        <td id="first" class="secttl"></td>
        <td class="secttl"><a href="cows1.php?order=cow_no"  style="text-decoration:none;color:#fff" >Cow number </a>
        <img id="arrow"src="/assets/arrow.png"></td>
       <!-- <td class="secttl"><a href="cows1.php?order=burn_no"  style="text-decoration:none;color:#fff" > burn number </a></td> -->
        <td class="secttl"><a href="cows1.php?order=Genetic_defect"  style="text-decoration:none;color:#fff" > DFG </a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl" ><a href="cows1.php?order=brd_dau_fertilty"  style="text-decoration:none;color:#fff" >Fertility</a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="cows1.php?order=lact_no"  style="text-decoration:none;color:#fff" >Lact. no. </a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="cows1.php?order=Last_insemination_no"  style="text-decoration:none;color:#fff" >Insem.no.</a><br><img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl" ><a href="cows1.php?order=match_status"  style="text-decoration:none;color:#fff" >Active?</a> </td>
        <td class="secttl"><a href="cows1.php?order=Forced_bull"  style="text-decoration:none;color:#fff" >Forced Bull</a> </td>
    </tr>
    </thead>
            <?php
 $i = 0;
           $_count = 11;
            if(isset($_POST['current'])) {
            $currentValue = explode(" ", $_POST['current']);
$offset =($currentValue[0] ) * 11;
}
else {
$offset = 0;
}

 $query="SELECT * FROM `local_cows`";

         /*   $count=0;
            $flag='true';
       if(!isset($_POST['showall']) || ($_POST['showall']=='false')){
	 $query="SELECT * FROM `local_cows` where Farm= '$userfarm' and match_status=1 and sex=2 order by $order limit 11"; // User_Id = '$username' and
        }
        else
        {
         $query="SELECT * FROM `local_cows` where Farm= '$userfarm' order by $order"; // User_Id = '$username' and
        }
        */
        
      /*  if(isset($_POST['current'])) {
            $currentValue = explode(" ", $_POST['current']);
$showAll =$currentValue[1];
}
*/
        //echo  $query;
       // $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
     //   $result = mysqli_query($db, $query);
               // $result_list = array();

if(isset($_POST['current'])) {
            $currentValue = explode(" ", $_POST['current']);
$showAll =$currentValue[1];
}

if(!empty($_REQUEST['search'])) {
	$search=$_POST['search'];
	$searchWords= explode(",", $search);
	
 	$query = $query." WHERE cow_no=-789 ";
 	foreach ($searchWords as $word){
 		$query= $query." OR cow_no=$word";
 	}

 	} else if(isset($_POST['showall']) or $showAll=='true'){
 	$query= $query." where Farm= '$userfarm' order by $order   LIMIT $offset, $_count";
 	//echo $query;
	  }
	  else if(!isset($_POST['showall']) or $showAll=='false')
	  	{
	  $query= $query."where Farm= '$userfarm' and match_status=1 and sex=2 order by $order   LIMIT $offset, $_count";
	  }
	//echo $query;
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result = mysqli_query($db, $query);
                $result_list = array();
         while($row = mysqli_fetch_array($result))
{
$result_list[] = $row;
$rowcount=mysqli_num_rows($result);
$index=$index+1;
$j=0;
$count=$count+1;
$breed=getBreedType($db,$row['sire']); 
 $result_list=ForcedBull($db,$username);
if($breed=='NR') $cowImg  = '../assets/nrf cow.jpg'; else if($breed=='HO') $cowImg ='../assets/holstein cow.jpg';else if($breed=='BS') $cowImg ='../assets/brownswiss-web-1.jpg'; else if($breed=='SM') $cowImg ='../assets/simmental01.jpg'; else if($breed=='JE') $cowImg ='../assets/jersey-web-1.jpg';  else if($breed=='FL') $cowImg ='../assets/flv cow.jpg'; else $cowImg ='/assets/iconcow.jpg';
 //echo "the result is";
 //print_r($result_list);
?>
<tbody>
<tr index='<?php echo $index?>'>
<td id="pic" >
     <input type="checkbox" name="checkbox" value="" class="checkbox"><img class="cow_pic" src="<?php  echo $cowImg ?>" height="30" width="38">
     <div id="information" class="information">

	<div class="tooltip_title">GENERAL INFORMATION</div>
	<div class="tooltip_pic" style="background:url('<?php echo $cowImg; ?>') no-repeat;background-size: 125px auto;background-position: 50%;"></div>
	<div class="tooltip_info1">
		<div class="tooltip_col1">

			<div>
				<?php echo $cows1; ?>: <span><?php echo $row["cow_no"] ;?></span>
			</div>
		</div>
		<div class="tooltip_col2">
			<div>
				<?php echo $popup_sire; ?> <span><?php echo $row["sire"] ;?></span>
			</div>
			<div>
				<?php echo $popup_PGS; ?> <span><?php echo $row["PGS"] ;?></span>
			</div>
			<div>
				<?php echo $popup_MGS ?> <span><?php echo $row["MGS"] ;?></span>
			</div>
			<div>
				<?php echo $popup_active; ?> <span><?php  if($row['match_status']==1){echo'Yes';}else{echo'No';};?></span>
			</div>
		</div>
	</div>
	<div class="tooltip_info2">
		<div class="tooltip_col1">
			  <div class="tooltip_sectititle">
				<?php echo $set2_subtitle1 ?> 
			</div>
			<div class="table_header">
				<div class="first_title">Traits</div>
				<div class="second_title">Value</div>
				<div class="third_title">60</div>
				<div class="third_title">70</div>
				<div class="third_title">80</div>
				<div class="third_title">90</div>
				<div class="third_title">100</div>
				<div class="third_title">110</div>
				<div class="third_title">120</div>
				<div class="third_title">130</div>
				<div class="third_title">140</div>

			</div>
			<div class="even">
				<div class="traits"><?php echo $set2_juris1; ?></div>
				<div class="value"><?php echo $row["brd_general_size"] ;?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_general_size'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val;  if($row['brd_general_size']<100) print_r( $mar.'px'); else echo '92px';?>"></div>
			</div>
			<div class="odd">
				 <div class="traits"><?php echo $set2_juris2; ?></div>
				 <div class="value"><?php echo $row["brd_udder"] ;?></div>
				 <div class="chart_value" style="width: <?php $val=2*abs(100-round($row['brd_udder'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val;  if($row['brd_udder']<100) print_r( $mar.'px'); else echo '92px';?>"></div>
			</div>
			<div class="even">
				<div class="traits"><?php echo $set2_juris3; ?></div>
				<div class="value"><?php echo $row["brd_Teats_placement"] ;?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_Teats_placement'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val;  if($row['brd_Teats_placement']<100) print_r( $mar.'px'); else echo '92px';?>"></div>
			</div>
			<div class="odd">
				<div class="traits"><?php echo $set2_juris4; ?></div>
				<div class="value"><?php echo $row["brd_Udder_depth"] ;?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_Udder_depth'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val;  if($row['brd_Udder_depth']<100) print_r( $mar.'px'); else echo '92px';?>"></div>
			</div>
			<div class="even">
				 <div class="traits"><?php echo $set2_juris5; ?> </div>
				 <div class="value"><?php echo $row["brd_legs"] ;?></div>
				 <div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_legs'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val;  if($row['brd_legs']<100) print_r( $mar.'px'); else echo '92px';?>"></div>
			</div>
			<div class="line first"></div>
			<div class="line second"></div>
			<div class="line third"></div>
			<div class="line fourth"></div>
			<div class="line fifth"></div>
			<div class="line sixth"></div>
			<div class="line seventh"></div>
			<div class="line eighth"></div>
			<div class="line ninth"></div>
		</div>
		<div class="tooltip_col2">
			  <div class="tooltip_sectititle">
			  <?php echo $set2_subtitle2 ?> 
			  <div class="table_header">
				<div class="first_title">Traits</div>
				<div class="second_title">Value</div>
				<div class="third_title">60</div>
				<div class="third_title">70</div>
				<div class="third_title">80</div>
				<div class="third_title">90</div>
				<div class="third_title">100</div>
				<div class="third_title">110</div>
				<div class="third_title">120</div>
				<div class="third_title">130</div>
				<div class="third_title">140</div>

			</div>
				
			</div>
			<div class="even">
				<div class="traits"><?php echo $set2_manufacture1; ?></div>
				<div class="value"><?php echo round($row["brd_milk_kg"]);?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_milk_kg'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val;  if($row['brd_milk_kg']<100) print_r( $mar.'px'); else echo '95px';?>"></div></div>
						<div class="odd">
				<div class="traits"><?php echo $set2_manufacture2; ?></div>
				<div class="value"><?php echo round($row["brd_fat_pre"])  ;?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_fat_pre'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val; if($row['brd_fat_pre']<100) print_r( $mar.'px'); else echo '95px';?>"></div></div>
							<div class="even">
				<div class="traits"><?php echo $set2_manufacture3; ?></div>
				<div class="value"><?php echo round($row["brd_prot_pre"]);?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_prot_pre'])); print_r( $val.'px');?> margin-left:<?php $mar=93-$val; if($row['brd_prot_pre']<100) print_r( $mar.'px'); else echo '95px';?>"></div></div>	
			<div class="line first"></div>
			<div class="line second"></div>
			<div class="line third"></div>
			<div class="line fourth"></div>
			<div class="line fifth"></div>
			<div class="line sixth"></div>
			<div class="line seventh"></div>
			<div class="line eighth"></div>
			<div class="line ninth"></div>
</div>
		<div class="tooltip_col2">	
	  <div class="tooltip_sectititle">
				<?php echo $set2_subtitle3 ?> 
				<div class="table_header">
				<div class="first_title">Traits</div>
				<div class="second_title">Value</div>
				<div class="third_title">60</div>
				<div class="third_title">70</div>
				<div class="third_title">80</div>
				<div class="third_title">90</div>
				<div class="third_title">100</div>
				<div class="third_title">110</div>
				<div class="third_title">120</div>
				<div class="third_title">130</div>
				<div class="third_title">140</div>

			</div>
			</div>
			<div class="even">
				<div class="traits"><?php echo $set2_manufacture4; ?></div>
				<div class="value"><?php echo round($row["brd_SCC"]);?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_SCC'])); print_r( $val.'px');?>;  margin-left:<?php $mar=93-$val; if($row['brd_SCC']<100) print_r( $mar.'px'); else echo '95px';?>"></div></div>
				<div class="even">
				<div class="traits"><?php echo $set2_manufacture5; ?></div>
				<div class="value"><?php echo round($row["brd_dau_fertilty"]);?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_dau_fertilty'])); print_r( $val.'px');?>;  margin-left:<?php $mar=93-$val; if($row['brd_dau_fertilty']<100) print_r( $mar.'px'); else echo '95px';?>"></div></div>
				<div class="even">
				<div class="traits"><?php echo $set2_juris6; ?></div>
				<div class="value"><?php echo round($row["brd_Ramp_stucture"]);?></div>
				<div class="chart_value" style="width:<?php $val=2*abs(100-round($row['brd_Ramp_stucture'])); print_r( $val.'px');?>; margin-left:<?php $mar=93-$val; if($row['brd_Ramp_stucture']<100) print_r( $mar.'px'); else echo '95px';?>"></div></div>
							<div class="line first"></div>
			<div class="line second"></div>
			<div class="line third"></div>
			<div class="line fourth"></div>
			<div class="line fifth"></div>
			<div class="line sixth"></div>
			<div class="line seventh"></div>
			<div class="line eighth"></div>
			<div class="line ninth"></div>

		</div>
	</div>
	
</div>

 </td>    
     <td name="cow_no" class="cow_no"><?php echo $row["cow_no"] ;?></td>
  <!--   <td><?php echo $row["burn_no"] ;?></td> -->
     <td><?php if($row["Genetic_defect"] == 0) {echo "Free" ;} else {echo "CVM";}?></td>
     <td><?php echo $row["brd_dau_fertilty"] ;?></td>
     <td>
<select name="lactno" id="lactno" class="lactno">
<option value="<?php echo $row['lact_no'] ;?>"><?php echo $row['lact_no'];?></option>
<?php 
for ($x = 0; $x <= 15; $x++) { ?>
   <option value='<?php echo "$x"; ?>'><?php echo "$x";?></option>
  <?php } ?> 
  </select></td>
       <td>
<select name="Insemno">
<option value="<?php echo $row['Last_insemination_no'] ;?>"><?php echo $row['Last_insemination_no'];?></option>
<?php 
for ($x = 0; $x <= 20; $x++) { ?>
   <option value='<?php echo "$x";?>'><?php echo "$x";?>
  <?php } ?> 
  </select></td>
    <td>
<select name="active">
<option value="<?php echo $row['match_status'] ;?>"><?php  if($row['match_status']==1){echo'Yes';} elseif($row['match_status']==0){echo'No';};?></option>
  <option value="1">Yes</option>
  <option value="0">No</option>
  </select></td>
 <!-- <td> <select name="ForcedBull">
 <option value="<?php echo $row['Forced_bull'] ;?>"><?php if($row['Forced_bull']==1){echo 'Yes';} elseif($row['Forced_bull']==0) {echo 'No';};?></option>
  <option value="1">Yes</option>
  <option value="0">No</option>
  </select></td> -->
   <td> <select name="ForcedBull">
 <option value="<?php echo $row['Forced_bull'] ;?>"><?php if($row['Forced_bull']=='') {echo "Forced bull"; }else {echo $row['Forced_bull']  ;}?></option>
 <?php
    foreach($result_list as $row) { 
    $i=$row["bull_no"];
    ?>
    
    <option value='<?php print_r($i);?>'><?php print_r($i);?></option>
<?php } ?>
?>
  </select></td>
<?php } ?>

    </tr>
</table>
<div class="button">
<button class="submit" type="submit" name="current" value="<?php if(!isset($_POST['current']) or $_POST['current']==0) {echo 0;} else {$currentValue = explode(" ", $_POST['current']); print_r ($currentValue[0]-1);} echo ' '; if(isset($_POST['showall'])) {echo 'true';} else if(isset($_POST['current'])) { $currentValue = explode(" ", $_POST['current']);  print_r($currentValue[1]);} else {echo 'false';}?> "><</button>
<button class="submit" type="submit" name="current" value="<?php if(!isset($_POST['current'])) {echo 1;}  else {$currentValue = explode(" ", $_POST['current']); print_r ($currentValue[0]+1);} echo ' '; if(isset($_POST['showall'])) {echo 'true';} else if(isset($_POST['current'])) { $currentValue = explode(" ", $_POST['current']); print_r($currentValue[1]);} else {echo 'false';}?> ">></button>
   <button class="submit" type="button" onClick="history.go(0)" name="submit" value="submit"><?php echo $clearPhrase;?></button>
    <a href="dailyActivity.php?"  style="text-decoration:none;" id="matchHref"><button class="submit" type="button" value="submit" id="match"><?php echo $matchPhrase;?></button></a>
    <button class="submit" type="submit" name="showall" value="<?php if(!isset($_POST['showall'])) {echo 'false';} else {echo $_POST['showall'];}?>" ><?php echo $showPhrase;?></button>
    <button class="submit" type="button" id="updateDB">Save</button> 

</div>


</form>
 </div>
 </div>
 <p id="qw"></p>
  <script>
  $(function () {
  $('#stiker').click( function(){
        var ws = new ActiveXObject("WScript.Shell");
        ws.Run("/assets/DLS.exe");
   });
   })
    $(function () {
   $('#updateDB').click( function(){
   //alert("hello world");
  var elem = $(this).parent().parent().find('[name=checkbox]');
  for (var i=0;i< elem.length; i++){
  	index=i+1;
  	if(elem[i].checked){
 	    var data = {
 	    	func : 'updateCows',
 	    	cow_no: $(this).parent().parent().find('[index='+index+']').find('[name=cow_no]').text(),
 	    	lactno: $(this).parent().parent().find('[index='+index+']').find('[name=lactno]').val(),
 	    	active:$(this).parent().parent().find('[index='+index+']').find('[name=active]').val(),
 	    	Insemno:$(this).parent().parent().find('[index='+index+']').find('[name=Insemno]').val(),
 	    	ForcedBull:$(this).parent().parent().find('[index='+index+']').find('[name=ForcedBull]').val(),
 	    	};
            //var data = {"action":"test"};
            $.ajax({
	      type: "POST",
	      dataType: "json",
	      url: "ajax.php", //Relative or absolute path to response.php file
	      data: data,
	      success: function(data) {
               //alert("hi how are you"+data);

        location.reload();
      }
    });
    }
    }
    });
      $('#match').click( function(){
  	query = '';
  	j=0;
  	for(i=0;i<$('.checkbox').length; i++){
  	 
  	if($('.checkbox')[i].checked==true){
		query = query + '&'+j+'=' + $(".cow_no")[i].textContent;
		j++;
		}
		}
  	$("#matchHref").attr("href", "dailyActivity.php?"+query+"&match=true");
    });
    	if($("#search").attr("searchWord")!='')
	$('td:contains('+$("#search").attr("searchWord")+')').parent().addClass('chosen');
  //getInputsByValue($('#search').attr('searchWord')).addClass('chosen');
  $(function () {
   var sendToUpdate=[];
  $("select").change(function() {
  //alert( "Handler for .change() called." );
  var found = jQuery.inArray($(this).parent().parent().find('[name=cow_no]').text(), sendToUpdate);
if (found == -1) {
  sendToUpdate.push($(this).parent().parent().find('[name=cow_no]').text());
  }
});
 })
 })
   </script>
   <script>
   var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;
   </script>
</body>
</html>
<?php 
/*
 if(isset($_POST['showall'])){
   $flag='false';
 }
 
   if(isset($_POST['Sticker'])){
        include 'sticker.php';
     }*/
     
    function updatelactn($lactno)
    {
     echo "the name is".$lactno;
    }
    if(isset($_POST['submit'])){
     $a=array();
    for($i=0; $i>5; $i++){
    $a[i]=$_POST["lactno"];
    }
 $selectLactno = $_POST["lactno"]; 
 $selectInsem = $_POST["Insemno"];
 $selectActive = $_POST["active"];
 echo "<br>the lact number is ".$selectLactno;
 echo "<br>the insem number is ".$selectInsem;
 echo "<br>the active number is ".$selectActive;
  } 
  for ($x = 0; $x <= 4; $x++) {
  }
  function ForcedBull($db,$username)
  {
  $query="SELECT b.bull_no,
CASE WHEN u.match_status!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.match_status
ELSE b.Match_status
END AS Match_status 
FROM  `bulls_details` AS b
LEFT JOIN  `users_bulls_details` AS u ON b.bull_no = u.bull_no  WHERE (ISNULL(u.match_status) AND b.match_status=1) OR (u.match_status=1  AND u.userID = '$username')";
        $result = mysqli_query($db, $query);
        $result_list = array();
         while($row = mysqli_fetch_array($result)) {
         $result_list[] = $row;    
}
  return $result_list;
}
 ?>