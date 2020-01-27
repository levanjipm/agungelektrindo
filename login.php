<?php
	include("codes/connect.php");
	session_start();
	$user_name 		= $_POST['username'];
	$password 		= md5($_POST['pass']);
	$sql 			= "SELECT id FROM users WHERE username = '" . $user_name . "' AND password = '" . $password . "'";
	$results 		= $conn->query($sql);
	if (mysqli_num_rows($results) > 0){
		$row						= $results->fetch_assoc();
		$user_id					= $row['id'];
		$_SESSION['user_id'] 		= $user_id;
		
		$sql_check_absentee			= "SELECT id FROM absentee_list WHERE user_id = '$user_id' AND date = CURDATE()";
		$result_check_absentee		= $conn->query($sql_check_absentee);
		if(mysqli_num_rows($result_check_absentee) == 0){
			$sql 		= "INSERT INTO absentee_list (user_id,date,time) VALUES ('$user_id',CURDATE(),CURTIME())";
			$conn->query($sql);
		}
		
		header("location:/agungelektrindo");
	} else {
		header("location:/agungelektrindo/landing_page");
	};
?>