<?php
	include('../codes/connect.php');
	
	$ongkir = $_POST['ongkos_kirim'];
	$invoice_total = $_POST['invoice_total'];
	$do_id = $_POST['do_id'];
	$sql_update = "UPDATE code_delivery_order SET isinvoiced = '1' WHERE id = '" . $do_id . "'";
	$result_update = $conn->query($sql_update);
	
	$sql_get = "SELECT * FROM code_delivery_order WHERE id = '" . $do_id . "'";
	$result_get = $conn->query($sql_get);
	
	$row_get = $result_get->fetch_assoc();
	$date = $row_get['date'];
	
	$customer_id = $row_get['customer_id'];
	$do_name = $row_get['name'];
	
	$fu_name = 'FU-AE-' . substr($do_name,6,100);
	
	$sql_insert = "INSERT INTO invoices (date,do_id,name,value,ongkir) VALUES
	('$date','$do_id','$fu_name','$invoice_total','$ongkir')";
	echo $sql_insert;
	$result_insert = $conn->query($sql_insert);
	
	header('location:accounting.php');
?>
	