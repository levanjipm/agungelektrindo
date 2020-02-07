<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_GET['delivery_order_id'];
	
	$sql			= "SELECT sent FROM code_delivery_order WHERE id = '$delivery_order_id'";
	$result			= $conn->query($sql);
	$row			= $result->fetch_assoc();
	
	$sent			= $row['sent'];
	if($sent		== 1){
		echo 1;
	} else if(mysqli_num_rows($result) == 0){
		echo 1;
	}	
?>