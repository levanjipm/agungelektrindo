<?php
	include('../codes/connect.php');
	session_start();
	$user_id 			= $_SESSION['user_id'];
	
	$date 				= $_POST['date'];
	$total 				= 0;
	$po_gr_array		= $_POST['po_gr'];
	$code_gr_array		= $_POST['code_gr'];
	$input_array		= $_POST['input'];
	$supplier_id 		= mysqli_real_escape_string($conn,$_POST['supplier']);
	
	print_r($po_gr_array);
	echo '<br>';
	
	foreach($po_gr_array as $po){
		$gr				= key($po_gr_array);
		$sql_gr			= "SELECT quantity FROM goodreceipt WHERE id = '" . $gr . "'";
		$result_gr		= $conn->query($sql_gr);
		$row_gr			= $result_gr->fetch_assoc();
			
		$quantity		= $row_gr['quantity'];
		$input			= (float)$input_array[$gr];
			
		$total 			= $total + $quantity * $input;
		$sql_po 		= "SELECT reference FROM purchaseorder WHERE id = '" . $po . "'";
		$result_po 		= $conn->query($sql_po);
		$po_row 		= $result_po->fetch_assoc();
		$reference 		= $po_row['reference'];
			
		$sql 			= "UPDATE stock_value_in SET price = '" . $input . "' WHERE gr_id = '" . $gr . "' AND reference = '" . $reference . "'";
		$conn->query($sql);
		
		$sql 			= "UPDATE goodreceipt SET billed_price = '" . $input . "' WHERE id = '" .  $gr . "'";
		echo $sql;
		echo '<br>';
		$conn->query($sql);
		
		next($po_gr_array);
	}
	
	$invoice_document 	= $_POST['invoice_doc'];
	$tax_document 		= $_POST['tax_doc'];
	$sql_insert 		= "INSERT INTO purchases (date,name,faktur,supplier_id,value,created_by)
						VALUES ('$date','$invoice_document','$tax_document','$supplier_id','$total','$user_id')";
	$conn->query($sql_insert);
	
	$sql_get_id 		= "SELECT id FROM purchases ORDER BY id DESC LIMIT 1";
	$result_get_id 		= $conn->query($sql_get_id);
	$get_id 			= $result_get_id->fetch_assoc();
	$purchase_id 		= $get_id['id'];
	
	foreach($code_gr_array as $code_gr){
		$sql_update 	= "UPDATE code_goodreceipt SET isinvoiced = '1', invoice_id = '"  . $purchase_id . "' WHERE id = '" . $code_gr . "'";
		$conn->query($sql_update);
		next($code_gr_array);
	}
	header('location:/agungelektrindo/accounting');
?>			