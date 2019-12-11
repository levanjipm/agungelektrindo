<?php
	include('../codes/connect.php');
	$id				= $_POST['return_id'];
	$sql			= "UPDATE code_purchase_return SET isconfirm = '1' WHERE id = '$id'";
	$conn->query($sql);
?>