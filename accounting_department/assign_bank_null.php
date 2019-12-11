<?php
	include('../codes/connect.php');
	$bank_id			= $_POST['bank_id'];
	$sql				= "UPDATE code_bank SET isdone = '1' WHERE id = '$bank_id'";
	$conn->query($sql);
?>