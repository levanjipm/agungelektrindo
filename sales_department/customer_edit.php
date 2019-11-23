<?php
	include("../codes/Connect.php");
	$customer_id		= $_POST['customer_id'];
	
	$customer_name	     = mysqli_real_escape_string($conn,$_POST['customer_name']);	
	$customer_address    = mysqli_real_escape_string($conn,$_POST['customer_address']);
	$customer_city	     = mysqli_real_escape_string($conn,$_POST['customer_city']);
	$customer_phone	     = mysqli_real_escape_string($conn,$_POST['customer_phone']);
	
	$sql_check			= "SELECT COUNT(*) as duplicate FROM customer WHERE name = '$customer_name' AND id <> '$customer_id'";
	$result_check		= $conn->query($sql_check);
	$check				= $result_check->fetch_assoc();
	$duplicate			= $check['duplicate'];
	
	if($duplicate 		== 0){
		$sql 			= "UPDATE customer
						SET name='$customer_name', address='$customer_address', phone='$customer_phone', city='$customer_city' WHERE id='$customer_id'";
		$conn->query($sql);
	}
?>
