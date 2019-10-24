<?php
	include('../codes/connect.php');
	$id			= $_POST['id'];
	$class_name	= mysqli_real_escape_string($conn,$_POST['class_name']);
	$sql_check	= "SELECT * FROM itemlist_category WHERE name = '$class_name' AND id <> '$id'";
	$result_check	= $conn->query($sql_check);
	
	if(mysqli_num_rows($result_check) == 0){
		$sql		= "UPDATE itemlist_category SET name = '$class_name' WHERE id = '$id'";
		$conn->query($sql);
	}
?>