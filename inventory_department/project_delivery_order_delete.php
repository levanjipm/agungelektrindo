<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_POST['delivery_order_id'];
	$sql_delete				= "DELETE FROM project WHERE project_do_id = '$delivery_order_id'";
	$result_delete			= $conn->query($sql_delete);
	if($result_delete){
		$sql				= "DELETE FROM project_delivery_order WHERE id = '$delivery_order_id'";
		$conn->query($sql);
	}
?>