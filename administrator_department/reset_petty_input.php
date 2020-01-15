<?php
	include('../codes/connect.php');
	$transaction_id			= $_POST['transaction_id'];
	$value					= $_POST['value'];
	$date					= $_POST['date'];
	$info					= mysqli_real_escape_string($conn,$_POST['info']);
	$classification			= $_POST['classification'];
	
	$sql					= "UPDATE petty_cash SET value = '$value', info = '$info', date = '$date', class = '$classification' WHERE id = '$transaction_id'";
	$conn->query($sql);
?>