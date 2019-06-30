<?php
	include('../codes/connect.php');
	session_start();
	$user_id = $_SESSION['user_id'];
	print_r($_POST);
	$date = $_POST['date'];
	$b = $_POST['b'];
	$x = $_POST['x'];
	$total = 0;
	$supplier_id = mysqli_real_escape_string($conn,$_POST['supplier']);
	
	for($i = 1; $i < $b; $i++){
		$id = $_POST['id' . $i];
		$gr = $_POST['gr' . $i];
		$quantity = $_POST['quantity' . $i];
		$input = $_POST['input' . $i];
		$po_detail_id = $_POST['po_detail_id' + $i];
		
		$total = $total + $quantity * $input;
		
		$sql = "UPDATE stock_value_in SET price = '" . $input . "' WHERE gr_id = '" . $gr . "'";
		$result = $conn->query($sql);
		
		$sql = "UPDATE purchaseorder SET billed_price = '" . $input . "' WHERE id = '".  $po_detail_id . "'";
		$result = $conn->query($sql);
	}
	
	$invoice_document = $_POST['invoice_doc'];
	$tax_document = $_POST['tax_doc'];
	$sql_insert = "INSERT INTO purchases (date,name,faktur,supplier_id,value,created_by)
	VALUES ('$date','$invoice_document','$tax_document','$supplier_id','$total','$user_id')";
	$result_insert = $conn->query($sql_insert);
	$sql_get_id = "SELECT id FROM purchases ORDER BY id DESC LIMIT 1";
	$result_get_id = $conn->query($sql_get_id);
	$get_id = $result_get_id->fetch_assoc();
	$purchase_id = $get_id['id'];
	for($y = 1; $y < $x; $y++){
		$gr = $_POST['gr' . $y];
		$sql_update = "UPDATE code_goodreceipt SET isinvoiced = '1', invoice_id = '"  . $purchase_id . "' WHERE id = '" . $gr . "'";
		$result_update = $conn->query($sql_update);
	}
	header('location:accounting.php');
?>			