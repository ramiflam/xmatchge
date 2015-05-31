<?php
 include "navigationBar.php";
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
$updatecowPhrase=getMsg($db, $browserLanguage, 'updateC');
$updatePhrase=getMsg($db, $browserLanguage, 'updateCows');
$createPhrase=getMsg($db, $browserLanguage, 'Create Future Insemination List');
$insemPhrase=getMsg($db, $browserLanguage, 'Insemination');
$cow2_lable = getMsg($db, $browserLanguage, 'cow2_lable');
$cow2_title = getMsg($db, $browserLanguage, 'cow2_title');
$notesParameters=getMsg($db, $browserLanguage, 'notesParameters');
 ?>
<!DOCTYPE html>
<html>
	
<body>
<script>

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
        			  var data = {
	    	func : 'Check'
	    	};
	  //for(i=0;i<$('.inner-tag-cows').length; i++){
		//data[i] = $('.inner-tag-cows')[i].textContent
		//}
		data[0] = document.getElementById("txtcownum").value;
	   
	   $.ajax({
		      type: "POST",
		      dataType: "json",
		      url: "ajax.php", //Relative or absolute path to response.php file
		      data: data,
		      success: function(data) {
		      if(data==1){
		      	obj = document.getElementById("txtcownum");
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
	    });
	    
        		
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
</script>

<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="cows.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>
<div class="content">
    <ul>
        <a href="cows1.php"><li><?php echo $updatecowPhrase;?></li> </a>
    </ul>
      <ul>
         <li id="createinsem"><?php echo $createPhrase;?></li>
    </ul>
      <ul>
       <a href="cows3.php"> <li id="preferedPhrase" style="color:red;"><?php echo $notesParameters;?></li></a>
    </ul>
</div>

<div class="sidebar">
<form id="cowsForm" name="" method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" >
<h1><?php echo $createPhrase?> </h1>
<ul class="not-padding">
	<li class="border">
		<div id="tag-wrapper-cows">
			
		</div>
		<input type="text" id="txtcownum" name="txtcownum" placeholder="" required pattern="[A-Za-z0-9]{1,}" onkeypress="validate(event); searchKeyPress(event)"/>
	</li>
	<li>
		<a href="dailyActivity.php?"  style="text-decoration:none;" id="creatHref"><button class="submit" type="button" id="create"><?php echo $insemPhrase;?></button></a>
		
	</li>
	</ul>
	<ul id="select">
	<li>
    		<label id="number"> </label><label>cows</label><br>
    		<label id="selected"><?php echo $cow2_lable ?></label>
    		<script>
			obj1 = document.getElementById("number");
			$( obj1 ).append( counter );
		</script>
	</li></ul>
</div>

</form>
  <script>

  $(function () {
 //function updateDB()
  $('#create').click( function(){
  query = 'match=true';
  	for(i=0;i<$('.inner-tag-cows').length; i++){
		query = query + '&'+i+'=' +$('.inner-tag-cows')[i].textContent
		}
  	$("#creatHref").attr("href", "dailyActivity.php?"+query )
  	//$('#Dailyactivity')[0].click();
 	/*var data = {
 	    	func : 'updateSetting3',
 	    	user_id:$(this).parent().attr('user_id'),
 	    	lastinsemupdate: $(this).parent().find('[name=lastinsemupdate]').val(),
 	    	daybefupdate: $(this).parent().find('[name=daybefupdate]').val(),
 	    	dayinsemupdate:$(this).parent().find('[name=dayinsemupdate]')[0].checked,
 	    	excfileinsem:$(this).parent().find('[name=excfileinsem]')[0].checked,
 	    	showinsem:$(this).parent().find('[name=showinsem]')[0].checked,
 	    	folder:$(this).parent().find('[name=folder]').val(),
 	    	folderback:$(this).parent().find('[name=folderback]').val()
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
      
    });*/
    });
    });
    </script>

 