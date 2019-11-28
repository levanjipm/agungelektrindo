<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	session_start();
	$created_by			= $_SESSION['user_id'];
	
	$start_date			= $_POST['start_date'];
	$end_date			= $_POST['end_date'];
	$promo_name			= mysqli_real_escape_string($conn,$_POST['promo_name']);
	$promo_desc			= mysqli_real_escape_string($conn,$_POST['promo_desc']);
	
	$sql				= "INSERT INTO promotion (name, description, start_date, end_date, created_by) 
						VALUES ('$promo_name', '$promo_desc', '$start_date', '$end_date', '$created_by')";
	$result				= $conn->query($sql);
	if($result){
		$sql				= "SELECT id FROM promotion ORDER BY id DESC LIMIT 1";
		$result				= $conn->query($sql);
		$promo				= $result->fetch_assoc();
		$promo_id			= $promo['id'];
		
		
		$target_dir 		= "promotion_images/";
		$target_file 		= $target_dir . basename($_FILES['promo_image']["name"]);
		
		$imageFileType 		= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check 				= getimagesize($_FILES["promo_image"]["tmp_name"]);
		
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
		
		if ($_FILES["promo_image"]["size"] > 500000) {
			$uploadOk = 0;
		}
		
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$uploadOk = 0;
		}
		
		if ($uploadOk != 0) {
			if (move_uploaded_file($_FILES["promo_image"]["tmp_name"], $target_file)) {
				$sql		= "UPDATE promotion SET image_url = '" . $target_file . "' WHERE id = '$promo_id'";
				$conn->query($sql);
			}
		}
	}
	
	header('location:../sales');
?>