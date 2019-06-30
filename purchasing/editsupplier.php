<?php
	include("../Codes/connect.php");
	session_start();
	$name = mysqli_real_escape_string($conn,$_POST['namaperusahaan']);
	$address = mysqli_real_escape_string($conn,$_POST['address']);
	$phone = mysqli_real_escape_string($conn,$_POST['phone']);
	$npwp = mysqli_real_escape_string($conn,$_POST['npwp']);
	$city = mysqli_real_escape_string($conn,$_POST['city']);
	$id = mysqli_real_escape_string($conn,$_POST['id']);
	
	if($name == NULL){
		header('location:purchasing.php');
		die();
	} else {
	$sql_user = "SELECT role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user = $conn->query($sql_user);
	$row_user = $result_user->fetch_assoc();
	$role = $row_user['role'];
	
	if($role != 'superadmin'){
	} else {
	$sql = "UPDATE supplier
	SET name='$name', address='$address', phone='$phone', npwp='$npwp', city='$city', modified_by = '" . $_SESSION['user_id'] . "', date_modified = CURDATE()
	WHERE id='$id'";
	$result = $conn->query($sql);
	}
	header("Location: editsupplier_dashboard.php");
	die();
	}
?>
