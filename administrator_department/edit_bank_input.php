<?php
	include('../codes/connect.php');
	$id						= $_POST['id'];
	$sql					= "SELECT * FROM code_bank WHERE id = '$id' AND isdelete = '0' AND isdone = '0'";
	$result					= $conn->query($sql);
	if(mysqli_num_rows($result) != 0){
		$date				= $_POST['date'];
		$type				= $_POST['transaction'];
		$value				= $_POST['value'];
		$transaction_to		= strtoupper($_POST['transaction_to']);
		$opponent			= $_POST['transaction_select_to'];
		$description		= mysqli_real_escape_string($conn, $_POST['description']);
		
		$sql_update			= "UPDATE code_bank SET date = '$date', value = '$value', transaction = '$type', bank_opponent_id = '$opponent', label = '$transaction_to', description = '$description' WHERE id = '$id'";
		$conn->query($sql_update);
	};
	
	header('location:../administrator');
?>