<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_POST['do_id'];
	$sql					= "SELECT * FROM service_delivery_order WHERE do_id = '$delivery_order_id'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$quantity			= $row['quantity'];
		$sales_order_id		= $row['service_sales_order_id'];
		
		$sql_service		= "SELECT quantity, done FROM service_sales_order WHERE id = '$sales_order_id'";
		$result_service		= $conn->query($sql_service);
		$service			= $result_service->fetch_assoc();
		
		$ordered			= $service['ordered'];
		$done				= $service['done'];
		
		$new_quantity		= $done - $quantity;
		$sql				= "UPDATE service_sales_order SET done = '$new_quantity', isdone = '0' WHERE id = '$sales_order_id'";
		$conn->query($sql);
	}
	
	$sql_delete				= "DELETE FROM service_delivery_order WHERE do_id = '$delivery_order_id'";
	$conn->query($sql_delete);
	
	$sql_delete				= "DELETE FROM code_delivery_order WHERE id = '$delivery_order_id'";
	$conn->query($sql_delete);
?>