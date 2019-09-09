<?php
	include('../codes/connect.php');
	$sales_order_id = mysqli_real_escape_string($conn,$_POST['sales_order_id']);
	
	$sql	= "SELECT * FROM sales_order WHERE id = '" . $sales_order_id . "'";
	$result	= $conn->query($sql);
	$row	= $result->fetch_assoc();
	$sent_quantity	= $row['sent_quantity'];
	if($sent_quantity == 0){
		$sql 	= "DELETE FROM sales_order WHERE id = '" . $sales_order_id . "'";
		$result	= $conn->query($sql);
	}
	
	if($result && $sent_quantity == 0){
		echo ('1');
	} else {
		echo ('0');
	}
?>