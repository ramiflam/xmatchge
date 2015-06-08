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

if(isset($_GET["order"])){
$order=$_GET["order"].',';
} else {
$order='';
}
 /* 
if(!empty($_REQUEST['search'])) {
   //if(isset($_POST['find'])){
$search=$_POST['search'];
 $sql = "SELECT * FROM `bulls_details` WHERE bull_no LIKE '%".$search."%' "; 
        $searchResult = mysqli_query($db, $sql);
                $result_list = array();
                $searchRow= mysqli_fetch_array($searchResult );
         while($searchRow)
{
$result_list[] = $searchRow;
echo '<br />bull number: ' .$searchRow['bull_no'];  
echo '<br /> bull name: ' .$searchRow['bull_name']; 
} 
}
else 
{
//echo "imnot succeeddd";
}
*/
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="bulls.css" />

</head>
<div class="content">
    <ul>
        <a href=""><li>Bulls</li> </a>
    </ul>
    <ul>
        <a href=""><li id="insemlist">Manual Update of Inseminations</li> </a>
    </ul>
</div>
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
function showAll(){                               
	//if(document.myform.showall.value=='true'){
	//document.myform.showall.value = 'false';
	//return false;
	//}
	//else{
	document.myform.showall.value ='true';
	//return true;
	//}
  
}
$(document).ready(function() {
//$(".information").hide();
  // Bind click event to a link
  $(".bull_pic").click(function(e) {
    e.preventDefault();
    //  Show my popup with slide effect, this can be a simple .show() or .fadeToggle()
    $(this).parent().find('[class=information]').toggle();
  /*  $(".cow_pic).toggle();*/
  });
  // Cancel the mouseup event in the popup
  $("#information").mouseup(function() {
    return false
  });
  
  // Bind mouseup event to all the document
  $(document).mouseup(function(e) {
    // Check if the click is outside the popup
   // if($(e.target).parents("#information").length==0 && !$(e.target).is("#information")) {
      // Hide the popup
     $(".information").hide();
   // }
});
});
</script>
<div class="wrapper">
<div class="sidebar">
<form id="bullsForm" name="myform" method="post"   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); if(isset($_GET["order"])){ echo '?order='.$_GET["order"];} ?>" onsubmit="showAll()" user="<?php echo $username = $_COOKIE["user"];?>">
    <h1>BULLS</h1><div class="input">
<input type="text" name="search" id="search" placeholder="bulls Name/Number" onkeypress=" searchKeyPress(event)" searchWord="<?php echo $searchNum['bull_no'] ?>">
<button class="submit" type="submit" id="find" name="find">Find</button></div>
<div class="bull">
<label id="show">show:</label>
<button class="submit" type="submit" id="bull1" name="showall" value="<?php if(!isset($_POST['showall'])) {echo 'false';} else {echo 'true';}?>" >All Bulls</button>
<button class="submit" type="submit" id="bull2" value="<?php if(isset($_POST['showall'])) {echo 'false';} else {echo 'true';}?>" > Active?</button>

</div>
	<div id="table">
        <table id="heading" class="scroll">
        <thead>
           <tr>
                <th colspan="2"id="first"></th>
               <th colspan="5">Bull ID & characteristic </th>
                <th colspan="7">Matching Settings </th>  
               <th colspan="5">Status </th>
            </tr>
       
            <tr id=tr2>

        <td id="first" class="secttl"style="border-right: 1px solid #fff;"></td>
       
        <td class="secttl"><a href="bulls.php?order=bull_no"  style="text-decoration:none;color:#fff" >Number<a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="bulls.php?order=bull_foreign_name"  style="text-decoration:none;color:#fff" >Name<a><br>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="bulls.php?order=breed"  style="text-decoration:none;color:#fff" >Breed<a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl" id="color"><a href=""  style="text-decoration:none;color:#fff" >Straw Color<a></td>
        <!--<td class="secttl" id="color"><a href="bulls.php?order=StrawSize"  style="text-decoration:none;color:#fff" >Straw Size<a></td>-->
        <td class="secttl"  id="color" id="head" style="border-right: 1px solid #fff;"><a href="bulls.php?order=StrawType"  style="text-decoration:none;color:#fff" >Straw Type<a><img id="arrow"src="/assets/arrow.png"></td>
        
        <td class="secttl"><a href="bulls.php?order=Order_by_Fertility"  style="text-decoration:none;color:#fff" >Order By<a>
        <img id="arrow"src="/assets/arrow.png"align="middle"></td>
        <td class="secttl"><a href="bulls.php?order=Match_status"  style="text-decoration:none;color:#fff" >Active?<a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl" id="color"><a href="bulls.php?order=Heifer_status"  style="text-decoration:none;color:#fff" >For Calf<a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="bulls.php?order=Planned_usage"  style="text-decoration:none;color:#fff" >Planned %<a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="bulls.php"  style="text-decoration:none;color:#fff" >Actual %<a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"  id="last" ><a href="bulls.php?order=Limited"  style="text-decoration:none;color:#fff" >Limited<a>
