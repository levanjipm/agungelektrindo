<?php
	include('../codes/connect.php');
	if(empty($_POST['bank_id'])){
		header('location:reset_transaction_validation.php');
	} else {
		$bank_id = $_POST['bank_id'];
		$sql_delete = "DELETE FROM receivable WHERE bank_id = '" . $bank_id . "'";
		$result_delete = $conn->query($sql_delete);
		$sql_update = "UPDATE code_bank SET isdone = '0' AND isdelete = '0' WHERE id = '" . $bank_id . "'";
		$result_update = $conn->query($sql_update);
		
		$sql_delete_again = "DELETE FROM code_bank WHERE major_id = '" . $bank_id . "'";
		$result_delete_again = $conn->query($sql_delete_again);
	}
	header('location:financial.php');
?>