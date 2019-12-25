<?php
	include('../codes/connect.php');
	session_start();
	$user_id			= $_SESSION['user_id'];
	$sample_id			= $_POST['sample_id'];
	$date				= $_POST['date'];
	
	$sql				= "UPDATE code_sample SET issent = '1', date_sent = '$date', sent_by = '$user_id' WHERE id = '$sample_id'";
	$conn->query($sql);
?>