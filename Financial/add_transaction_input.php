<?php
	include('../codes/connect.php');
	if(empty($_POST['date']) || empty($_POST['value']) || empty($_POST['opponent'])){
		header('location:add_transaction_dashboard');	
	} else {
		$date = $_POST['date'];
		$value = $_POST['value'];
		$opponent_array = preg_split("/\-/", $_POST['opponent']);
		
		$opponent_id = $opponent_array[0];
		$opponent_type = $opponent_array[1];
		
		$transaction = $_POST['transaction'];
		$description = mysqli_real_escape_string($conn,$_POST['description']);
	}
	$sql_insert = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label)
	VALUES ('$date','$value','$transaction','$opponent_id','$opponent_type')";
	$conn->query($sql_insert);
	header('location:add_transaction_dashboard');
?>