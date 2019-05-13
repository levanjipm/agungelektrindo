<?php
	include("../Codes/connect.php");
	session_start();
	$name = $_POST['namaperusahaan'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$npwp = $_POST['npwp'];
	$city = $_POST['city'];
	$id = $_POST['id'];
	
	if($name == NULL){
		header('location:purchasing.php');
		die();
	} else {
	$sql_user = "SELECT role FROM users WHERE id = '" . $_SESSION['user_id'];
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$role = $row_user['role'];
	}
	if($role != 'superadmin'){
	} else {
	$sql = "UPDATE supplier
	SET name='$name', address='$address', phone='$phone', npwp='$npwp', city='$city'
	WHERE id='$id'";
	$result = $conn->query($sql);
	}
	header("Location: editsupplier_dashboard.php");
	die();
	}
?>
