<?php
	include('../codes/connect.php');
	$sales_order_id		= $_POST['sales_order_id'];
	
	$sql_check			= "SELECT type, guid, document_type FROM code_salesorder WHERE id = '$sales_order_id'";
	$result_check		= $conn->query($sql_check);
	$check				= $result_check->fetch_assoc();
	$type				= $check['type'];
	$guid				= $check['guid'];
	$document_type		= $check['document_type'];
	$file				= $_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/sales_department/sales_order_images/' . $guid . '.' . $document_type;
		
	$validation			= true;
	
	if($type 			== 'GOOD'){
		$sql			= "SELECT sent_quantity FROM sales_order WHERE so_id = '$sales_order_id'";
		$result			= $conn->query($sql);
		while($row		= $result->fetch_assoc()){
			if($row['sent_quantity'] > 0){
				$validation	= false;
			}
		}
		
		if($validation == true){
			$sql	= "DELETE FROM sales_order WHERE so_id = '$sales_order_id'";
			$conn->query($sql);
			
			$sql 	= "DELETE FROM code_salesorder WHERE id = '$sales_order_id'";
			$conn->query($sql);
			
			unlink($file);
		}
		
	} else if($type == 'SRVC'){
		$sql		= "SELECT done FROM service_sales_order WHERE so_id = '$sales_order_id'";
		$result		= $conn->query($sql);
		while($row	= $result->fetch_assoc()){
			if($row['done'] > 0){
				$validation	= false;
			}
		}
		
		if($validation == true){
			$sql	= "DELETE FROM service_sales_order WHERE so_id = '$sales_order_id'";
			$conn->query($sql);
			
			$sql 	= "DELETE FROM code_salesorder WHERE id = '$sales_order_id'";
			$conn->query($sql);
		}
	}
?>