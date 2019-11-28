<?php
	include("../Codes/connect.php");
	session_start();
	$sql_user 		= "SELECT role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 	= $conn->query($sql_user);
	$row_user 		= $result_user->fetch_assoc();
	$role 			= $row_user['role'];
	
	$supplier_name		= mysqli_real_escape_string($conn,$_POST['supplier_name']);
	$supplier_address	= mysqli_real_escape_string($conn,$_POST['supplier_address']);
	$supplier_city		= mysqli_real_escape_string($conn,$_POST['supplier_city']);
	$supplier_phone		= mysqli_real_escape_string($conn,$_POST['supplier_phone']);	
	$supplier_npwp		= mysqli_real_escape_string($conn,$_POST['supplier_npwp']);
	$supplier_id		= $_POST['supplier_id'];
	
	$sql_check			= "SELECT id FROM supplier WHERE name = '$supplier_name' AND id <> '$supplier_id'";
	$result_check		= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0 && $role == 'superadmin'){
		$sql 	= "UPDATE supplier
					SET name='$supplier_name', address='$supplier_address', phone='$supplier_phone', npwp='$supplier_npwp', city='$supplier_city', 
					modified_by = '" . $_SESSION['user_id'] . "', date_modified = CURDATE()
					WHERE id= '$supplier_id'";
		$conn->query($sql);
	}
?>
