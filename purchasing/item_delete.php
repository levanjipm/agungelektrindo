<?php
	include("../Codes/connect.php");
	$id = $_POST['id'];
	$sql_reference = "SELECT reference FROM itemlist WHERE id = '" . $id . "'";
	$result_reference = $conn->query($sql_reference);
	$reference = $result_reference->fetch_assoc();
	
	$ref = $reference['reference'];
	
	$sql_disable = "SELECT 
		(SELECT COUNT(id) FROM quotation WHERE reference = '" . $ref . "') AS quotation_count,
		(SELECT COUNT(id) FROM sales_order WHERE reference = '" . $ref . "') AS so_count,
		(SELECT COUNT(id) FROM stock WHERE reference = '" . $ref . "') AS stock_count,
		(SELECT COUNT(id) FROM stock_value_in WHERE reference = '" . $ref . "') AS value_in_count";
	$result_disable = $conn->query($sql_disable);
	$disable = $result_disable->fetch_assoc();
	$disable_condition = $disable['quotation_count']  + $disable['so_count'] + $disable['stock_count'] + $disable['value_in_count'];
	
	if($disable_condition == 0){
		$sql_delete = "DELETE FROM itemlist WHERE id = '" . $id . "'";
		$result_delete = $conn->query($sql_delete);
	}
?>