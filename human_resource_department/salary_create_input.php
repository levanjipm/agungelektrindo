<?php
	include('../codes/connect.php');
	print_r($_POST);
	if(empty($_POST['user']) || empty($_POST['month']) || empty($_POST['year'])){
	} else {
		$user			= $_POST['user'];
		$month			= $_POST['month'];
		$year			= $_POST['year'];
		
		$daily			= $_POST['daily'];
		$bonus			= $_POST['bonus'];
		$deduction		= $_POST['deduction'];
		$basic			= $_POST['basic'];
		
		$sql_absent		= "SELECT id FROM absentee_list WHERE user_id = '$user' AND MONTH(date) = '$month' AND YEAR(date) = '$year' AND isdelete = '0'";
		$result_absent	= $conn->query($sql_absent);
		$absent			= mysqli_num_rows($result_absent);
		
		$sql_check		= "SELECT * FROM salary WHERE user_id = '$user' AND month = '$month' AND year = '$year'";
		$result_check	= $conn->query($sql_check);
		$check			= mysqli_num_rows($result_check);
		
		if($check		== 0){
			$sql_insert	= "INSERT INTO salary (user_id, working, daily, basic, bonus, deduction, month, year)
							VALUES ('$user', '$absent', '$daily', '$basic', '$bonus', '$deduction', '$month', '$year')";
			$conn->query($sql_insert);
		}
	}
	
	header('location:/agungelektrindo/human_resource');
?>