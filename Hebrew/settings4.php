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
$set5_manual=getMsg($db, $browserLanguage, 'set5_manual');
$set5_files=getMsg($db, $browserLanguage, 'set5_files');
$set5_import=getMsg($db, $browserLanguage, 'set5_import');
$set5_genetics=getMsg($db, $browserLanguage, 'set5_genetics');
$set5_list=getMsg($db, $browserLanguage, 'set5_list');
$set5_bulls=getMsg($db, $browserLanguage, 'set5_bulls');
$set5_settings=getMsg($db, $browserLanguage, 'set5_settings');
$set5_excel=getMsg($db, $browserLanguage, 'set5_excel');
$set4_backup=getMsg($db, $browserLanguage, 'set4_backup');
?>
<html>
<body>
<script>
 function uploadFileFun(path){
  document.getElementById("uploadFile").value= path;
}
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
<div class="farmsetting" dir="rtl">
<form  name="set"  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" >
    <h1> <?php echo $set5_manual; ?></h1>
    <br><br>
    <label class="manual"><?php echo $set5_files ?></label>
    <li>
	<input id="uploadFile" placeholder="בחר קובץ" name="fileInput" disabled="disabled" required/>
	<!--<span class="location">...</span>-->
	<button class="button-upload location" >
         	<div class="dots-in-upload">...</div>
         	<input id="uploadBtn" type="file" class="uploadBtn-setting-input upload" onchange ="uploadFileFun(this.value)"/>
        </button>
        <!--<input type="text" id="set5_inputFile" name="fileInput" placeholder="c:\Program Files\drorbreeding" required>
         <button class="location" type="file">...</button>-->
        
    </li>
    <br><br><br>
    <div class="submit2">
    <label class="manual"><?php echo $set5_import ?></label>
    <li><button class="submit2" type="submit"><?php echo $set5_genetics ?></button></li>
    <li><button class="submit2" type="submit"><?php echo $set5_list ?></button></li>
    </div>
    <button class="submit" type="submit" name="submit"><?php echo $set4_backup ?></button>
</form>
</div>