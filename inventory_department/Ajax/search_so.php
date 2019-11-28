<?php
	include("../../codes/connect.php");
	$term = $_GET['term'];
	$sql_option = "SELECT DISTINCT(sales_order_sent.so_id) , sales_order_sent.status, code_salesorder.id, code_salesorder.name 
	FROM sales_order_sent 
	INNER JOIN code_salesorder ON sales_order_sent.so_id = code_salesorder.id 
	WHERE sales_order_sent.status = '0' AND code_salesorder.name LIKE '%" . $term . "%' AND code_salesorder.isconfirm = '1' LIMIT 5";
	$results = $conn->query($sql_option);
	$i=0;
	while($rows = $results->fetch_object()) {
		$function_result[$i]=$rows->name;
		$i++;
	}
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-Type: application/json; charset=utf-8");
	echo json_encode($function_result);
?>