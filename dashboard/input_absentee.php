<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	$date 			= $_POST['date'];
	$user_id 		= $_POST['user_id'];
	
	if($_POST['tipe'] == 1){
		$sql 		= "INSERT INTO absentee_list (user_id,date,time) VALUES ('$user_id','$date',CURTIME())";
	} else {
		$sql 		= "INSERT INTO absentee_list (user_id,date,time,isdelete) VALUES ('$user_id','$date',CURTIME(),'1')";
	}
	
	$conn->query($sql);
?>