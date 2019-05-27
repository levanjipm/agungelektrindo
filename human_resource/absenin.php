<?php
	include('../codes/connect.php');
	$time = $_POST['time'];
	$date = $_POST['date'];
	$user_id = $_POST['user_id'];
	
	if($_POST['tipe'] == 1){
		$sql = "INSERT INTO absentee_list (user_id,date,time) VALUES ('$user_id','$date','$time')";
		echo $sql;
		$result = $conn->query($sql);
	} else {
		$sql = "INSERT INTO absentee_list (user_id,date,time,isdelete) VALUES ('$user_id','$date','$time','1')";
		$result = $conn->query($sql);
	}
?>