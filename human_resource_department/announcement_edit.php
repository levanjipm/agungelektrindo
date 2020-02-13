<?php
	include('../codes/connect.php');
	
	$id				= $_POST['id'];
	$date 			= $_POST['date'];
	$subject 		= mysqli_real_escape_string($conn,$_POST['name']);
	$description 	= mysqli_real_escape_string($conn,$_POST['description']);
	
	$sql = "UPDATE announcement SET date = '$date', event = '$subject', description = '$description' WHERE id = '$id'";
	$conn->query($sql);
	
	header('location:/agungelektrindo/human_resource_department/announcement_manage_dashboard');
?>