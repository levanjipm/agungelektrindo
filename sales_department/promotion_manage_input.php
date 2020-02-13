<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	print_r($_FILES);
	$id							= $_POST['promo_id'];
	$sql_ongoing				= "SELECT * FROM promotion WHERE end_date > CURDATE() AND id = '$id' ORDER BY end_date ASC";
	$result_ongoing				= $conn->query($sql_ongoing);
	
	if(mysqli_num_rows($result_ongoing) != 0){
		$promotion_name			= mysqli_real_escape_string($conn,$_POST['promotion_name']);
		$promotion_description	= mysqli_real_escape_string($conn,$_POST['promotion_description']);
		$promo_start_date		= $_POST['promo_start_date'];
		$promo_end_date			= $_POST['promo_end_date'];
		
		$sql					= "UPDATE promotion SET name = '$promotion_name', description = '$promotion_description', start_date = '$promo_start_date', end_date = '$promo_end_date' WHERE id = '$id'";
		$result					= $conn->query($sql);
		echo $sql;
		
		if(!empty($_FILES['promo_image'])){
			if ($_FILES['promo_image']['size'] > 0){
			
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
						$sql		= "UPDATE promotion SET image_url = '" . $target_file . "' WHERE id = '$id'";
						$conn->query($sql);
					}
				}
			}
		}
	}
	
	header('location:promotion_manage_dashboard');
?>