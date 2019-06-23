<?php
	include("../codes/Connect.php");
	$id = $_POST['id'];

	$sql_check = "SELECT * FROM customer WHERE id = '" . $id . "'";
	$result_check = $conn->query($sql_check);
	$check = $result_check->fetch_assoc();
	
	$name = mysqli_real_escape_string($conn,$_POST['namaperusahaan']);
	$address = mysqli_real_escape_string($conn,$_POST['address']);
	$phone = mysqli_real_escape_string($conn,$_POST['phone']);
	$npwp = mysqli_real_escape_string($conn,$_POST['npwp']);
	$city = mysqli_real_escape_string($conn,$_POST['city']);
	$prefix = mysqli_real_escape_string($conn,$_POST['prefix']);
	$pic = mysqli_real_escape_string($conn,$_POST['pic']);
	
	if($check['name'] == $name && $check['address'] == $address && $check['phone'] == $phone && $check['npwp'] == $npwp && $check['city'] == $city 
	&& $check['prefix'] == $prefix && $check['pic'] == $pic){
		echo ('0'); //No changes detected//
	} else {
		$sql = "UPDATE customer
		SET name='$name', address='$address', phone='$phone', npwp='$npwp', city='$city', prefix='$prefix', pic='$pic'
		WHERE id='$id'";
		$result = $conn->query($sql);
		if($result){
			echo ('1'); //Update success//
		} else {
			echo ('2'); // Update failed//
		}
	}
?>
