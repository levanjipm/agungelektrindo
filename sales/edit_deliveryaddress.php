<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	$tag = $_POST['tag'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	
	$sql_update = "UPDATE delivery_address SET tag = '" . $tag . "', address = '" . $address . "', city = '" . $city . "'
	WHERE id = '" . $id . "'";
	$result_update = $conn->query($sql_update);
	header('location:editdeliveryaddress_sales_dashboard.php');
?>
	