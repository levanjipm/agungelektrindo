<?php
	//Edit invoice//
	include('../codes/connect.php');
	session_start();
	if(empty($_SESSION['user_id'])){
		header('../landing_page.php');
	}
	$method = $_POST['select_method'];
	if($method == 0){
		header('edit_invoice_validate.php');
	}
	$invoice_id = $_POST['invoice_id'];
	$sql_invoice = "SELECT name FROM invoices WHERE id = '" . $invoice_id . "'";
	$result_invoice = $conn->query($sql_invoice);
	$invoice = $result_invoice->fetch_assoc();
	$invoice_name = $invoice['name'];
	$do_name = 'SJ-AE-' . substr($invoice_name,6,100);
	
	$sql_do = "SELECT so_id FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$result_do = $conn->query($sql_do);
	$do = $result_do->fetch_assoc();
	$so_id = $do['so_id'];
	
	$x = $_POST['x'];
	$i = 1;
	$total = 0;
	if($method == 2){		
		//Edit net price//
		for($i = 1; $i < $x; $i++){
			$reference = $_POST['reference' . $i];
			$quantity = $_POST['qty' . $i];
			$pricelist = $_POST['pl' . $i];
			$price = $_POST['price' . $i];
			$discount = 100 * ($pricelist - $price)/ $pricelist;
			$sql = "UPDATE sales_order SET price = '" . $price . "', discount = '" . $discount . "' 
			WHERE so_id = '" . $so_id . "' AND reference = '" . $reference . "'";
			$result_sql = $conn->query($sql);
			$total = $total + $quantity * $price;
		};
	} else {
		//Edit discount//
		for($i = 1; $i < $x; $i++){
			$reference = $_POST['reference' . $i];
			$quantity = $_POST['qty' . $i];
			$pricelist = $_POST['pl' . $i];
			$discount = $_POST['discount' . $i];
			$price = $pricelist * (100 - $discount) / 100;
			$sql = "UPDATE sales_order SET price = '" . $price . "', discount = '" . $discount . "' 
			WHERE so_id = '" . $so_id . "' AND reference = '" . $reference . "'";
			$result = $conn->query($sql);
			$total = $total + $quantity * $price;
		}
	}
	$sql_totalis = "UPDATE invoices SET value = '" . $total . "' WHERE id = '" . $invoice_id . "'";
	$result_totalis = $conn->query($sql_totalis);
	$value_so = 0;
	$sql_code = "SELECT price,quantity FROM sales_order WHERE so_id = '" . $so_id . "'";
	$result_code = $conn->query($sql_code);
	while($code = $result_code->fetch-assoc()){
		$value_so = $value_so + $code['quantity'] * $code['price'];
	}
	$sql_insert = "UPDATE code_salesorder SET value = '" . $value_so . "' WHERE id = '" . $so_id . "'";
	$result_insert = $conn->query($sql_insert);
?>