<?php
	include("codes/connect.php");
	$user_name = $_POST['username'];
	$raw_password = $_POST['pass'];
	$password = md5($raw_password);
	$sql = "SELECT * FROM users WHERE username = '" . $user_name . "' AND password = '" . $password . "'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row = $results->fetch_object()){
			$user_id = $row->id;
		}
		echo ('0');
		// header('location:human_resource/user_dashboard.php?style=animate');
	} else {
		// header("location:landing_page.php");
		echo ('1');
	};
?>