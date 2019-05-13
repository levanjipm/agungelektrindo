<?php
	include('../codes/connect.php');
	session_start();
	$sql_pin = "SELECT pin FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_pin = $conn->query($sql_pin);
	if(!$result_pin || empty($_POST['id'])){
		header('location:sales.php');
	}
	$so_id = $_POST['id'];
	$sql_update = "UPDATE sales_order_sent SET status = '1' WHERE so_id = '" . $so_id . "'";
	echo $sql_update;
	$result_update = $conn->query($sql_update);
	header('location:editsalesorder_dashboard.php');
?>
	