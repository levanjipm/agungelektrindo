<?php
	include('../codes/connect.php');
	$id				= $_POST['id'];
	
	$sql			= "UPDATE code_sample_delivery_order SET isreturned = '1' WHERE id = '$id'";
	$conn->query($sql);
	
	header('location:/agungelektrindo/inventory');
?>