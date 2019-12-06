<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	session_start();
	
	$created_by					= $_SESSION['user_id'];
	
	$customer_npwp				= mysqli_real_escape_string($conn,$_POST['customer_npwp']);
	$customer_prefix 			= mysqli_real_escape_string($conn,$_POST['customer_prefix']);
	$customer_pic 				= mysqli_real_escape_string($conn,$_POST['customer_pic']); 	
	$customer_phone 			= mysqli_real_escape_string($conn,$_POST['customer_phone']);
	$customer_name				= mysqli_real_escape_string($conn,$_POST['customer_name']);
	$customer_alamat 			= mysqli_real_escape_string($conn,$_POST['customer_alamat']);
	$customer_blok 				= mysqli_real_escape_string($conn,$_POST['customer_blok']); 	
	$customer_rt 				= mysqli_real_escape_string($conn,$_POST['customer_rt']); 	
	$customer_rw 				= mysqli_real_escape_string($conn,$_POST['customer_rw']); 	
	$customer_city 				= mysqli_real_escape_string($conn,$_POST['customer_city']); 	
	$customer_nomor				= mysqli_real_escape_string($conn,$_POST['customer_nomor']);	
	$customer_top				= mysqli_real_escape_string($conn,$_POST['customer_top']);
	
	$customer_address			= '';
	$customer_address			.= $customer_alamat;
	$customer_address			.= ' Blok ' . $customer_blok;
	$customer_address			.= ' no.' . $customer_nomor;
	$customer_address			.= ', RT' . $customer_rt; 
	$customer_address			.= ', RW' . $customer_rw; 
	
	$sql_check					= "SELECT id FROM customer WHERE name = '$customer_name' AND city = '$customer_city'";
	$result_check				= $conn->query($sql_check);
	
	if(mysqli_num_rows($result_check) == 0){
		$sql					= "INSERT INTO customer (name, address, phone, npwp, city, prefix, pic, date_created, created_by, default_top)
								 VALUES ('$customer_name', '$customer_address' , '$customer_phone', '$customer_npwp', '$customer_city', '$customer_prefix', '$customer_pic', CURDATE(), '$created_by', '$customer_top')";
		$conn->query($sql);
	};
?>
