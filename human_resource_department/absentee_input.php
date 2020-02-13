<?php
	include('../codes/connect.php');
	
	$user_id		= $_GET['user_id'];
	$type			= $_GET['type'];
	
	$sql			= "SELECT id FROM absentee_list WHERE user_id = '$user_id' AND date = CURDATE()";
	$result			= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
		$sql		= "INSERT INTO absentee_list (user_id, time, date, isdelete) 
						VALUES ('$user_id', CURRENT_TIME(), CURDATE(), '$type')";
		$conn->query($sql);
	}
?>