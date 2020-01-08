<?php
	include('../codes/connect.php');
	$invoice_id			= $_POST['invoice_id'];
	$delivery_fee		= $_POST['delivery_fee'];
	
	$sql				= "UPDATE invoices SET ongkir = '$delivery_fee' WHERE id = '$invoice_id'";
	$conn->query($sql);
?>