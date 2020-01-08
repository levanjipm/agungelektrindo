<?php
	include('../codes/connect.php');
	$invoice_id 	= $_POST['invoice_id'];
	$delivery_fee 	= $_POST['delivery'];
	$faktur 		= $_POST['faktur'];
	
	$sql 			= "UPDATE invoices SET ongkir = '" . $delivery_fee . "', faktur = '" . $faktur . "' WHERE id = '" . $invoice_id . "'";
	$result 		= $conn->query($sql);
?>