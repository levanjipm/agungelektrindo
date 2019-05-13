<?php
	include('connect.php');
	$id = $_POST['id'];
	$name = $_POST['name'];
	$user_name = $_POST['user_name'];
	$raw_password = $_POST['password'];
	$password = md5($raw_password);
	
	$sql = "UPDATE user_id SET name = '$name' ,username = '$user_name' ,password = '$password' WHERE id = '" . $id . "'";
	$results = $conn->query($sql);
	header("location:hr.php");
?>