<img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl" style="border-right: 1px solid #fff;"><a href="bulls.php?order=Actuall_inseminations"  style="text-decoration:none;color:#fff" >Actual Insem. No.<a><img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="bulls.php?order=From_insemination"  style="text-decoration:none;color:#fff" >From Service<a>
        <img id="arrow"src="/assets/arrow.png"></td>
        <td class="secttl"><a href="bulls.php?order=To_insemination"  style="text-decoration:none;color:#fff" >To Service<a>
        <img id="arrow"src="/assets/arrow.png"></td>
       
    </tr>
    </thead>
	<tbody style="background-color: white;">

     <div class="tblcontent">
     <?php $i = 0;?>
    
            <?php
            $_count = 10;
            if(isset($_POST['current'])) {
            $currentValue = explode(" ", $_POST['current']);
$offset =($currentValue[0] ) * 10;
}
else {
$offset = 0;
}
            $username = $_COOKIE["user"];
  

	 $query="SELECT b.bull_no, bull_name, CVM, KG_ECM, Actuall_inseminations, Usage_order, General_size, General_udder, Teats_location, Udder_depth, General_legs, Pelvis_stucture, Fat_percentage, Protein_percentage, MGS, PGS, SCC, sire, pic_link, breed,bull_foreign_name,
CASE WHEN u.match_status!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.match_status
ELSE b.Match_status
END AS Match_status, 
CASE WHEN u.heifer_status!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.heifer_status
ELSE b.Heifer_status
END AS Heifer_status, 
CASE WHEN u.from_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.from_insemination
ELSE b.From_insemination
END AS From_insemination, 
CASE WHEN u.to_insemination!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.to_insemination
ELSE b.To_insemination
END AS To_insemination, 
CASE WHEN u.limited!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.limited
ELSE b.Limited
END AS Limited, 
CASE WHEN u.straw_color!=''
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.straw_color
ELSE b.StrawColor
END AS StrawColor, 
CASE WHEN u.straw_size!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.straw_size
ELSE b.StrawSize
END AS StrawSize, 
CASE WHEN u.straw_type!=''
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.straw_type
ELSE b.StrawType
END AS StrawType, 
CASE WHEN u.order_by!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.order_by
ELSE b.Order_by_Fertility
END AS Order_by_Fertility,
CASE WHEN u.planned!=-1
AND u.bull_no = b.bull_no
AND u.userID =  '$username'
THEN u.planned
ELSE b.Planned_usage
END AS Planned_usage
FROM  `bulls_details` AS b
LEFT JOIN  `users_bulls_details` AS u ON b.bull_no = u.bull_no ";

if(isset($_POST['current'])) {
            $currentValue = explode(" ", $_POST['current']);
$showAll =$currentValue[1];
}

