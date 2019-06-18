<?php
	include('../codes/connect.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		header('location:inventory.php');
	}
	$user_id = $_SESSION['user_id'];
	$project_id = $_POST['projects'];
	
	$sql_project = "INSERT INTO project_delivery_order (date,project_id,created_by) VALUES (CURDATE(),'$project_id','$user_id')";
	$result_project = $conn->query($sql_project);
	
	$sql_select = "SELECT id FROM project_delivery_order ORDER BY id DESC LIMIT 1";
	$result_select = $conn->query($sql_select);
	$select = $result_select->fetch_assoc();
	
	$do_id = $select['id'];
	
	$jumlah = $_POST['jumlah'];
	
	for($i = 1; $i <= $jumlah; $i++){
		$reference = $_POST['reference' . $i];
		$quantity = $_POST['quantity' . $i];

		$sql = "INSERT INTO project (reference,quantity,project_do_id) VALUES ('$reference','$quantity','$do_id')";
		$result = $conn->query($sql);
	}
	header('location:inventory.php');
?>