<?php
	include('../codes/connect.php');
	session_start();
	$user_id = $_SESSION['user_id'];
	
	$email			= mysqli_real_escape_string($conn,$_POST['email']);
	$address		= mysqli_real_escape_string($conn,$_POST['address']);
	$city			= mysqli_real_escape_string($conn,$_POST['city']);
	$bank			= mysqli_real_escape_string($conn,$_POST['bank']);
	
	if($_POST['password'] == ''){
		$password_real = '';
		$sql = "UPDATE 
	} else {
		$password_real	= mysqli_real_escape_string($conn,$_POST['password']);
	}
?>