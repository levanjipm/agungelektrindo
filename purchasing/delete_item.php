<?php
	include("../Codes/connect.php");
	$id = $_POST['id'];
	$sql = "UPDATE itemlist SET isdelete = '1' WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	header('location:edititem_dashboard.php');
?>