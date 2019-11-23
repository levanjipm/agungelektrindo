<?php
	include('../codes/connect.php');
	session_start();
	
	if(empty($_POST['id'])){
		header('location:sales');
	} else {
		$id = $_POST['id'];
		$sql = "UPDATE code_salesorder SET isconfirm = '1',confirmed_by = '" . $_SESSION['user_id'] . "', date_confirm = CURDATE() WHERE id= '" . $id . "'";
		$result = $conn->query($sql);
	}
	
	header('location:sales_order_confirm_dashboard');
?>