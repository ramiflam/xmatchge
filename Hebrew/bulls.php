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
  

if(!empty($_REQUEST['search'])) {
   /*if(isset($_POST['find'])){*/
$search=$_POST['search'];
 $sql = "SELECT * FROM `bulls_details` WHERE bull_no LIKE '%".$search."%' "; 
        $searchRow=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $searchResult = mysqli_query($db, $sql);
        $searchNum= mysqli_fetch_array($searchResult );
                $result_list = array();
         while($searchRow= mysqli_fetch_array($searchResult ))
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

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="bulls.css" />

</head>
<div class="content">
    <ul>
        <a href=""><li>פרים</li> </a>
    </ul>

</div>
<body dir="rtl">
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
$(".information").hide();
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
<form id="bullsForm" name="myform" method="post"   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" onsubmit="showAll()">
    <h1>פרים</h1><div class="input">
    
<input type="text" name="search" id="search" placeholder=" מספר\שם פר" onkeypress=" searchKeyPress(event)" searchWord="<?php echo $searchNum['bull_no'] ?>"><button class="submit" type="submit" id="find" name="find">חפש</button>
</div>
<div class="bull">
<label id="show"> הצג את:</label>
<button class="submit" type="submit" id="bull" value="<?php if(!isset($_POST['showall'])) {echo 'false';} else {echo $_POST['showall'];}?>" >כל הפרים</button>
<button class="submit" type="submit" id="bull" name="showall" value="<?php if(!isset($_POST['showall'])) {echo 'false';} else {echo $_POST['showall'];}?>" > הפעילים?</button>

</div>
	<div id="table">
        <table id="heading" class="scroll">
        <thead>
           <tr>
                <th colspan="2"id="first"></th>
               <th colspan="6">Bull ID & characteristic </th>
                <th colspan="5">הגדרות התאמה </th>  
               <th colspan="4">מצב </th>
            </tr>
       
            <tr id=tr2>

        <td id="first" class="secttl"></td>
       
        <td class="secttl" id="num" style="border-right: 1px solid #fff;">מספר</td>
        <td class="secttl" id="name">שם</td>
        <td class="secttl" id="breed">גזע</td>
        <td class="secttl" id="color">צבע קשית</td>
        <td class="secttl" id="siz">גודל קשית</td>
        <td class="secttl" id="type" >סוג קשית</td>
        
        <td class="secttl"id="color" id="head" style="border-right: 1px solid #fff;">פעיל?</td>
        <td class="secttl" id="color">לעגל</td>
        <td class="secttl">Planned %</td>
        <td class="secttl">Actual %</td>
        <td class="secttl">Actual Insem. No.</td>
        <td class="secttl"style="border-right: 1px solid #fff;">עדיפות</td>
        <td class="secttl" id="from">From Service</td>
          <td class="secttl" >To Service</td>
        <td class="secttl"  id="last" >מוגבל</td>
    </tr>
    </thead>
	<tbody>
     <div class="tblcontent">
     <?php $i = 0;?>
    
            <?php
  if(!isset($_POST['bull'])){

	 $query="SELECT bull_no,bull_name,CVM,KG_ECM,match_status,Heifer_status,Planned_usage,Actuall_inseminations,	Usage_order,From_insemination,To_insemination,Limited,General_size,General_udder,Teats_location,Udder_depth,General_legs,Pelvis_stucture,KG_milk,Fat_percentage,Protein_percentage,MGS,PGS,SCC,sire,StrawColor,StrawSize,StrawType
	  FROM `bulls_details`";
	  }
	  else
	  	{
	  $query="SELECT bull_no,bull_name,CVM,KG_ECM,match_status,Heifer_status,Planned_usage,Actuall_inseminations,	Usage_order,From_insemination,To_insemination,Limited,General_size,General_udder,Teats_location,Udder_depth,General_legs,Pelvis_stucture,KG_milk,Fat_percentage,Protein_percentage,MGS,PGS,SCC,sire,StrawColor,StrawSize,StrawType
	  FROM `bulls_details` WHERE match_status='1' ";
	  }
	 if(isset($_POST['showall']) && ($_POST['showall']=='true')){
	 	$query=$query." WHERE match_status='1'";
	 } 
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result = mysqli_query($db, $query);
                $result_list = array();
         while($row = mysqli_fetch_array($result))
{
$result_list[] = $row;
$bull_no=$row["bull_no"];
$breed=getBreedType($db,$bull_no);

?>
<tr name="tr"  index='<?php echo $i++?>'>
        <td id="pic"><input type="checkbox" name="checkbox" value=""><img class="bull_pic" src="/assets/iconcow.jpg" height="30px"width="38px">
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
				<?php echo $set2_juris7; ?> <span><?php echo $row["Fat_percentage"] ;?></span>/*to check!!!!!!!!!!!*/
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
				<?php echo $set2_juris6;?> <span><?php echo $row["Pelvis_stucture"] ;?></span>/*to check!!*/
			</div>
		</div>
	</div>
	
</div>

     </td>
        <td name="bull_no"><?php echo $row["bull_no"] ;?></td>
        <td><?php echo $row["bull_name"] ;?></td>
        <td><?php echo $breed;?>12</td>
        <td> <input type="color" value="<?php echo $row["StrawColor"] ;?>"class="color" name="Color"></td>
        <td>
        <select name="StrawSize">
         <option value="<?php echo $row['StrawSize'] ;?>"><?php echo $row['StrawSize'] ;?></option>
        <option value="0.25">0.25</option>
        <option value="0.50">0.50</option>
   </select></td>
        <td>
          <select name="StrawType" >
          <option value="<?php echo $row['StrawType'] ;?>"><?php echo $row['StrawType'] ;?></option>
        <option value="sv">sv</option>
        <option value="sx">sx</option>
   </select></td>
         <td>
  <select name="active" class="active" > // onchange="updateDB()"
  <option value="<?php echo $row['match_status'] ;?>"><?php  if($row['match_status']==1){echo'Yes';} else {echo'No';};?></option>
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
        <td><?php echo $row["Planned_usage"] ;?></td>
         <td><?php echo $row["Planned_usage"] ;?></td>
        <td><?php echo $row["Actuall_inseminations"] ;?></td>
        <td><?php echo $row["Usage_order"] ;?></td>
        
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
        <td>
  <select name="limited">
  <option value="<?php echo $row['Limited'] ;?>"><?php  if($row['Limited']==1){echo'Yes';} else {echo'No';};?></option>
  <option value="1">Yes</option>
  <option value="0">No</option>
  </select></td>

    </tr>
    
      <?php } ?> 
    </div>
    </div>
    </body>
    </div>
</table>
<div class="button">
    <button class="submit" type="button" id="updateDB" name="submit">עדכון</button>
    <button class="submit" type="submit" onClick="printable()">הדפס</button>
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
 //function updateDB()
  $('#updateDB').click( function(){
  
  var elem = $(this).parent().parent().find('[name=checkbox]');
  for (var i=0;i< elem.length; i++){
  
  	if(elem[i].checked){
 	    var data = {
 	    	func : 'updateBullActive',
 	    	bull_no: $(this).parent().parent().find('[index='+i+']').find('[name=bull_no]').text(),
 	    	active: $(this).parent().parent().find('[index='+i+']').find('[name=active]').val(),
 	    	StrawSize: $(this).parent().parent().find('[index='+i+']').find('[name=StrawSize]').val(),
                StrawType: $(this).parent().parent().find('[index='+i+']').find('[name=StrawType]').val(),
                Color: $(this).parent().parent().find('[index='+i+']').find('[name=Color]').val(),
 	    	heifer_status:$(this).parent().parent().find('[index='+i+']').find('[name=heiferstatus]').val(),
 	    	from_insemination:$(this).parent().parent().find('[index='+i+']').find('[name=Insemno]').val(),
 	    	to_insemination:$(this).parent().parent().find('[index='+i+']').find('[name=ToInsemno]').val(),
 	    	limited:$(this).parent().parent().find('[index='+i+']').find('[name=limited]').val(),
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
    }
    });
    })

    </script>