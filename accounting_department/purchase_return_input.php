<?php
	include('../codes/connect.php');
	session_start();
	$user_id = $_POST['user_id'];
	
	$i = $_POST['i'];
	$return_id = $_POST['return_id'];
	$harga_total = $_POST['harga_total'];
	
	for($x = 1; $x < $i; $x++){
		if(!empty($_POST['check_' . $x])){
			$invoice_value = $_POST['value' . $x];
			$invoice_id = $_POST['invoice' . $x];
			$pengurang = min($invoice_value,$harga_total);
			$sql = "INSERT INTO return_invoice_purchase (return_id,invoice_id,value,assigned_by)
			VALUES ('$return_id','$invoice_id','$pengurang','$user_id')";
			$result = $conn->query($sql);
			$sql_update = "UPDATE code_purchase_return SET isassign = '1' WHERE id = '" . $return_id . "'";
			$result_update = $conn->query($sql_update);
			$harga_total = $harga_total - $pengurang;
			if($harga_total == 0){
				break;
			}
		}
	}
	header('location:purchasing_return_dashboard.php');
?>