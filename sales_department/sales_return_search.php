<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	
	$delivery_order_name	= mysqli_real_escape_string($conn,$_POST['delivery_order_name']);
	$sql					= "SELECT id FROM code_delivery_order WHERE name = '$delivery_order_name' AND isdelete = '0'";
	$result					= $conn->query($sql);
	
	if(mysqli_num_rows($result) > 0){
		echo 1;
	} else {
		echo 0;
	}
?>