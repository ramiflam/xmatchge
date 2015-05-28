<?php
 include "navigationBar.php";
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$browserLanguage='he';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$insemPhrase=getMsg($db, $browserLanguage, 'insem');
$insemPhrase=getMsg($db, $browserLanguage, 'Insemination');
$manualPhrase=getMsg($db, $browserLanguage, 'Manual Update of Insemination');
$clearPhrase=getMsg($db, $browserLanguage, 'Clear');
$matchPhrase=getMsg($db, $browserLanguage, 'match');
$showPhrase=getMsg($db, $browserLanguage, 'show all');
$sendPhrase=getMsg($db, $browserLanguage, 'send to');

if(isset($_GET["match"]) && $_GET["match"]=="true"){
$matching=array();
foreach ($_GET as $cow_no ) {
		$matching_cow_no=array("12345","963","246","852","789","14144","123","012");
		$random_keys=array_rand($matching_cow_no,3);
		// array_push($matching,$matching_cow_no);
		$matching[$cow_no]=array($matching_cow_no[$random_keys[0]],$matching_cow_no[$random_keys[1]],$matching_cow_no[$random_keys[2]]);
	}

$matching = (array)$matching;
//print_r($matching[2]);
//echo 3476;
//print_r($matching);
}
 ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="dailyActivity.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/html2canvas.js"></script>
<script type="text/javascript" src="../js/jquery.plugin.html2canvas.js"></script>

</head>
<body dir="rtl">
<script>
function printstiker(){
	var prtContent = document.getElementById("stiker");
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.write(' <link rel="stylesheet" type="text/css" href="dailyActivity.css"/>');
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
}
	var counter = 0;
	
	function changeNumber(){
		$(document.getElementById("number")).html(""+counter+"");
		
		}
	
	function erase(e){
		elm = e.parentNode;
		var parent =  document.getElementById("tag-wrapper-cows");
		var child =elm;
		parent.removeChild(child);
		counter = counter - 1;
		changeNumber();
	}

	function searchKeyPress(e){
  		 e = e || window.event;
        	if (e.keyCode == 13)
        	{
        		
	           
        		obj = document.getElementById("txtcow");
           		textToSend = obj.value; 
           		if(obj.value==''){
           			return;
           		}
           		obj.value = "";
           		var tag = document.createElement("div");
           		var x = document.createElement("div");
           		var node = document.createTextNode(textToSend);
			tag.appendChild(node);
			var element = document.getElementById("tag-wrapper-cows");
			tag.setAttribute("class", "inner-tag-cows");
			x.setAttribute("class", "exit-inner-tag");
			x.setAttribute("onclick", "erase(this)");
			tag.appendChild(x);
			element.appendChild(tag);
			counter = counter + 1;
			changeNumber();
        	}
	}
	function validate(evt) {
	  var theEvent = evt || window.event;
	  var key = theEvent.keyCode || theEvent.which;
	  key = String.fromCharCode( key );
	  var regex = /[0-9]|\./;
	  if( !regex.test(key) ) {
	    theEvent.returnValue = false;
	    if(theEvent.preventDefault) theEvent.preventDefault();
	  }
	}
var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;
</script>
<div class="content">

    <ul>
        <li><?php echo $insemPhrase;?></li> 
    </ul>
      <ul>
        <li id="insemlist"><?php echo $manualPhrase;?></li>
    </ul>
</div>
<div class="sidebar">
<form action="" method="post" onsubmit="filter()" name="form">
<h1><?php echo $insemPhrase;?></h1>
<ul  class="not-padding">
<li  id="search" class="border">
<div id="tag-wrapper-cows">
</div>
 
		<input type="text" id="txtcow" placeholder=""  pattern="[0-9]{1,}" onkeypress="validate(event); searchKeyPress(event)"/>
           </li><li>
               		<label id="number" style="display:none"> </label><br>
    		<label id="selected"></label>
    		<script>
			obj1 = document.getElementById("number");
			$( obj1 ).append( counter );
		</script></li>
    <li>
