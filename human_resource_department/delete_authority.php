<?php
	include('../codes/connect.php');
	$user			= $_POST['user'];
	$department		= $_POST['dept'];
	
	$sql_check		= "SELECT * FROM authorization WHERE user_id = '$user' AND department_id = '$department'";
	$result_check	= $conn->query($sql_check);
	if(mysqli_num_rows($result_check)		!= 0){
		$sql		= "DELETE FROM authorization WHERE user_id = '$user' AND department_id = '$department'";
		$result		= $conn->query($sql);
		
		if($result){
			echo '1';
		} else {
			echo '0';
		}
	}
?>