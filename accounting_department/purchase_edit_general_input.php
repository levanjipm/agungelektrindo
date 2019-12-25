<?php
	include('../codes/connect.php');
	$purchase_id		= $_POST['purchase_id'];
	$purchase_date		= $_POST['date'];
	$purchase_name		= mysqli_real_escape_string($conn,$_POST['name']);
	$purchase_tax		= mysqli_real_escape_string($conn,$_POST['faktur']);
	
	$sql				= "UPDATE purchases SET date = '$purchase_date', name = '$purchase_name', faktur = '$purchase_faktur' WHERE id = '$purchase_id'";
	$conn->query($sql);
?>