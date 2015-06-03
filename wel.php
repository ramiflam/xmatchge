<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>XML read </title>
<head/>
<body>

<?php
$xml=simplexml_load_file("config.xml") or die ("Error: Cannot create object"); 
 
// print_r($xml);

foreach($xml->children() as $langs) { 
    echo "lang is &nbsp;" . $langs->val . ", "; 
    echo "value is &nbsp;" . $langs->phrase->value. ", ";
    echo "content is &nbsp;" . $langs->phrase->content . "<br> "; 
 } 

?>
</body>
</html>