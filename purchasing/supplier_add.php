<?php
	include('../Codes/connect.php');
	print_r($_POST);
	
	$name		= mysqli_real_escape_string($conn,$_POST['name']);
	$address 	= mysqli_real_escape_string($conn,$_POST['address']) . " Blok " . mysqli_real_escape_string($conn,$_POST['block']) . " no." . mysqli_real_escape_string($conn,$_POST['number']) . ", RT" . mysqli_real_escape_string($conn,$_POST['rt']) . ", RW" . mysqli_real_escape_string($conn,$_POST['rw']);
	$phone		= mysqli_real_escape_string($conn,$_POST['phone']);
	$npwp		= mysqli_real_escape_string($conn,$_POST['npwp']);
	$city 		= mysqli_real_escape_string($conn,$_POST['city']);
	
	$sql_check	= "SELECT id FROM supplier WHERE name = '$name'";
	$result_check	= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
		$sql = "INSERT INTO supplier (name, address, phone, npwp,city) VALUES ('$name','$address','$phone','$npwp','$city')";
		$conn->query($sql);
	}
?>