<button class="submit" type="submit"id="createinsem" ><?php echo $insemPhrase;?></button>
</li>
</ul>
<div id="table">
<form  name="daily" method="get"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" >
        <table style="width:100%" id="heading" class="scroll" >
        <thead>
            <tr>
                <th id="first"></th>
               <th colspan="5">COW ID </th>
                <th colspan="3"> STATUS</th>  
               <th colspan="8">MATCHING RECOMMENDATIONS </th>
            </tr>
    <tr>
        <td id="first" class="secttl"></td>
        <td class="secttl">מס. פרה </td>
        <td class="secttl">צבע קשית</td>
        <td class="secttl">גודל קשית</td>
        <td class="secttl">סוג קשית</td>
        <td class="secttl" > BURN NO. </td>
        
        <td class="secttl" id="head">תחלובה</td>
        <td class="secttl" >הזרעה אחרונה</td>
        <td class="secttl">קבוצה</td>
         
        <td class="secttl" id="head">שור 1</td>
        <td class="secttl" >שור 2</td>
        <td class="secttl" >שור 3</td>
        
        <td class="secttl"id="head">FORCED BULL</td>
        
        <td class="secttl">הערות</td>
        
    </tr>
    </thead>
    <tboby>
    <?php
    $query="SELECT cow_no,burn_no,lact_no,last_AI_date,group_name,Forced_bull,remark,StrawColor,StrawSize,StrawType FROM `local_cows`";
    if(isset($_GET["0"])){
	 	$query= $query." WHERE ";
	 	$query= $query."`cow_no` =".$_GET["0"];
	 foreach ($_GET as $cow_no ) {
		 $query= $query." or `cow_no` =".$cow_no;
	}
	}
	//echo $query;
     if(!isset($_POST['showall'])){
	 	//$query= $query." limit 3";
	 }

	 
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result = mysqli_query($db, $query);
                $result_list = array();
         while($row = mysqli_fetch_array($result))
{
$result_list[] = $row;
?>
 
<tr>
     <td><input type="checkbox" name="" value=""></td>
     <td><?php echo $row["cow_no"] ;?></td>
     <td><input type="color" value="<?php echo $row["StrawColor"] ;?>"class="color" name="Color"></td>
     <td><?php echo $row["StrawSize"] ;?></td>
     <td><?php echo $row["StrawType"] ;?></td>
     <td><?php echo $row["burn_no"] ;?></td>
     <td><?php echo $row["lact_no"] ;?></td>
     <td><?php echo $row["last_AI_date"] ;?></td>
     <td><?php echo $row["group_name"];?></td>
     <td><?php echo $matching[$row["cow_no"]][0];?></td>
     <td><?php echo $matching[$row["cow_no"]][1];?></td>
     <td><?php echo $matching[$row["cow_no"]][2];?></td>
     <td><?php echo $row["Forced_bull"];?></td>
     <td><?php echo $row["remark"];?></td>

<?php } ?>   
</table></div>
</div>

<script>
function filter(){
  query = '';
  //document.URL
  if($('.inner-tag-cows').length>0){
  	for(i=0;i<$('.inner-tag-cows').length; i++){
		query = query + '&'+i+'=' +$('.inner-tag-cows')[i].textContent;
		}
	this.form.action = '?'+query ;
  	//$("#creatHref").attr("href", "dailyActivity.php?"+query )
  	}
  }
function printable(){
	var prtContent = document.getElementById("table");
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.write(' <link rel="stylesheet" type="text/css" href="dailyActivity.css" />');
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
}
</script>
<div class="button">
    <!--/*<button class="submit" type="submit" onClick="history.go(0)"><?php echo $clearPhrase;?></button>
    <button class="submit" type="submit"><?php echo $matchPhrase;?></button>
   <button class="submit" type="submit" name="showall" id="showall"><?php echo $showPhrase;?></button>
    <button id="sendTo" class="submit" type="submit"><?php echo $sendPhrase;?></button>*/-->
    <nav>
	<ul>
		<li><a href="#"><?php echo $sendPhrase;?></a>
			<ul>
			
				<li><input type="submit" name="submit" value="אימייל" id="email" ></li>
				<li><input type="button" name="print" value="הדפסה" onClick="printable()" id="email"></li>
				<li><a href="#">SMS</a></li>
			</ul>
		</li>
	</ul>
</nav>
    
