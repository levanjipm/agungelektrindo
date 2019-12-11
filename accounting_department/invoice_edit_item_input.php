<?php
	include('../codes/connect.php');
	$delivery_order_id			= $_POST['delivery_order_id'];
	$price						= max(0,$_POST['price']);
	
	$sql						= "UPDATE delivery_order SET billed_price = '$price' WHERE id = '$delivery_order_id'";
	$result						= $conn->query($sql);
	if($result){
		$sql_get				= "SELECT do_id FROM delivery_order WHERE id = '$delivery_order_id'";
		$result_get				= $conn->query($sql_get);
		$get					= $result_get->fetch_assoc();
		
		$code_delivery_order	= $get['do_id'];
		$invoice_value			= 0;
		
		$sql_update				= "SELECT quantity, billed_price FROM delivery_order WHERE do_id = '$code_delivery_order'";
		$result_update			= $conn->query($sql_update);
		while($update			= $result_update->fetch_assoc()){
			$update_price		= $update['billed_price'];
			$update_quantity	= $update['quantity'];
			
			$invoice_value		+= $update_price * $update_quantity;
		}
		
		$sql_invoice			= "UPDATE invoices SET value = '$invoice_value' WHERE do_id = '$code_delivery_order'";
		echo $sql_invoice;
		$result_invoice			= $conn->query($sql_invoice);
	}
?>