<?php
	include('../../Codes/connect.php');
	$term = $_GET['term'];
	$sql = "(SELECT name FROM customer WHERE name LIKE '%" . $term . "%' ORDER BY name)
	UNION (SELECT name FROM supplier WHERE name LIKE '%" . $term . "%' ORDER BY name) LIMIT 5";
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