<?php
	include('../codes/connect.php');
	$receivable_id			= $_POST['receivable_id'];
	
	$sql					= "SELECT * FROM receivable WHERE id = '$receivable_id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	$invoice_id				= $row['invoice_id'];
	$sql_update				= "UPDATE invoices SET isdone = '0' WHERE id = '$invoice_id'";
	$conn->query($sql_update);
	
	$sql					= "DELETE FROM receivable WHERE id = '$receivable_id'";
	$result					= $conn->query($sql);
?>