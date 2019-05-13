<?php
	include('../codes/connect.php');
	if(empty($_POST['date']) || empty($_POST['value']) || empty($_POST['lawan'])){
		header('location:add_transaction_dashboard.php');	
	} else {
		$date = $_POST['date'];
		$value = $_POST['value'];
		$lawan = $_POST['lawan'];
		$transaction = $_POST['transaction'];
	}
	$sql_insert = "INSERT INTO code_bank (date,value,transaction,name)
	VALUES ('$date','$value','$transaction','$lawan')";
	$result_insert = $conn->query($sql_insert);
	header('location:add_transaction_dashboard.php');
?>