if(!empty($_REQUEST['search'])) {
   /*if(isset($_POST['find'])){*/
	$search=$_POST['search'];
	$searchWords= explode(",", $search);
	
 	$query = $query." WHERE (b.bull_no=-1 ";
 	foreach ($searchWords as $word){
 		$query= $query." OR b.bull_no=$word";
 	}
	$query= $query.") AND (u.userID = '$username' OR '$username' NOT IN (select userID from `users_bulls_details` where $word = bull_no))";
 	} else if(isset($_POST['showall']) or $showAll=='true'){
 	$query= $query." WHERE u.userID = '$username' OR '$username' NOT IN (select userID from `users_bulls_details` where b.bull_no = bull_no) ORDER BY $order Order_by_Fertility, FIELD(breed, 1,39) DESC, breed , bull_no  LIMIT $offset, $_count";
	  }
	  else if(!isset($_POST['showall']) or $showAll=='false')
	  	{
	  $query= $query." WHERE (ISNULL(u.match_status) AND b.match_status=1) OR (u.match_status=1  AND u.userID = '$username') ORDER BY $order Order_by_Fertility, FIELD(breed, 1,39) DESC, breed , bull_no LIMIT $offset, $_count";
	  }
	//echo $query;
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result = mysqli_query($db, $query);
                $result_list = array();
         while($row = mysqli_fetch_array($result))
{
$result_list[] = $row;
$bull_no=$row["bull_no"];
$breed=getBreedType2($db,$row["breed"]);
?>
<tr name="tr"  index='<?php echo $i++?>' bull='<?php echo $row["bull_no"] ;?>'>
        <td id="pic"><!--<input type="checkbox" name="checkbox" value="">-->
        <img class="bull_pic" src="<?php if($breed=='NR') echo '/assets/norwred3.jpg'; else if($breed=='HO') echo '/assets/holstein-web-1.jpg';else if($breed=='BS') echo '/assets/brownswiss-web-1.jpg'; else if($breed=='SM') echo '/assets/simmental01.jpg'; else if($breed=='JE') echo '/assets/jersey-web-1.jpg'; else echo '/assets/iconcow.jpg'; ?>" height="30" width="38">

             <div id="information" class="information"> 
             
	<div class="tooltip_title">GENERAL INFORMATION</div>
	<div class="tooltip_pic"></div>
	<div class="tooltip_info1">
		<div class="tooltip_col1">
			<div>
				<?php echo $bull1; ?>: <span><?php echo $row["bull_no"] ;?></span>
			</div>
		</div>
		<div class="tooltip_col2">
			<div>
				<?php echo $popup_sire; ?> <span><?php echo $row["sire"] ;?></span>
			</div>
			<div>
				<?php echo $popup_PGS; ?><span><?php echo $row["PGS"] ;?></span>
			</div>
			<div>
				<?php echo $popup_MGS; ?> <span><?php echo $row["MGS"] ;?></span>
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
			<div>
				<?php echo $set2_juris1; ?><span><?php echo $row["General_size"] ;?></span>
			</div>
			<div>
				 <?php echo $set2_juris2; ?> <span><?php echo $row["General_udder"] ;?></span>
			</div>
			<div>
				<?php echo $set2_juris3; ?> <span><?php echo $row["Teats_location"] ;?></span>
			</div>
			<div>
				<?php echo $set2_juris4; ?> <span><?php echo $row["Udder_depth"] ;?></span>
			</div>
			<div>
				<?php echo $set2_juris5; ?> <span><?php echo $row["General_legs"] ;?></span>
			</div>

			<div>
				<?php echo $set2_juris7; ?> <span><?php echo $row["Fat_percentage"] ;?></span>
			</div>
		</div>
		<div class="tooltip_col2">
		<div class="tooltip_sectititle">
				<?php echo $set2_subtitle2 ?>
			</div>
			<div>
				<?php echo $set2_manufacture1;?> <span><?php echo $row["KG_milk"] ;?></span>
			</div>
			<div>
				<?php echo $set2_manufacture2;?> <span><?php echo $row["Fat_percentage"] ;?></span>
			</div>
			<div>
				<?php echo $set2_manufacture3;?> <span><?php echo $row["Protein_percentage"] ;?></span>
			</div>
			
	  <div class="tooltip_sectititle">
				<?php echo $set2_subtitle3 ?> 
			</div>
			<div>
				<?php echo $set2_manufacture4;?> <span><?php echo $row["SCC"] ;?></span>
			</div>
			<div>
				<?php echo $set2_manufacture5;?> <span><?php echo $row["Fertility"] ;?></span>
			</div>
						<div>
				<?php echo $set2_juris6;?> <span><?php echo $row["Pelvis_stucture"] ;?></span>
			</div>
		</div>
	</div>
	
</div>

     </td>
        <td name="bull_no"><?php echo $row["bull_no"] ;?></td>
        <td  id="name"><?php echo $row["bull_foreign_name"] ;?></td>
        <td><?php echo $breed;?></td>
        <td> <input type="color" value="<?php echo $row["StrawColor"] ;?>"class="color" name="Color"></td>
       <!-- <td>
        <select name="StrawSize">
         <option value="<?php echo $row['StrawSize'] ;?>"><?php echo $row['StrawSize'] ;?></option>
        <option value="0.25">0.25</option>
        <option value="0.50">0.50</option>
   </select></td>-->
        <td>
          <select name="StrawType" >
          <option value="<?php echo $row['StrawType'] ;?>"><?php echo $row['StrawType'] ;?></option>
        <option value="Regular">Regular</option>
        <option value="Genomic">Genomic</option>
        <option value="sv">SV</option>
        <option value="sx">SX</option>
   </select></td>
           <td>
          <select name="orderby" >
          <option value="<?php echo $row['Order_by_Fertility']; ?>"><?php  if($row['Order_by_Fertility']!='100') {echo $row['Order_by_Fertility'] ;} else {echo 'index';}?></option>
  <?php  
   for ($x = 0; $x <= 10; $x++) { ?>
    <option value="<?php echo "$x";?>"><?php echo "$x";?></option>
    <?php } ?>
   </select></td>
         <td>
  <select name="active" class="active" > // onchange="updateDB()"
  <option value="<?php echo $row['Match_status'] ;?>"><?php  if($row['Match_status']==1){echo'Yes';} else {echo'No';};?></option>
  <option value="1">Yes</option>
  <option value="0">No</option>
  </select></td>
 
        <td>
   <select name="heiferstatus">
   <option value="<?php echo $row['Heifer_status'] ;?>">
  <?php if ($row['Heifer_status']==1){echo'Yes';} else if ($row['Heifer_status']==0) {echo'No';} else {echo'Both';}?> </option>
   <option value="1">Yes</option>
   <option value="0">No</option>
   <option value="2">Both</option>
   </select></td>
<td>
     <select name="planned">
     <option value="<?php echo $row['Planned_usage'] ;?>"><?php echo $row['Planned_usage'];?></option>
   <?php 
   for ($x = 0; $x <= 100; $x+=5) { ?>
    <option value="<?php echo "$x";?>"><?php echo "$x";?></option>
    <?php } ?> 
     </select></td>
     
         <td><?php echo $row["Planned_usage"] ;?></td>
                 <td>
  <select name="limited">
  <option value="<?php if($row['Limited']==1){echo 1;} else {echo 0;};?>"><?php  if($row['Limited']==1){echo 'Yes';} else {echo 'No';};?></option>
  <option value="1">Yes</option>
  <option value="0">No</option>
  </select></td>
        <td><?php echo $row["Actuall_inseminations"] ;?></td>
        
        <td>
     <select name="Insemno">
     <option value="<?php echo $row['From_insemination'] ;?>"><?php echo $row['From_insemination'];?></option>
   <?php 
   for ($x = 0; $x <= 10; $x++) { ?>
    <option value="<?php echo "$x";?>"><?php echo "$x";?>
    <?php } ?> 
     </select></td>
     
        <td>
       <select name="ToInsemno">
       <option value="<?php echo $row['To_insemination'] ;?>"><?php echo $row['To_insemination'];?></option>
      <?php 
      for ($x = 0; $x <= 10; $x++) { ?>
      <option value="<?php echo "$x";?>"><?php echo "$x";?>
      <?php } ?> 
     </select></td></td>


    </tr>
    
      <?php } ?> 
    </div>
    </div>
    </body>
    </div>
