<?php
	include('../codes/connect.php');
	$id			= $_POST['po_id'];
	$sql		= "UPDATE purchaseorder SET status = '1' WHERE purchaseorder_id = '$id'";
	$conn->query($sql);
	
	header('location:/agungelektrindo/administrator_department/purchase_order_close_dashboard');
?>