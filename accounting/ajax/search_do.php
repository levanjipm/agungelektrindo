<?php
	include("../../codes/connect.php");
	$term = $_GET['term'];
	$sql = "SELECT * FROM code_delivery_order WHERE isinvoiced = '0' AND name LIKE '%" . $term . "%' AND sent = '1' LIMIT 5";
	$result = $conn->query($sql);
	$i=0;
	while($row = $result->fetch_object()) {
		$function_result[$i]=$row->name;
		$i++;
	}
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-Type: application/json; charset=utf-8");
	echo json_encode($function_result);
?>