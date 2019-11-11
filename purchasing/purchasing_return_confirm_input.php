<?php
	include('../codes/connect.php');
	if(empty($_POST)){
		header('location:return_confirm_dashboard.php');
	} else {
		$id = $_POST['id'];
		$sql = "UPDATE code_purchase_return SET isconfirm = '1' WHERE id = '" . $id . "'";
		$result = $conn->query($sql);
	}
	header('location:return_confirm_dashboard.php');
?>