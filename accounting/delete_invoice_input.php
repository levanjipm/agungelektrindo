<?php
	include('../codes/connect.php');
	print_r($_POST);
	$sql_select = "SELECT do_id FROM invoices WHERE id = '" . $_POST['invoice_id'] . "'";
	$result_select = $conn->query($sql_select);
	$select = $result_select->fetch_assoc();
	
	$do_id = $select['do_id'];
	
	$sql_delete = "DELETE FROM invoices WHERE id = '" . $_POST['invoice_id'] . "'";
	$result_delete = $conn->query($sql_delete);
	
	$sql_update = "UPDATE code_delivery_order SET isinvoiced = '0' WHERE id = '" . $do_id . "'";
	$result_update = $conn->query($sql_update);
	header('location:confirm_invoice_dashboard.php');
?>