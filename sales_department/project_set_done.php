<?php
	include('../codes/connect.php');
	$project_id		= $_POST['project_id'];
	$date			= $_POST['date'];
	
	$sql			= "UPDATE code_project SET isdone = '1', end_date = '$date' WHERE id = '$project_id'";
	$conn->query($sql);
?>