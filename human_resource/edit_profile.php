<?php
	//Editing profile//
	include('../codes/connect.php');
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$raw_password = $_POST['password'];
	if($id == '' || $id == NULL){
		header('location:../landing_page.php');
	} else{
		if($raw_password == ''){
			//Updating every input except the password//
			$sql_update = "UPDATE users SET name = '" . $name . "', mail = '" . $email . "' WHERE id = '" . $id . "'";
			$result_update = $conn->query($sql_update);
		} else {
			//Updating every input//
			$sql_update = "UPDATE users SET name = '" . $name . "', mail = '" . $email . "', password = '" . md5($raw_password) . "' WHERE id = '" . $id . "'";
			$result_update = $conn->query($sql_update);
		}
	}
	header('location:user_dashboard.php');
?>
		