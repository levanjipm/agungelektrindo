<?php
	//Action return input//
	include('../codes/connect.php');
	$return_id		= mysqli_real_escape_string($conn,$_POST['return_id']);
	$sql_update 	= "UPDATE code_sales_return SET isconfirm = '1' WHERE id = '" . $return_id . "'";
	$conn->query($sql_update);
	
	header('location:sales.php');
?>