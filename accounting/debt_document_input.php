<?php
	include('../codes/connect.php');
	session_start();
	$user_id = $_SESSION['user_id'];
	$date = $_POST['date'];
	$total = 0;
	$gr_array	= $_POST['gr'];
	print_r($_POST);
	$supplier_id = mysqli_real_escape_string($conn,$_POST['supplier']);
	
	for($i = 1; $i < $b; $i++){
		$id 			= mysqli_real_escape_string($conn,$_POST['id' . $i]);
		$code_gr 		= mysqli_real_escape_string($conn,$_POST['gr' . $i]);
		$quantity 		= $_POST['quantity' . $i];
		$input 			= mysqli_real_escape_string($conn,$_POST['input' . $i]);
		$po_detail_id 	= $_POST['po_detail_id' . $i];
		
		$total = $total + $quantity * $input;
		$sql_po = "SELECT reference FROM purchaseorder WHERE id = '" . $po_detail_id . "'";
		$result_po = $conn->query($sql_po);
		$po = $result_po->fetch_assoc();
		$reference = $po['reference'];
		
		$sql_select = "SELECT goodreceipt.id 
		FROM goodreceipt 
		JOIN purchaseorder_received ON purchaseorder_received.id = goodreceipt.received_id
		WHERE goodreceipt.gr_id = '" . $code_gr . "' AND purchaseorder_received.reference = '" . $reference . "'";
		echo $sql_select;
		$result_select = $conn->query($sql_select);
		$select = $result_select->fetch_assoc();
		$gr = $select['id'];
		
		$sql = "UPDATE stock_value_in SET price = '" . $input . "' WHERE gr_id = '" . $gr . "' AND reference = '" . $reference . "'";
		$result = $conn->query($sql);
		
		$sql = "UPDATE purchaseorder SET billed_price = '" . $input . "' WHERE id = '".  $po_detail_id . "'";
		$result = $conn->query($sql);
	}
	
	$invoice_document 	= $_POST['invoice_doc'];
	$tax_document 		= $_POST['tax_doc'];
	$sql_insert 		= "INSERT INTO purchases (date,name,faktur,supplier_id,value,created_by)
						VALUES ('$date','$invoice_document','$tax_document','$supplier_id','$total','$user_id')";
	$result_insert 		= $conn->query($sql_insert);
	$sql_get_id 		= "SELECT id FROM purchases ORDER BY id DESC LIMIT 1";
	$result_get_id 		= $conn->query($sql_get_id);
	$get_id 			= $result_get_id->fetch_assoc();
	$purchase_id = $get_id['id'];
	foreach($gr_array as $gr){
		$sql_update = "UPDATE code_goodreceipt SET isinvoiced = '1', invoice_id = '"  . $purchase_id . "' WHERE id = '" . $gr . "'";
		$result_update = $conn->query($sql_update);
	}
	// header('location:accounting.php');
?>			