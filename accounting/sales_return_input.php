<?php
	include('../codes/connect.php');
	$i = $_POST['i'];
	$return_id = $_POST['return_id'];
	$harga_total = $_POST['harga_total'];
	
	for($x = 1; $x < $i; $x++){
		if(!empty($_POST['check_' . $x])){
			$invoice_value = $_POST['value' . $x];
			$invoice_id = $_POST['invoice' . $x];
			$pengurang = min($invoice_value,$harga_total);
			$sql = "INSERT INTO return_invoice_sales (return_id,invoice_id,value)
			VALUES ('$return_id','$invoice_id','$pengurang')";
			$result = $conn->query($sql);
			$sql_update = "UPDATE code_sales_return SET isassign = '1' WHERE id = '" . $return_id . "'";
			$result_update = $conn->query($sql_update);
			$harga_total = $harga_total - $pengurang;
			if($harga_total == 0){
				break;
			}
		}
	}
	header('location:sales_retrun_dashboard.php');
?>