<?php
include "settings.php";
$browserLanguage='en';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}
$set6_subtitle=getMsg($db, $browserLanguage, 'set2_title');
?>
<div class="sidebar">
<h1> <?php echo $impexpPhrase; ?></h1>
<div class="">
<form  name="set"  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" >
<table style="  width: 80%;">
<td> 
<div id="manage" >
            <h2 class="title6">Managment Software</h2>
            <div style="margin-bottom: 8px;">
<input type="radio" id="Managment" name="Managment" value="NOA" checked ><img src="/assets/noa.png"alt="Smlogo" height="30" width="50" style="padding-left: 10px; padding-right: 5px; vertical-align: middle;"><label id="label6"></label>
</div>
<div style="margin-bottom: 8px;">
<input type="radio" name="Managment" value="Afimilk"><img src="/assets/afimilk.jpg"alt="Smlogo" height="30" width="50" style="padding-left: 10px;  padding-right: 5px; vertical-align: middle;"><label id="label6"></label>
</div>
<div  style="margin-bottom: 8px;">
<input type="radio" name="Managment" value="SCR"><img src="/assets/scr.jpg"alt="Smlogo" height="30" width="50" style="padding-left: 10px;  padding-right: 5px; vertical-align: middle;"><label id="label6"></label>
</div>
<div>
<input type="radio" name="Managment" value=""><label id="label6"  style="padding-left: 10px; color:red;">without</label><br>
 </div>
 
 <h2 class="title6">genetic Base</h2>
<input type="radio" name="genetic" value="ISR" checked ><label id="label6">ISR</label><br>
<input type="radio" name="genetic" value="CAN"><label id="label6">CAN</label><br>
<input type="radio" name="genetic" value="USA"><label id="label6">USA</label><br>
<input type="radio" name="genetic" value="NLD"><label id="label6">NLD</label><br>
<input type="radio" name="genetic" value="FRA"><label id="label6">FRA</label><br>
<input type="radio" name="genetic" value="NLZ"><label id="label6">NLZ</label><br>
<input type="radio" name="genetic" value="without"><label id="label6">without</label><br>
</div>
</td><td style="vertical-align:top;">
<div id="semens">
 <h2 class="title6">Semen Provider</h2>
<input type="checkbox" name="Semen" id="semen" value="geno" checked ><label id="semen"  for="semen"><span></span>Geno</label>
<input type="checkbox" name="Semen" id="semen1" value="Semex" checked ><label id="semen2"  for="semen1"><span></span>Semex</label><br>
<input type="checkbox" name="Semen" id="semen8" value="LIC"><label id="semen" for="semen8"><span></span>LIC</label>
<input type="checkbox" name="Semen" id="semen3" value="Sion"><label id="semen3" for="semen3"><span></span>Sion</label><br>
<input type="checkbox" name="Semen" id="semen4" value="WWS"><label id="semen" for="semen4"><span></span>WWS</label>
<input type="checkbox" name="Semen" id="semen5" value="CRV"><label id="semen2" for="semen5"><span></span>CRV</label><br>
<input type="checkbox" name="Semen" id="semen6" value="ABS"><label id="semen" for="semen6"><span></span>ABS</label>
<input type="checkbox" name="Semen" id="semen7" value="coopex" checked ><label id="semen7" for="semen7"><span></span>coopex</label><br>
</div>

</td>
</table>

</form>
</div>
</div>