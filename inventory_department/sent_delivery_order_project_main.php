<?php
	include('../codes/connect.php');
	session_start();
	$confirmer = $_SESSION['user_id'];
	
	$id = $_GET['id'];
	$sql_check = "SELECT sent FROM code_delivery_order WHERE id = '" . $id . "'";
	$result_check = $conn->query($sql_check);
	$check = $result_check->fetch_assoc();
	$sent = $check['sent'];
	
	if($sent == 1){
		echo 0;
	} else {
		$sql = "UPDATE code_delivery_order SET sent = '1', confirm_date = CURDATE(), confirmed_by = '$confirmer' WHERE id = '" . $id . "'";
		$result = $conn->query($sql);
		echo 1;
	}	
?>