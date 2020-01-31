<?php
	include('../codes/connect.php');
	session_start();
	$reference 		= mysqli_real_escape_string($conn,$_POST['reference']);
	$description 	= mysqli_real_escape_string($conn,$_POST['description']);
	$type 			= $_POST['item_type'];
	$user_id 		= $_SESSION['user_id'];
	
	$sql_first 		= "SELECT COUNT(id) AS initial_count FROM itemlist WHERE reference = '" . $reference . "'";
	$result_first 	= $conn->query($sql_first);
	$first 			= $result_first->fetch_assoc();
	if($first['initial_count']){
	} else {
		$sql = "INSERT INTO itemlist (date,reference,description,type,isactive,created_by)
				VALUES (CURDATE(),'$reference','$description','$type','1','$user_id')";
		$conn->query($sql);
	}
	
	header('location:/agungelektrindo/purchasing_department/item_manage_dashboard');
?>