</table>
<div class="button">
<button class="submit" type="submit" name="current" value="<?php if(!isset($_POST['current']) or $_POST['current']==0) {echo 0;} else {$currentValue = explode(" ", $_POST['current']); print_r ($currentValue[0]-1);} echo ' '; if(isset($_POST['showall'])) {echo 'true';} else if(isset($_POST['current'])) { $currentValue = explode(" ", $_POST['current']);  print_r($currentValue[1]);} else {echo 'false';}?> "><</button>
<button class="submit" type="submit" name="current" value="<?php if(!isset($_POST['current'])) {echo 1;}  else {$currentValue = explode(" ", $_POST['current']); print_r ($currentValue[0]+1);} echo ' '; if(isset($_POST['showall'])) {echo 'true';} else if(isset($_POST['current'])) { $currentValue = explode(" ", $_POST['current']); print_r($currentValue[1]);} else {echo 'false';}?> ">></button>
    <button class="submit" type="button" id="updateDB" name="submit">Save</button>
    <button class="submit" type="submit" onClick="printable()">Print</button>
</div>

</form>
  <script>
function printable(){
var prtContent = document.getElementById("table");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.write(' <link rel="stylesheet" type="text/css" href="bulls.css" />');
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
}
</script>

  <script>
	// Change the selector if needed
