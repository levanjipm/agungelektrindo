<?php
	//Editing profile//
	include('../codes/connect.php');
	session_start();
	$user_id = $_SESSION['user_id'];
	
	$email			= mysqli_real_escape_string($conn,$_POST['email']);
	$address		= mysqli_real_escape_string($conn,$_POST['address']);
	$city			= mysqli_real_escape_string($conn,$_POST['city']);
	$bank			= mysqli_real_escape_string($conn,$_POST['bank']);
	$raw_password	= mysqli_real_escape_string($conn,$_POST['password']);
	
	if($raw_password == ''){
		$sql_update = "UPDATE users SET mail = '" . $email . "', address = '" . $address . "', city = '" . $city . "', bank = '" . $bank . "' WHERE id = '" . $user_id . "'";
		$result_update = $conn->query($sql_update);
	} else {
		$sql_update = "UPDATE users SET mail = '" . $email . "', address = '" . $address . "', city = '" . $city . "', bank = '" . $bank . "', password = '" . md5($raw_password) . "' WHERE id = '" . $user_id . "'";
		$result_update = $conn->query($sql_update);
	}
?>	