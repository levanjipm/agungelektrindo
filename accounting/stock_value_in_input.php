<?php
	include('connect.php');
	$document = $_POST['document'];
	$supplier = $_POST['supplier'];
	$sql_supplier = "SELECT id FROM supplier WHERE name = '" . $supplier . "'";
	$result_supplier = $conn->query($sql_supplier);
	while($row_supplier = $result_supplier->fetch_assoc()){
		$supplier_id = $row_supplier['id'];
	}
	$jumlah_barang = $_POST['jumlah_barang'];
	$i = 1;
	for ($i = 1; $i <= $jumlah_barang; $i++){
		$item = $_POST['reference' . $i];
		$quantity = $_POST['quantity' . $i];
		$price = $_POST['price' . $i];
		$sql = "INSERT INTO stock_value_in (reference, quantity, price, supplier_id) VALUES ('$item', '$quantity', '$price', '$supplier_id')";
		print_r($sql);
		$result = $conn->query($sql);
	}
?>