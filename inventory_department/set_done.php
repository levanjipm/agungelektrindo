<?php
	include('../codes/connect.php');
	$project_id = $_POST['project_id'];
	
	$sql_check = "SELECT isdone FROM code_project WHERE major_id = '" . $project_id . "' AND isdone = '0'";
	$result_check = $conn->query($sql_check);
	if(mysqli_num_rows($result_check) > 0){
		echo ('0');
	} else {
		$sql_update = "UPDATE code_project SET isdone = '1', end_date = CURDATE() WHERE id = '" . $project_id . "'";
		$result_update = $conn->query($sql_update);
		echo ('1');
	}
?>