<?php
	include('../codes/connect.php');
	
	$ongkir 				= $_POST['delivery_fee'];
	$down_payment			= $_POST['down_payment'];
	if($down_payment		== ''){
		$down_payment		= 0;
	}
	
	$invoice_total 			= $_POST['invoice_total'];
	$delivery_order_id 		= $_POST['delivery_order_id'];
	$sql_update 			= "UPDATE code_delivery_order SET isinvoiced = '1' WHERE id = '" . $delivery_order_id . "'";
	$result_update 			= $conn->query($sql_update);
	
	$sql_get 				= "SELECT name, date FROM code_delivery_order WHERE id = '" . $delivery_order_id . "'";
	$result_get 			= $conn->query($sql_get);
	
	$row_get 				= $result_get->fetch_assoc();
	$date 					= $row_get['date'];

	$do_name 				= $row_get['name'];
	
	$fu_name 				= 'FU-AE-' . substr($do_name,6,100);
	
	$sql_insert 			= "INSERT INTO invoices (date,do_id,name,value,ongkir, down_payment) VALUES
								('$date','$delivery_order_id','$fu_name','$invoice_total','$ongkir', '$down_payment')";
								
	$result_insert 			= $conn->query($sql_insert);
	
	header('location:../accounting');
?>
	