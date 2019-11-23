<?php
	include('../codes/connect.php');
	$customer_id		= (int)mysqli_real_escape_string($conn,$_POST['customer_id']);
	$sql_update			= "UPDATE customer SET is_blacklist = '1' WHERE id = '$customer_id'";
	$conn->query($sql_update);
?>