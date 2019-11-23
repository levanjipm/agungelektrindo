<?php
	include('../codes/connect.php');
	$customer_id = $_POST['id'];
	$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$name = $customer['name'];
	$sql_check = "SELECT
		(SELECT COUNT(id) FROM code_salesorder WHERE customer_id = '" . $customer_id . "') AS table1,
		(SELECT COUNT(id) FROM code_quotation WHERE customer_id = '" . $customer_id . "') AS table2,
		(SELECT COUNT(id) FROM code_bank WHERE name = '" . $name . "') AS table3,
		(SELECT COUNT(id) FROM code_delivery_order WHERE customer_id = '" . $customer_id . "') AS table4,
		(SELECT COUNT(id) FROM code_project WHERE customer_id = '" . $customer_id . "') AS table5";
	$result_check = $conn->query($sql_check);
	$check = $result_check ->fetch_assoc();
	$disabled = $check['table1'] + $check['table2'] + $check['table3'] + $check['table4'] + $check['table5'];
	
	if($disabled == 0){
		$sql_delete = "DELETE FROM customer WHERE id = '" . $customer_id . "'";
		echo $sql_delete;
		$result_delete = $conn->query($sql_delete);
	}
	
?>