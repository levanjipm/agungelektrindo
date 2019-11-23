<?php
	include('../codes/connect.php');
	if(empty($_POST['project_major']) || empty($_POST['date_exist_date']) || empty($_POST['name_exist_date'])){
		header('location:add_project_dashboard.php');
	} else {
		$major_id 				= $_POST['project_major'];
		$start_project 			= $_POST['date_exist_date'];
		$name_project 			= $_POST['name_exist_date'];
		$project_description 	= mysqli_real_escape_string($conn,$_POST['description']);
	}
	$sql_initial = "SELECT customer_id FROM code_project WHERE id = '".  $major_id . "'";
	$result_initial = $conn->query($sql_initial);
	$initial = $result_initial->fetch_assoc();
	$customer_id = $initial['customer_id'];
	
	$sql = "INSERT INTO code_project (customer_id,project_name,start_date,major_id,description)
	VALUES ('$customer_id','$name_project','$start_project','$major_id','$project_description')";
	$result = $conn->query($sql);
	if($result){
		header('location:add_project_dashboard.php?alert=1');
	} else {
		header('location:add_project_dashboard.php?alert=0');
	}
?>