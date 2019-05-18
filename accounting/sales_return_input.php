<?php
	include('../codes/connect.php');
	print_r($_POST);
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
			echo $sql;
			$result = $conn->query($sql);
			$harga_total = $harga_total - $pengurang;
			if($harga_total == 0){
				break;
			}
		}
	}
?>