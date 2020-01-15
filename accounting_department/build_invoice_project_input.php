<?php
	include('../codes/connect.php');
	$price 					= $_POST['price'];
	$delivery_order_id		= $_POST['delivery_order_id'];
	$ongkir 				= $_POST['delivery_fee'];
	$down_payment			= $_POST['down_payment'];
	if($down_payment		== ''){
		$down_payment		= 0;
	}
	
	$sql_invoice_name		= "SELECT date, name FROM code_delivery_order WHERE id = '$delivery_order_id'";
	$result_invoice			= $conn->query($sql_invoice_name);
	$invoice				= $result_invoice->fetch_assoc();
		
	$date					= $invoice['date'];
	
	$delivery_order_name	= $invoice['name'];
	$inv_name_raw 			= substr($delivery_order_name,6);
	$inv_name 				= "FU-AE-" . $inv_name_raw;
	
	$sql					= "INSERT INTO invoices (date,do_id,name,value,ongkir, down_payment) VALUES
								('$date','$delivery_order_id','$inv_name','$price','$ongkir', '$down_payment')";
	$result					= $conn->query($sql);
	
	if($result){	
		$sql_update			= "UPDATE code_delivery_order SET isinvoiced = '1' WHERE id = '$delivery_order_id'";
		$result				= $conn->query($sql_update);
	}
	
	header('location:/agungelektrindo/accounting');
?>