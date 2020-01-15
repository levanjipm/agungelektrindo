<?php
	include('../codes/connect.php');
	$do_id			= $_POST['do_id'];
	$sql			= "SELECT project_id FROM code_delivery_order WHERE id = '$do_id'";
	$result			= $conn->query($sql);
	$row			= $result->fetch_assoc();
	
	$project_id		= $row['project_id'];
	
	$sql			= "UPDATE code_project SET issent = '0' WHERE id = '$project_id'";
	$result			= $conn->query($sql);
	if($result){
		$sql_delete	= "DELETE FROM code_delivery_order WHERE id = '$do_id'";
		$conn->query($sql_delete);
	};
?>