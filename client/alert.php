<?php
function getDbConnectionn()
{
   $db = mysqli_connect('localhost','xmatchge','$Dlior)0p','xmatchge_Gen');
   mysqli_query($db, "SET NAMES 'utf8'");
   return $db;
}
$db =getDbConnectionn();
function getMesg($db, $language, $type)
{
	$returnMsg = "";
	$query = "SELECT * FROM `alert` where type='$type' and lang='$language' ;";

        $result = mysqli_query($db, $query);
        If ($result)
        {
        	$row = mysqli_fetch_assoc($result);
 		$returnMsg = $row["message"];
        }
        return $returnMsg;
}
function getBrowserLang()
{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    return $lang;
}
$browserLanguage='en';


$set2_title=getMesg($db, $browserLanguage, 'set2_title');
$set2_subtitle1=getMesg($db, $browserLanguage, 'set2_subtitle1');
$set2_subtitle2=getMesg($db, $browserLanguage, 'set2_subtitle2');
$set2_subtitle3=getMesg($db, $browserLanguage, 'set2_subtitle3');

$set2_juris1=getMesg($db, $browserLanguage, 'set2_juris1');
$set2_juris2=getMesg($db, $browserLanguage, 'set2_juris2');
$set2_juris3=getMesg($db, $browserLanguage, 'set2_juris3');
$set2_juris4=getMesg($db, $browserLanguage, 'set2_juris4');
$set2_juris5=getMesg($db, $browserLanguage, 'set2_juris5');
$set2_juris6=getMesg($db, $browserLanguage, 'set2_juris6');
$set2_juris7=getMesg($db, $browserLanguage, 'set2_juris7');

$set2_manufacture1=getMesg($db, $browserLanguage, 'set2_manufacture1');
$set2_manufacture2=getMesg($db, $browserLanguage, 'set2_manufacture2');
$set2_manufacture3=getMesg($db, $browserLanguage, 'set2_manufacture3');
$set2_manufacture4=getMesg($db, $browserLanguage, 'set2_manufacture4');
$set2_manufacture5=getMesg($db, $browserLanguage, 'set2_manufacture5');
$set4_backup=getMesg($db, $browserLanguage, 'set4_backup'); 

$bull1=getMesg($db, $browserLanguage, 'bull_no');
$cows1=getMesg($db, $browserLanguage, 'cow_no');

$popup_sire=getMesg($db, $browserLanguage, 'sire');
$popup_PGS=getMesg($db, $browserLanguage, 'PGS');
$popup_MGS=getMesg($db, $browserLanguage, 'MGS');
$popup_active=getMesg($db, $browserLanguage, 'active');
?>