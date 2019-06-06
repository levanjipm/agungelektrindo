<?php
	include('../codes/connect.php');
	print_r($_POST);
	$jumlah = $_POST['jumlah'];
	$supplier = $_POST['supplier'];
	$sql_insert = "INSERT INTO code_purchase_return (date,supplier_id,isconfirm) VALUES ('" .  date('Y-m-d')  . "','$supplier','0')";
	$result_insert = $conn->query($sql_insert);
	$sql_last = "SELECT id FROM code_purchase_return ORDER BY id DESC LIMIT 1";
	$result_last = $conn->query($sql_last);
	$last = $result_last->fetch_assoc();
	$last_id = $last['id'];
	
	$total_price = 0;
	
	for($i = 1; $i < $jumlah; $i++){
		$reference = $_POST['reference' . $i];
		$quantity = $_POST['quantity' . $i];
		if(empty($_POST['check' . $i])){
			$price = $_POST['radio' . $i];
		} else {
			$price = $_POST['manual_price' . $i];
		}
		$total_price = $total_price + $price * $quantity;
		$sql = "INSERT INTO purchase_return (reference,quantity,price,code_id) VALUES ('$reference','$quantity','$price','$last_id')";
		$result = $conn->query($sql);
	}
	$sql_update = "UPDATE code_purchase_return SET value = '" . $total_price . "' WHERE id = '" . $last_id . "'";
	$result_update = $conn->query($sql_update);
	
	header('location:purchasing.php');
?>