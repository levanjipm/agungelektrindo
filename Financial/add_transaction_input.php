<?php
	include('../codes/connect.php');
	$transaction_date			= $_POST['transaction_date'];
	$transaction_value			= $_POST['transaction_value'];
	$transaction_type			= $_POST['transaction_type'];
	$transaction_to				= strtoupper($_POST['transaction_to']);
	$transaction_id				= $_POST['transaction_id'];
	$transaction_description	= mysqli_real_escape_string($conn,$_POST['transaction_description']);
	
	if(empty($transaction_date) || empty($transaction_value) || empty($transaction_type) || empty($transaction_to) || empty($transaction_id)){
		header('location:add_transaction_dashboard');
	} else {
		$sql_insert = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label, description)
		VALUES ('$transaction_date','$transaction_value','$transaction_type','$transaction_id','$transaction_to','$transaction_description')";
		$conn->query($sql_insert);;
		
		header('location:add_transaction_dashboard');
	}
?>