<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	
	$sql_delete = "DELETE counter_bill WHERE id = '" . $id . "'";
	$result_delete = $conn->query($sql_delete);
	
	$sql_update = "UPDATE invoices SET counter_id = '' WHERE counter_id = '" . $id . "'";
	$result_update = $conn->query($sql_update);
?>