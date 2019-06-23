<?php
	include('../codes/connect.php');
	if(empty($_POST['customer']) || empty($_POST['start_project']) || empty($_POST['name_project'])){
		header('location:add_project_dashboard.php');
	} else {
		$customer = $_POST['customer'];
		$start_project = $_POST['start_project'];
		$name_project = $_POST['name_project'];
	}
	$sql = "INSERT INTO code_project (customer_id,project_name,start_date)
	VALUES ('$customer','$name_project','$start_project')";
	$result = $conn->query($sql);
	if($result){
		header('location:add_project_dashboard.php?alert=1');
	} else {
		header('location:add_project_dashboard.php?alert=0');
	}
?>
