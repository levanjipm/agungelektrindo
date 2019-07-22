<?php
	include('codes/connect.php');

	$sql = "SELECT stock_value_out.in_id, stock_value_out.id,stock_value_out.quantity, stock_value_in.reference FROM stock_value_out
	JOIN stock_value_in ON stock_value_out.in_id = stock_value_in.id
	WHERE stock_value_out.customer_id = '28' and stock_value_out.date='2019-02-14' ORDER BY reference ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$in_id = $row['in_id'];
		$quantity = $row['quantity'];
		
		$sql_sisa_sekarang = "SELECT sisa FROM stock_value_in WHERE id = '" . $in_id . "'";
		$result_sisa_sekarang = $conn->query($sql_sisa_sekarang);
		$sisa_sekarang = $result_sisa_sekarang->fetch_assoc();
		
		$sisa = $sisa_sekarang['sisa'];
		
		$quantity_baru = $sisa + $quantity;
		$sql_update = "UPDATE stock_value_in SET sisa = '$quantity_baru' WHERE id = '" . $in_id . "'";
		$conn->query($sql_update);
		
		$sql = "DELETE FROM stock_value_out WHERE id = '" . $row['id'] . "'";
		$conn->query($sql);
	}