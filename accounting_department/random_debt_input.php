<?php
	include('../codes/connect.php');
	session_start();
	$created_by				= $_SESSION['user_id'];
	$guid					= $_POST['guid'];
	$date					= $_POST['date'];
	$supplier_id			= $_POST['supplier'];
	$tax					= $_POST['tax'];
	$value					= $_POST['value'];
	$document_name			= mysqli_real_escape_string($conn,$_POST['document_name']);
	$description			= mysqli_real_escape_string($conn,$_POST['description']);
	
	$sql_check				= "SELECT id FROM purchases WHERE guid = '$guid'";
	$result_check			= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
		$sql		= "INSERT INTO purchases (date,supplier_id,faktur,name,keterangan,value,created_by,guid)
					VALUES ('$date','$supplier_id','','$document_name','$description','$value','$created_by','$guid')";
		$conn->query($sql);
	}
?>