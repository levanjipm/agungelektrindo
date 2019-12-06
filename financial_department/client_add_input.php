<?php
	include('../codes/connect.php');
	session_start()
	$creator			= $_SESSION['user_id'];
	$client_name		= mysqli_real_escape_string($conn,$_POST['client_name']);
	if($client_name		!= ''){
		$sql_check		= "SELECT id FROM bank_account_other WHERE name = '$client_name'";
		$result_check 	= $conn->query($sql_check);
		if(mysqli_num_rows($result_check) == 0){
			$sql_insert		= "INSERT INTO bank_account_other (name, created_by, created_date) VALUES ('$client_name', '$creator', CURDATE())";
			$conn->query($sql);
		}
	}
?>