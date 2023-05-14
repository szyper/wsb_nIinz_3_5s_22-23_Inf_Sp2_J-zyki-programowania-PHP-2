<?php
//	echo $_GET["deleteUserId"];
// print_r($_GET);
//var_dump($_GET);
require_once "./connect.php";
//$sql="DELETE FROM users WHERE `users`.`id` = $_GET[deleteUserId]";
//$sql="DELETE FROM users WHERE `users`.`id` = 7";
//$sql="DELETE FROM users WHERE `users`.`firstName` = 'Janusz'";
$sql="DELETE FROM users WHERE `users`.`id` = $_GET[deleteUserId]";
$conn->query($sql);
//echo $conn->affected_rows;

if ($conn->affected_rows == 0){
	$deleteUser = 0;
}else{
	$deleteUser = $_GET["deleteUserId"];
}

header("location: ../3_db_table_delete_add_update.php?deleteUser=$deleteUser");
