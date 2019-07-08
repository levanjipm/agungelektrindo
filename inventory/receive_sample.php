<?php
	include('../codes/connect.php');
	session_start();
	$user_id = $_SESSION['user_id'];
	
	$id = $_POST['id'];
	$sql = "UPDATE code_sample SET isback = '1', date_back = CURDATE(), received_by = '" . $user_id . "'";
	$result = $conn->query($sql);
?>