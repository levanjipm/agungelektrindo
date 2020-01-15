<?php
	include('../codes/connect.php');
	$transaction_id			= $_POST['transaction_id'];
	$sql					= "DELETE FROM petty_cash WHERE id = '$transaction_id'";
	$conn->query($sql);
?>