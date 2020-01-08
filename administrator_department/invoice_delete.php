<?php
	include('../codes/connect.php');
	$invoice_id			= $_POST['invoice_id'];
	
	$sql				= "SELECT do_id FROM invoices WHERE id = '$invoice_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$do_id				= $row['do_id'];
	
	$sql_update			= "UPDATE code_delivery_order SET isinvoiced = '0' WHERE id = '$do_id'";
	$result_update		= $conn->query($sql_update);
	if($result_update){
		$sql_delete		= "DELETE FROM invoices WHERE id = '$invoice_id'";
		$conn->query($sql_delete);
	}
?>