<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_POST['do_id'];
	$sql					= "UPDATE code_delivery_order SET sent = '1' WHERE id = '$delivery_order_id'";
	$conn->query($sql);
?>