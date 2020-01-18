<?php
	include('../codes/connect.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
	} else {
		$user_id 			= $_SESSION['user_id'];
		
		$sample_id 			= $_POST['id'];
		$type 				= $_POST['type'];
		
		if($type == 1){
			$sql 			= "UPDATE code_sample SET isconfirm = '1', confirmed_by = '" . $user_id . "' WHERE id = '" . $sample_id . "'";
			$conn->query($sql);
		} else {
			$sql			= "UPDATE sample SET status = '1' WHERE code_id = '$sample_id'";
			$conn->query($sql);
		}
	}
?>