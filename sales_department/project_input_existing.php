<?php
	include('../codes/connect.php');
	print_r($_POST);
	if(empty($_POST['project_major_id']) || empty($_POST['taxing']) || empty($_POST['start_project'])){
	} else {
		$project_major_id		= $_POST['project_major_id'];
		$taxing		 			= $_POST['taxing'];
		$start_project 			= $_POST['start_project'];
		$name_project 			= $_POST['name_project'];
		$description_project 	= mysqli_real_escape_string($conn,$_POST['description_project']);
		
		$sql_initial 				= "SELECT customer_id FROM code_project WHERE id = '$project_major_id'";
		$result_initial 			= $conn->query($sql_initial);
		$initial 					= $result_initial->fetch_assoc();
		$customer_id 				= $initial['customer_id'];
		
		$sql 						= "INSERT INTO code_project (customer_id,project_name,start_date,major_id,description)
									VALUES ('$customer_id','$name_project','$start_project','$project_major_id','$description_project')";
		$result = $conn->query($sql);
	}
	
	header('location:../sales');
?>