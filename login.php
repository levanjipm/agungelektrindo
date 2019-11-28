<?php
	include("codes/connect.php");
	session_start();
	$user_name 		= $_POST['username'];
	$password 		= md5($_POST['pass']);
	$sql 			= "SELECT id FROM users WHERE username = '" . $user_name . "' AND password = '" . $password . "'";
	$results 		= $conn->query($sql);
	if (mysqli_num_rows($results) > 0){
		$row					= $results->fetch_assoc();
		$user_id				= $row['id'];
		$_SESSION['user_id'] 	= $user_id;
		header('location:dashboard/user_dashboard');
	} else {
		header("location:landing_page");
	};
?>