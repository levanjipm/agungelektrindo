<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	$sql_delete = "DELETE FROM project WHERE project_do_id = '" . $id . "'";
	$result_delete = $conn->query($sql_delete);
	
	$sql_delete = "DELETE FROM project_delivery_order WHERE id = '" . $id . "'";
	$result_delete = $conn->query($sql_delete);
?>