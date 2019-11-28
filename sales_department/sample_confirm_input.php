<?php
	include('../codes/connect.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
	} else {
		$user_id 			= $_SESSION['user_id'];
		
		$sample_id 			= $_POST['id'];
		$type 				= $_POST['type'];
		
		if($type == 1){
			$sql 		= "UPDATE code_sample SET isconfirm = '1', confirmed_by = '" . $user_id . "', confirm_date = CURDATE() WHERE id = '" . $sample_id . "'";
			$conn->query($sql);
		} else {
			$sql_check  	= "SELECT issent FROM code_sample WHERE id = '" . $sample_id . "'";
			$result_check	= $conn->query($sql_check);
			$check 			= $result_check->fetch_assoc();
			if($check['issent'] == 0){
				$sql = "DELETE FROM code_sample WHERE id = '" . $sample_id . "'";
				$result = $conn->query($sql);
				
				$sql = "DELETE FROM sample WHERE code_id = '" . $sample_id . "'";
				$result = $conn->query($sql);
			}	
		}
	}
?>