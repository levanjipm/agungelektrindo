<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	$sql_select = "SELECT * FROM code_goodreceipt WHERE invoice_id = '" . $id . "'";
	$result_select = $conn->query($sql_select);
	while($select = $result_select->fetch_assoc()){
		$sql_update = "UPDATE code_goodreceipt SET isinvoiced = '0', invoice_id = '0' WHERE id ='" . $select['id'] . "'";
		$result_update = $conn->query($sql_update);
	};
	$sql = "DELETE FROM purchases WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
?>	