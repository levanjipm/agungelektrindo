<?php
	include('../codes/connect.php');
	$start_date		= $_POST['start_date'];
	$end_date		= $_POST['end_date'];
	$promo_subject	= mysqli_real_escape_string($conn,$_POST['subject']);
	$description	= mysqli_real_escape_string($conn,$_POST['description']);
	$created_by		= $_POST['created_by'];
	
	$sql			= "INSERT INTO promotion (name,description,start_date,end_date,created_by) VALUES ('$promo_subject','$description','$start_date','$end_date','$created_by')";
	$conn->query($sql);	
?>