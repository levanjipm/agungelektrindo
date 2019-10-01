<?php
	include('../codes/connect.php');
	session_start();
	$confirmed_by	= $_SESSION['user_id'];
	
	$event_id		= $_POST['event_id'];
	$sql			= "SELECT * FROM code_adjustment_event WHERE id = '$event_id' AND isconfirm = '0'";
	$result			= $conn->query($sql);
	if(mysqli_num_rows($result) == 1){
		$sql_update	= "UPDATE code_adjustment_event SET isconfirm = '1', confirmed_by = '$confirmed_by', confirm_time = NOW() WHERE id = '$event_id'";
		$conn->query($sql_update);
	};
?>