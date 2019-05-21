<?php
	include('../codes/connect.php');
	if(empty($_POST['id'])){
		header('location:sales.php');
	} else {
		$id = $_POST['id'];
		$sql = "UPDATE code_salesorder SET isconfirm = '1' WHERE id= '" . $id . "'";
		$result = $conn->query($sql);
	}
	if($result){
		header('location:confirmsalesorder_dashboard.php?alert=true');
	} else {
		header('location:confirmsalesorder_dashboard.php?alert=true');
	}
?>