<?php
	include('../codes/connect.php');
	session_start();
	$confirmer		= $_SESSION['user_id'];

	$do_id			= $_POST['do_id'];
	$sql_update		= "UPDATE code_delivery_order SET sent = '1', confirm_date = CURDATE(), confirmed_by = '$confirmer' WHERE id = '$do_id'";
	$conn->query($sql_update);
?>