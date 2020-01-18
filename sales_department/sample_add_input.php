<?php
	include('../codes/connect.php');
	session_start();
	
	$reference_array	= $_POST['reference'];
	$quantity_array		= $_POST['quantity'];
	
	$customer 			= $_POST['customer'];
	
	$guid				= $_POST['guid'];
	$sql_check			= "SELECT * FROM code_sample WHERE guid = '$guid'";
	$result_check		= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
		$sql 				= "INSERT INTO code_sample (customer_id, date, created_by, guid)
								VALUES ('$customer',CURDATE(),'" . $_SESSION['user_id'] . "', '$guid')";
		$conn->query($sql);
		
		$sql_select 		= "SELECT id FROM code_sample WHERE guid = '$guid'";
		$result_select 		= $conn->query($sql_select);
		$select 			= $result_select->fetch_assoc();
		
		$code_id 			= $select['id'];
		
		foreach($reference_array as $reference){
			$key				= key($reference_array);
			$quantity			= $quantity_array[$key];
			$sql_check_item		= "SELECT id FROM itemlist WHERE reference='" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_check_item	= $conn->query($sql_check_item);
			
			$check				= mysqli_num_rows($result_check_item);
			
			if($check			== 1 && $quantity > 0){
				$sql = "INSERT INTO sample (reference,quantity,code_id)
						VALUES ('$reference','$quantity','$code_id')";
				$conn->query($sql);
			}
			
			next($reference_array);
		}
	}
	
	header('location:/agungelektrindo/sales');
?>