var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;

// Adjust the width of thead cells when window resizes
/*$(window).resize(function() {
    // Get the tbody columns width array
    colWidth = $bodyCells.map(function() {
        //return $(this).width();
    }).get();
    
    // Set the width of thead columns
    $table.find('thead #tr2').children().each(function(i, v) {
        //$(v).width(colWidth[i]);
    });    
}).resize(); // Trigger resize handler 
function getInputsByValue(value)
{
    var allInputs = document.getElementsByTagName("td");
    var results = [];
    for(var x=0;x<allInputs.length;x++)
        if(allInputs[x].innerHTML== value)
            results.push(allInputs[x]);
    return results;
}*/
	if($("#search").attr("searchWord")!='')
	$('td:contains('+$("#search").attr("searchWord")+')').parent().addClass('chosen');
  //getInputsByValue($('#search').attr('searchWord')).addClass('chosen');
  $(function () {
   var sendToUpdate=[];
  $("select").change(function() {
  //alert( "Handler for .change() called." );
  var found = jQuery.inArray($(this).parent().parent().find('[name=bull_no]').text(), sendToUpdate);
if (found == -1) {
  sendToUpdate.push($(this).parent().parent().find('[name=bull_no]').text());
  }
});
  $("input").change(function() {
  //alert( "Handler for .change() called." );
  var found = jQuery.inArray($(this).parent().parent().find('[name=bull_no]').text(), sendToUpdate);
if (found == -1) {
  sendToUpdate.push($(this).parent().parent().find('[name=bull_no]').text());
  }
});
 //function updateDB()
  $('#updateDB').click( function(){
 
  
 /* var elem = $(this).parent().parent().find('[name=checkbox]');
  for (var i=0;i< elem.length; i++){
  
  	if(elem[i].checked){
 	    var data = {
 	    	func : 'updateBullActive',
 	    	user: $('#bullsForm').attr('user'), 	    	
 	    	bull_no: $(this).parent().parent().find('[index='+i+']').find('[name=bull_no]').text(),
 	    	active: $(this).parent().parent().find('[index='+i+']').find('[name=active]').val(),
 	    	StrawSize: $(this).parent().parent().find('[index='+i+']').find('[name=StrawSize]').val(),
                StrawType: $(this).parent().parent().find('[index='+i+']').find('[name=StrawType]').val(),
                Color: $(this).parent().parent().find('[index='+i+']').find('[name=Color]').val(),
 	    	heifer_status:$(this).parent().parent().find('[index='+i+']').find('[name=heiferstatus]').val(),
 	    	from_insemination:$(this).parent().parent().find('[index='+i+']').find('[name=Insemno]').val(),
 	    	to_insemination:$(this).parent().parent().find('[index='+i+']').find('[name=ToInsemno]').val(),
 	    	limited:$(this).parent().parent().find('[index='+i+']').find('[name=limited]').val(),
 	    	Order_by_Fertility:$(this).parent().parent().find('[index='+i+']').find('[name=orderby]').val(),
 	    	};*/
 for (var i=0;i< sendToUpdate.length; i++){
 	    var data = {
 	    	func : 'updateBullActive',
 	    	user: $('#bullsForm').attr('user'), 	    	
 	    	bull_no: sendToUpdate[i],
 	    	active: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=active]').val(),
 	    	planned: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=planned]').val(),
 	    	//StrawSize: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=StrawSize]').val(),
                StrawType: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=StrawType]').val(),
                Color: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=Color]').val(),
 	    	heifer_status: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=heiferstatus]').val(),
 	    	from_insemination: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=Insemno]').val(),
 	    	to_insemination: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=ToInsemno]').val(),
 	    	limited: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=limited]').val(),
 	    	Order_by_Fertility: $("#bullsForm").find('[bull='+sendToUpdate[i]+']').find('[name=orderby]').val(),
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
    }
    
    });
    })

    </script>