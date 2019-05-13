<?php
	include("../Codes/connect.php");
	$id = $_GET['id'];
	$sql = "UPDATE itemlist SET isactive = '0' WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	header('location:edititem_dashboard.php');
?>