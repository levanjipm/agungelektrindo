<?php
	include('../codes/connect.php');
	if(empty($_POST)){
		header('location:purchasing_return_confirm_dashboard');
	} else {
		$id = $_POST['id'];
		$sql = "UPDATE code_purchase_return SET isconfirm = '1' WHERE id = '" . $id . "'";
		$result = $conn->query($sql);
	}
	header('location:purchasing_return_confirm_dashboard');
?>