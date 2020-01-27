<?php
	include('../codes/connect.php');
	$project_id			= $_POST['project_id'];
	$sql				= "UPDATE code_project SET issent = '1' WHERE id = '$project_id'";
	$conn->query($sql);
?>