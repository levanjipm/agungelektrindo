<?php
	include('../codes/connect.php');
	$validate		= TRUE;
	$id				= $_POST['id'];
	$sql_check		= "SELECT * FROM sales_return WHERE return_id = '$id'";
	$result_check	= $conn->query($sql_check);
	while($check	= $result_check->fetch_assoc()){
		if($check['received'] > 0){
			$validate		= FALSE;
		}
	}
	
	if($validate == TRUE){
		$sql		= "DELETE FROM sales_return WHERE return_id = '$id'";
		$result		= $conn->query($sql);
		echo $sql;
		if($result){
			$sql	= "DELETE FROM code_sales_return WHERE id = '$id'";
			echo $sql;
			$conn->query($sql);
		}
	}
?>