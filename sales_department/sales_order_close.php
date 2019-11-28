<?php
	include('../codes/connect.php');
	session_start();
	$so_id			= $_POST['so_id'];
	
	$sql			= "UPDATE sales_order SET status = '1' WHERE so_id = '$so_id'";
	$conn->query($sql);
?>