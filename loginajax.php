<?php
	include("codes/connect.php");
	$user_name = mysqli_real_escape_string($conn,$_POST['username']);
	$raw_password = mysqli_real_escape_string($conn,$_POST['pass']);
	$password = md5($raw_password);
	$sql = "SELECT * FROM users WHERE username = '" . $user_name . "' AND password = '" . $password . "'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row = $results->fetch_object()){
			$user_id = $row->id;
		}
		echo ('0');
	} else {
		echo ('1');
	};
?>