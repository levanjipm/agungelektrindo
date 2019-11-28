<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	
	$sql_get = "SELECT project_id FROM code_delivery_order WHERE id = '" . $id . "'";
	$result_get = $conn->query($sql_get);
	$get = $result_get->fetch_assoc();
	$project_id = $get['project_id'];
	
	$sql_update = "UPDATE code_project SET issent = '0' WHERE id = '" . $project_id . "'";
	$conn->query($sql_update);
	
	$sql = "DELETE FROM code_delivery_order WHERE id = '" . $id . "'";
	$conn->query($sql);
?>