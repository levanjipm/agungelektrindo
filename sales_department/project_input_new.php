<?php
	include('../codes/connect.php');
	session_start();
	
	$created_by		= $_SESSION['user_id'];
	$customer_id	= $_POST['customer_id'];
	$purchase_order	= mysqli_real_escape_string($conn,$_POST['purchase_order']);
	$start_project	= $_POST['start_project'];
	$name_project	= mysqli_real_escape_string($conn,$_POST['name_project']);
	$taxing			= $_POST['taxing'];
	
	$sql			= "INSERT INTO code_project (customer_id,project_name,major_id,taxing, po_number, start_date)
					VALUES ('$customer_id','$name_project','0','$taxing','$purchase_order','$start_project')";
	$conn->query($sql);
	
	header('location:../sales');
?>