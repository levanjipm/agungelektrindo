<?php
	include('../codes/connect.php');
	$user_id			= $_POST['user_id'];
	$sql_absentee		= "SELECT DISTINCT MONTH(date) FROM absentee_list WHERE user_id = '$user_id'";
	$result_absentee	= $conn->query($sql_absentee);
	
	print_r($result_absentee);
?>