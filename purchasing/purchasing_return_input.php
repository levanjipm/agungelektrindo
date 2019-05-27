<?php
	include('../codes/connect.php');
	$jumlah = $_POST['jumlah'];
	$supplier = $_POST['supplier'];
	$sql_insert = "INSERT INTO code_purchase_return (date,supplier_id,isconfirm) VALUES ('" .  date('Y-m-d')  . "','$supplier','0')";
	$result_insert = $conn->query($sql_insert);
	$sql_last = "SELECT id FROM code_purchase_return ORDER BY id DESC LIMIT 1";
	$result_last = $conn->query($sql_last);
	$last = $result_last->fetch_assoc();
	$last_id = $last['id'];
	echo ($last_id);
	
	for($i = 1; $i < $jumlah; $i++){
		$reference = $_POST['reference' . $i];
		$quantity = $_POST['quantity' . $i];
		$sql = "INSERT INTO purchase_return (reference,quantity,code_id,issent) VALUES ('$reference','$quantity','$last_id','0')";
		echo $sql;
		$result = $conn->query($sql);
	}
	if($result){
		echo ('Success!');
	}
	header('location:purchasing.php');
?>