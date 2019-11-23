<?php
	include('../codes/connect.php');
	$customer_id		= $_GET['customer_id'];
	$sql				= "SELECT default_top FROM customer WHERE id = '$customer_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	echo $row['default_top'];
?>