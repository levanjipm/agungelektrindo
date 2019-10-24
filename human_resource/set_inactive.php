<?php
	include('../codes/connect.php');
	$user_id		= $_POST['user_id'];
	$sql_update		= "UPDATE users SET isactive = '0' WHERE id = '$user_id'";
	$conn->query($sql_update);
?>