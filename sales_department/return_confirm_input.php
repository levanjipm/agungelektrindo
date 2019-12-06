<?php
	include('../codes/connect.php');
	$id				= $_POST['id'];
	$sql			= "UPDATE code_sales_return SET isconfirm = '1' WHERE id = '$id'";
	$conn->query($sql);
?>