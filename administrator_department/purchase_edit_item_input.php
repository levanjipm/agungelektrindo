<?php
	include('../codes/connect.php');
	$good_receipt_id	= $_POST['good_receipt_id'];
	$price				= $_POST['price'];
	
	$sql				= "UPDATE goodreceipt SET billed_price = '$price' WHERE id = '$good_receipt_id'";
	$result				= $conn->query($sql);
	
	if($result){
		$sql_stock		= "UPDATE stock_value_in SET price = '$price' WHERE gr_id = '$good_receipt_id'";
		$conn->query($sql_stock);
		
		$sql_invoice	= "SELECT gr_id FROM goodreceipt WHERE id = '$good_receipt_id'";
		$result_invoice	= $conn->query($sql_invoice);
		$invoice		= $result_invoice->fetch_assoc();
		
		$gr_id			= $invoice['gr_id'];
		
		$sql_invoice	= "SELECT invoice_id FROM code_goodreceipt WHERE id = '$gr_id'";
		$result_invoice	= $conn->query($sql_invoice);
		$invoice		= $result_invoice->fetch_assoc();
		
		$invoice_id		= $invoice['invoice_id'];
		
		$total_price	= 0;
		$sql_select		= "SELECT quantity, billed_price FROM goodreceipt WHERE gr_id = '$gr_id'";
		$result_select	= $conn->query($sql_select);
		while($select	= $result_select->fetch_assoc()){
			$quantity	= $select['quantity'];
			$price		= $select['billed_price'];
			
			$total_price	+= $quantity * $price;
		}
		
		$sql_update		= "UPDATE purchases SET value = '$total_price' WHERE id = '$invoice_id'";
		$conn->query($sql_update);
	}
?>