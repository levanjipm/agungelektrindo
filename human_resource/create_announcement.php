<?php
	//Creating new announcemnt!//
	include('../codes/connect.php');
	
	$date 			= $_POST['date'];
	$subject 		= $_POST['subject'];
	$description 	= mysqli_real_escape_string($conn,$_POST['description']);
	$created_by		= $_POST['created_by'];
	
	$sql = "INSERT INTO announcement (date,event,description,created_by) VALUES ('$date','$subject','$description','$created_by')";
	echo $sql;
	$conn->query($sql);
?>