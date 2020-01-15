<?php
	include('../codes/connect.php');
	$inventory_name		= mysqli_real_escape_string($conn,$_POST['inventory_name']);		
	$inventory_desc		= mysqli_real_escape_string($conn,$_POST['inventory_desc']);		
	$inventory_date		= $_POST['inventory_date'];		
	$inventory_time		= $_POST['inventory_time'];		
	$inventory_class	= $_POST['inventory_class'];
	$inventory_value	= $_POST['inventory_value'];
	
	$sql				= "INSERT INTO inventory (name, description, purchase_date, classification, depreciation_time, initial_value)
							VALUES ('$inventory_name', '$inventory_desc', '$inventory_date', '$inventory_class', '$inventory_time', '$inventory_value')";
	echo $sql;
	$conn->query($sql);
?>