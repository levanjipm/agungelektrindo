<?php
	include('../codes/connect.php');
	print_r($_POST);
	$username		= mysqli_real_escape_string($conn,$_POST['username']);
	$nik			= mysqli_real_escape_string($conn,$_POST['nik']);
	$name			= mysqli_real_escape_string($conn,$_POST['name']);
	$address		= mysqli_real_escape_string($conn,$_POST['address']);
	$city			= mysqli_real_escape_string($conn,$_POST['city']);
	$bank_account	= mysqli_real_escape_string($conn,$_POST['bank_account']);
	$gender			= mysqli_real_escape_string($conn,$_POST['gender']);
	$raw_password	= mysqli_real_escape_string($conn,$_POST['raw_password']);
	
	$sql_check_user		= "SELECT COUNT(id) AS count_id FROM users WHERE username = '$username'";
	$result_check_user	= $conn->query($sql_check_user);
	$check_user			= $result_check_user->fetch_assoc();
	
	$user_count		= $check_user['count_id'];
	
	if($user_count == 0){
		$sql = "INSERT INTO users (username, name, nik, address, city, bank, gender, password)
				VALUES ('$username','$name', '$nik', '$address','$city','$bank_account','$gender','" . md5($raw_password) . "')";
		$conn->query($sql);
	}
	
	header('location:add_user');
?>