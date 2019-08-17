<?php
	include('../codes/connect.php');
	$sql = "DELETE FROM code_salesorder WHERE id = '" . $_POST['id'] . "'";
	$conn->query($sql);
	
	$sql = "SELECT * FROM sales_order WHERE so_id = '" . $_POST['id'] . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sales_order_id = $row['id'];
		$sql = "DELETE FROM sales_order WHERE id = '" . $sales_order_id . "'";
		$conn->query($sql);
	};
?>