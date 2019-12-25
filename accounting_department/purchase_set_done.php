<?php
	include('../codes/connect.php');
	$purchase_id		= $_POST['purchase_id'];
	$date				= $_POST['date'];
	
	$sql_payable		= "SELECT SUM(value) as paid FROM payable WHERE purchase_id = '$purchase_id'";
	$result_payable		= $conn->query($sql_payable);
	$payable			= $result_payable->fetch_assoc();
	
	$paid				= $payable['paid'];
	
	$sql_purchase		= "SELECT value FROM purchases WHERE id = '$purchase_id'";
	$result_purchase	= $conn->query($sql_purchase);
	$purchase			= $result_purchase->fetch_assoc();
	
	$purchase_value		= $purchase['value'];
	
	$input				= $purchase_value - $paid;
	
	$sql				= "INSERT INTO payable (date, value, purchase_id) VALUES ('$date', '$input', '$purchase_id')";
	$result				= $conn->query($sql);
	
	if($result){
		$sql			= "UPDATE purchases SET isdone = '1' WHERE id = '$purchase_id'";
		$conn->query($sql);
	}
	
?>