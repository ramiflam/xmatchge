<?php
include 'functions.php';
$db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
// sql to check if exist
/*
$sql = "DROP TABLE IF EXISTS `user_settings`";
if ($db->query($sql) === TRUE) {
    echo "Table user_settings exist";
} 
else
{
*/
// sql to create table user_settings
$sql = "CREATE TABLE user_settings
(user_id VARCHAR(30),
Last_update_local DATETIME,
Last_update_web DATETIME,
Days_to_the_warning_on_lack_of_update INT(2) DEFAULT '10',
Update_type INT(1),
backup_folder VARCHAR(250) DEFAULT 'c:/xmate',
Prestnge_using_beef_bulls DECIMAL(4.2),
Number_of_cows_for_beef_bulls INT(5),
Minum_lactation_for_beef_bulls INT(5),
Beef_breed_to_use CHAR(3),
Prestnge_using_sexed_semen VARCHAR(30),
Number_of_cows_for_sexed_semen INT(2),
Rest_month_for_heifers INT(2) DEFAULT '14',
Rest_days_for_lact_no_1 INT(3) DEFAULT '90',
Rest_days_for_adult_cows INT(3) DEFAULT '60',
Crossbreeding_program VARCHAR(30));";

if ($db->query($sql) === TRUE) {
    echo "Table user_settings created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
// sql to create table users_details
$sql = "CREATE TABLE users_details
(User_Name VARCHAR(50),
Password VARCHAR(50),
User_type VARCHAR(20),
User_E_Mail VARCHAR(50),
User_Address VARCHAR(50),
Date_joined DATETIME,
Farm VARCHAR(50),
User_First_Name VARCHAR(50),
User_Last_Name VARCHAR(50),
Language CHAR(2),
Farm_location POINT,
Country VARCHAR(50),
Last_Location POINT,
Distrbuter_User_Id INT(11) ,
Genetic_protocol VARCHAR(10),
TNC_accepted CHAR(1)DEFAULT 'N');";

if ($db->query($sql) === TRUE) {
    echo "Table users_details created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
// sql to create table supported_languages
$sql = "CREATE TABLE supported_languages
(Lang CHAR(2) DEFAULT 'EN',
Description VARCHAR(50),
Allignment CHAR(3)DEFAULT 'L2R');";
if ($db->query($sql) === TRUE) {
    echo "Table supported_languages created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
// sql to create table messages
$sql = "CREATE TABLE messages
(type VARCHAR(50),
lang CHAR(2),
message  VARCHAR(250));";
if ($db->query($sql) === TRUE) {
    echo "Table messages created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
// sql to create table file_audit
$sql = "CREATE TABLE file_audit
(FileName VARCHAR(50),
FilePath VARCHAR(100),
TimeLoaded  DATETIME,
TimeProcess DATETIME,
NumberOfRecords INT(11), 
RunStatus VARCHAR(20),
User VARCHAR(50));";
if ($db->query($sql) === TRUE) {
    echo "Table file_audit created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

// sql to create table breeds_table
$sql = "CREATE TABLE bre
(BreedCode_3_ch CHAR(3),
BreedCode_2_ch	CHAR(2),
BreedType  CHAR(10),
ISRcode INT(2),
HebrewName CHAR(15), 
Days_prg INT(2));";
if ($db->query($sql) === TRUE) {
    echo "Table breeds_table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
$db->close();
?>