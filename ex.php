<?php
include 'functions.php';
include 'home.html';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$target_path='uploads/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
if(file_exists($target_path)){
 echo"the file exist";   
}

 else
{
echo"the file not exist"; 
}

require 'uploads/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
$inputFileType = 'xls';
$inputFileName = 'uploads/noag.xls';

$objReader = PHPExcel_IOFactory::createReaderForFile($inputFileType);
$objPHPExcelReader = $objReader->load($inputFileName);

$loadedSheetNames = $objPHPExcelReader->getSheetNames();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcelReader, 'CSV');

foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    $objWriter->setSheetIndex($sheetIndex);
    $objWriter->save($loadedSheetName.'.csv');
}

?>