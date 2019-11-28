<?php
	include('../codes/connect.php');
	$purchase_order_id			= $_POST['purchase_order_id'];
	$sql						= "SELECT received_quantity FROM purchaseorder WHERE id = '$purchase_order_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
	
	$received_quantity			= $row['received_quantity'];
	if($received_quantity		== 0){
		$sql_delete				= "DELETE FROM purchaseorder WHERE id = '$purchase_order_id'";
		$result_delete			= $conn->query($sql_delete);
	}
?>