<?php
	include('../codes/connect.php');
	$payable_id				= $_POST['payable_id'];
	
	$sql					= "SELECT * FROM payable WHERE id = '$payable_id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	$purchase_id				= $row['purchase_id'];
	
	$sql_update				= "UPDATE purchases SET isdone = '0' WHERE id = '$purchase_id'";
	$conn->query($sql_update);
	
	$sql					= "DELETE FROM payable WHERE id = '$payable_id'";
	$result					= $conn->query($sql);
?>