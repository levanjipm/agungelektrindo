<?php
	//Action return input//
	include('../codes/connect.php');
	$pin = $_POST['pin'];
	if($pin == ''){
		header('location:confirm_return_dashboard.php');
	}
	$user_id = $_POST['user_id'];
	$sql_validate_user = "SELECT COUNT(*) AS jumlah FROM users WHERE id = '" . $user_id . "' AND pin = '" . $pin . "'";
	$result_validate_user = $conn->query($sql_validate_user);
	$jumlah = $result_validate_user->fetch_assoc();
	$total = $jumlah['jumlah'];
	if($total == 0){
		header('location:confirm_return_dashboard.php');
	} else {
		$return_id = $_POST['return_id'];
		$status = $_POST['status'];
	}
	if($status == 1){
		$sql_update = "UPDATE code_sales_return SET isconfirm = '1' WHERE id = '" . $return_id . "'";
		$result_update = $conn->query($sql_update);
		header('location:sales.php');
	} else if($status == 0){
		$sql_update = "DELETE code_sales_return WHERE id = '" . $return_id . "'";
		$sql_delete = "DELETE sales_return WHERE return_code = '" . $return_id . "'";
		$result_update = $conn->query($sql_update);
		$result_delete = $conn->query($Sql_delete);
		header('location:sales.php');
	} else {
		header('location:confirm_return_dashboard.php');
	}
?>