<?php
	include('../codes/connect.php');
	$sql_disable 		= "SELECT 
						(SELECT COUNT(id) FROM code_purchaseorder WHERE supplier_id = '" . $row['id'] . "') AS purchase_order_count,
						(SELECT COUNT(id) FROM code_goodreceipt WHERE supplier_id = '" . $row['id'] . "') AS gr_count,
						(SELECT COUNT(id) FROM purchases WHERE supplier_id = '" . $row['id'] . "') AS purchase_count";
	$result_disable 	= $conn->query($sql_disable);
	$disable 			= $result_disable->fetch_assoc();
	$disable_condition 	= $disable['purchase_order_count']  + $disable['gr_count'] + $disable['purchase_count'];
	
	if($disable_condition == 0){
		$sql = "DELETE FROM supplier WHERE id = '" . $_POST['supplier_id'] . "'";
		$conn->query($sql);
	}
?>