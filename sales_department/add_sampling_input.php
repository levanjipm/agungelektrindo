<?php
	include('../codes/connect.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		header('location:sales.php');
	}
	
	$reference_array	= $_POST['reference'];
	$quantity_array		= $_POST['quantity'];
	
	$customer 			= $_POST['customer'];
	$date 				= date('Y-m-d');
	
	$sql = "INSERT INTO code_sample (customer_id,date,created_by)
	VALUES ('$customer','$date','" . $_SESSION['user_id'] . "')";
	$conn->query($sql);
	
	$sql_select = "SELECT id FROM code_sample ORDER BY id DESC LIMIT 1";
	$result_select = $conn->query($sql_select);
	$select = $result_select->fetch_assoc();
	
	$code_id = $select['id'];
	
	foreach($reference_array as $reference){
		$key		= key($reference_array);
		$quantity	= $quantity_array[$key];
		$sql_check_item	= "SELECT COUNT(id) AS count_id FROM itemlist WHERE reference='" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_check_item	= $conn->query($sql_check_item);
		$check_item		= $result_check_item->fetch_assoc();
		
		if($reference != '' && $check_item['count_id'] > 0 || $quantity != 0 || $quantity != ''){
			$sql = "INSERT INTO sample (reference,quantity,code_id)
			VALUES ('$reference','$quantity','$code_id')";
			$result = $conn->query($sql);
		}
		
		next($reference_array);
	}
	header('location:sales.php');
?>