<?php
	ob_start();
	include('../Codes/connect.php');
	
	$reference 		= mysqli_real_escape_string($conn,$_POST['reference']);
	$description 	= mysqli_real_escape_string($conn,$_POST['description']);
	$type 			= $_POST['type'];
	$user_id 		= $_POST['user'];
	
	$sql_first = "SELECT COUNT(id) AS initial_count FROM itemlist WHERE reference = '" . $reference . "'";
	$result_first = $conn->query($sql_first);
	$first = $result_first->fetch_assoc();
	if($first['initial_count']){
		echo ('0'); //Item existed//
	} else {
		$sql = "INSERT INTO itemlist (date,reference,description,type,isactive,created_by)
		VALUES (CURDATE(),'$reference','$description','$type','1','$user_id')";
		$result = $conn->query($sql);
		if($result){
			echo ('1'); //Success//
		} else {
			echo ('2'); //Failed//
		}
	}
?>