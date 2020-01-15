<?php
	include('../codes/connect.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		header('location:inventory.php');
	}
	$date 	= $_POST['date'];
	switch (date('m',strtotime($date))) {
		case "01" :
			$month = 'I';
			break;
		case "02" :
			$month = 'II';
			break;
		case "03" :
			$month = 'III';
			break;
		case "04" :
			$month = 'IV';
			break;
		case "05" :
			$month = 'V';
			break;
		case "06" :
			$month = 'VI';
			break;
		case "07" :
			$month = 'VII';
			break;
		case "08" :
			$month = 'VIII';
			break;
		case "09" :
			$month = 'IX';
			break;
		case "10" :
			$month = 'X';
			break;
		case "11" :
			$month = 'XI';
			break;
		case "12" :
			$month = 'XII';
			break;	
	}
	$sql_count_name 		= "SELECT COUNT(*) AS jumlah FROM project_delivery_order WHERE MONTH(date) = MONTH('$date') AND YEAR(date) = YEAR('$date')";
	$result_count_name 		= $conn->query($sql_count_name);
	$count_name 			= $result_count_name->fetch_assoc();
		
	$number 				= $count_name['jumlah'];
	$number++;	
		
	$do_name 				= "PRO-AE-" . str_pad($number,2,"0",STR_PAD_LEFT) . "." . date('d',strtotime($date)) . "." . $month . "-" . date('y',strtotime($date));
	$user_id 				= $_SESSION['user_id'];
	$project_id 			= $_POST['projects'];
	$sql_project 			= "INSERT INTO project_delivery_order (date,name,project_id,created_by) VALUES ('$date','$do_name','$project_id','$user_id')";
	$result_project 		= $conn->query($sql_project);
		
	$sql_select 			= "SELECT id FROM project_delivery_order ORDER BY id DESC LIMIT 1";
	$result_select 			= $conn->query($sql_select);
	$select 				= $result_select->fetch_assoc();
		
	$do_id 					= $select['id'];
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	
	foreach($reference_array as $reference){
		$key				= key($reference_array);
		$quantity			= $quantity_array[$key];
			
		$sql 				= "INSERT INTO project (reference,quantity,project_do_id) VALUES ('$reference','$quantity','$do_id')";
		$result 			= $conn->query($sql);
		
		next($reference_array);
	}
	
	header('location:/agungelektrindo/inventory');
?>