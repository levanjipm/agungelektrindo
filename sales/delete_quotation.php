<?php
	include('../codes/connect.php');
	$id = $_GET['id'];
	$sql = "UPDATE code_quotation SET isdelete = '1' WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	header('location:editquotation_dashboard.php');
?>