<?php
	include('../codes/connect.php');
	$transaction_id				= $_POST['id'];
	$transaction_to				= strtoupper($_POST['transaction_to']);
	$transaction_opponent		= $_POST['transaction_select_to'];
	$transaction_description	= mysqli_real_escape_string($conn,$_POST['description']);
	
	$sql_check					= "SELECT * FROM code_bank WHERE id = '$transaction_id' AND label IS NULL";
	$result_check				= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 1){
		$sql					= "UPDATE code_bank SET	label = '$transaction_to', bank_opponent_id = '$transaction_opponent', description = '$transaction_description' WHERE id = '$transaction_id'";
		$conn->query($sql);
	}
	
	header('location:bank_assign_data');
?>