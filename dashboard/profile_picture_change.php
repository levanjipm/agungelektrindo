<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	session_start();
	$user_id 		= $_SESSION['user_id'];
	
	$target_dir 	= "images/users/";
	$target_file 	= $target_dir . basename($_FILES[$user_id]["name"]);
	$uploadOk 		= 1;
	$imageFileType 	= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check 			= getimagesize($_FILES[$user_id]["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}
	
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
		$uploadOk = 0;
	}
	
	$file_name = $target_dir . $user_id . "." . $imageFileType;
	if ($uploadOk != 0) {
		if (move_uploaded_file($_FILES[$user_id]["tmp_name"], $file_name)) {
			$sql = "UPDATE users SET image_url = '$file_name' WHERE id = '$user_id'";
			$conn->query($sql);
			echo $file_name;
		} else {
			echo ('images/users/users.png');
		}
	}
?>