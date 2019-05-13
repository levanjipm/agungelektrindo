<?php
	//Creating new announcemnt!//
	include('../codes/connect.php');
	$date = $_POST['announcement_date'];
	$event = $_POST['event'];
	$sql = "INSERT INTO announcement (date,event) VALUES ('$date','$event')";
	$result = $conn->query($sql);
	header('location:user_dashboard.php');
?>