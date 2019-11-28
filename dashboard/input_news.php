<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	session_start();
	
	$creator		= $_SESSION['user_id'];
	
	$date 			= $_POST['date'];
	$subject 		= mysqli_real_escape_string($conn,$_POST['subject']);
	$description 	= mysqli_real_escape_string($conn,$_POST['description']);
	
	$sql = "INSERT INTO announcement (date,event,description,created_by) VALUES ('$date','$subject','$description','$creator')";
	echo $sql;
	$conn->query($sql);
?>