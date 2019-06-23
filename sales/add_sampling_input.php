<?php
	include('../codes/connect.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		header('location:sales.php');
	}
	
	$customer = $_POST['customer'];
	$date = date('Y-m-d');
	$sql = "INSERT INTO code_sample (customer_id,date,created_by)
	VALUES ('$customer','$date','" . $_SESSION['user_id'] . "')";
	$result = $conn->query($sql);
	$sql_select = "SELECT id FROM code_sample ORDER BY id DESC LIMIT 1";
	$result_select = $conn->query($sql_select);
	$select = $result_select->fetch_assoc();
	
	$code_id = $select['id'];
	for ($i = 1; $i <= 3; $i++){
		if($_POST['reference' . $i] == '' || $_POST['quantity' . $i] == 0 || $_POST['quantity' . $i] == ''){
		} else {
			$reference = $_POST['reference' . $i];
			$quantity = $_POST['quantity' . $i];
			$sql = "INSERT INTO sample (reference,quantity,code_id)
			VALUES ('$reference','$quantity','$code_id')";
			$result = $conn->query($sql);
			$sql_sent = "INSERT INTO sample_sent (reference,quantity)
			VALUES ('$reference','0')";
			$result_sent = $conn->query($sql_sent);
		}
	}
	header('location:sales.php');
?>