</div>
</form>
 <?php
   
     if(isset($_POST['submit'])){
     $username=$_COOKIE["user"];
     $subject="";
     	$msg = '
<html>
<body>
<h1 style="color:red;margin-left:30px;text-align:center;">Xmate genetics</h1>
<p style="font-weight:bold;" >The Insemination List</p>

  <table style="width:85%;border:1px solid black;border-collapse: collapse;" id="heading">
            <tr>
                <th  style="border:1px solid black;font-size: 12px;" id="first"></th>
               <th style="border:1px solid black;font-size: 12px;"colspan="2">COW ID </th>
                <th style="border:1px solid black" colspan="3"> STATUS</th>  
               <th style="border:1px solid black" colspan="8">MATCHING RECOMMENDATIONS </th>
            </tr>
    <tr>
        <td  style="font-size: 11px;border:1px solid black;" id="first" class="secttl"></td>
        <td style="font-size: 11px;border:1px solid black;" class="secttl"># COW </td>
        <td style="font-size: 11px;border:1px solid black;" class="secttl" id="head"> BURN NO. </td>
        
        <td style="font-size: 11px;border:1px solid black;" class="secttl" >LACT.</td>
        <td style="font-size: 11px;border:1px solid black;" class="secttl" >LAST INSEM.</td>
        <td style="font-size: 11px;border:1px solid black;" class="secttl"id="head">GROUP</td>
         
        <td style="font-size: 11px;border:1px solid black;" class="secttl" >BULL1</td>
        <td style="font-size: 11px;border:1px solid black;" class="secttl" >BULL2</td>
        <td style="font-size: 11px;border:1px solid black;" class="secttl" id="head">BULL3</td>
        
        <td style="font-size: 11px;border:1px solid black;" class="secttl"id="head">FORCED BULL</td>
        
        <td style="font-size: 11px;border:1px solid black;" class="secttl">NOTES</td>
        
    </tr>';
     //$msg = "First line of text\nSecond line of text\nhi how are you today?\nhello world:-)";
     	           // document.getElementById("myForm").submit();
     	           $query="SELECT cow_no,burn_no,lact_no,last_AI_date,group_name,Forced_bull,remark FROM `local_cows`";
    if(isset($_GET["0"])){
	 	$query= $query." WHERE ";
	 	$query= $query."`cow_no` =".$_GET["0"];
	 foreach ($_GET as $cow_no ) {
		 $query= $query." or `cow_no` =".$cow_no;
	}
	}
	//echo $query;
     if(!isset($_POST['showall'])){
	 	//$query= $query." limit 3";
	 }

	 
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result = mysqli_query($db, $query);
                $result_list = array();
         while($row = mysqli_fetch_array($result))
{
$result_list[] = $row;
$msg = $msg.
    '<tr>
     <td></td>
     <td style="border:1px solid black;text-align:center;">'.$row["cow_no"].'</td>
     <td style="border:1px solid black;text-align:center;">'.$row["burn_no"].'</td>
     <td style="border:1px solid black;text-align:center;">'.$row["lact_no"] .'</td>
     <td style="border:1px solid black;text-align:center;">'.$row["last_AI_date"] .'</td>
     <td style="border:1px solid black;text-align:center;">'.$row["group_name"].'</td>
     <td style="border:1px solid black;text-align:center;"></td>
     <td style="border:1px solid black;text-align:center;"></td>
     <td style="border:1px solid black;text-align:center;"></td>
     <td style="border:1px solid black;text-align:center;">'.$row["Forced_bull"].'</td>
     <td style="border:1px solid black;text-align:center;">'. $row["remark"].'</td>
</tr>';
}
 $msg = $msg.  
'</table>
</body>
</html>
';          
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
     $query="SELECT * FROM `users_details` WHERE User_Name='$username'";
      $result = mysqli_query($db, $query);
     	 If ($result)
	   {
 	    while($row = mysqli_fetch_array($result)) {
            mail($row["User_E_Mail"],"My subject",$msg,$headers);
            unset($_POST['submit']);
    }
    }
 	     	   else
	   {
		echo '<br>user not exist'.$row["User_E_Mail"];
	   }

  }
     ?>

</body>
</html>