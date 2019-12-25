<?php
	include('../codes/connect.php');
	session_start();
	$created_by 			= $_SESSION['user_id'];
	
	$date 					= $_POST['date'];
	$reference_to_be_dem 	= mysqli_real_escape_string($conn,$_POST['reference_dem']);
	$quantity_to_be_dem 	= $_POST['quantity_dem'];
	$reference_array 		= $_POST['reference'];
	$quantity_array 		= $_POST['quantity'];
	
	$sql 			= "SELECT COUNT(*) AS event_before FROM code_adjustment_event WHERE event_id = '4'";
	$result 		= $conn->query($sql);
	$row 			= $result->fetch_assoc();
	$event_before 	= $row['event_before'];
	$event_before++;
	
	$event_name = "MAT" . $event_before;
	
	$sql = "INSERT INTO code_adjustment_event (date, event_id, event_name, created_by) VALUES ('$date','4','$event_name','$created_by')";
	$result = $conn->query($sql);
	
	if($result){
		$sql_get_last_id = "SELECT id FROM code_adjustment_event ORDER BY id DESC LIMIT 1";
		$result_get_last_id = $conn->query($sql_get_last_id);
		$get_last_id = $result_get_last_id->fetch_assoc();
		
		$last_id = $get_last_id['id'];
		
		$sql = "INSERT INTO adjustment_event (reference,quantity,transaction,code_adjustment_event) 
			VALUES ('$reference_to_be_dem','$quantity_to_be_dem','IN','$last_id')";
		$result = $conn->query($sql);
		foreach($reference_array as $reference_before_escape){
			$reference = mysqli_real_escape_string($conn,$reference_before_escape);
			$key = key($reference_array);
			$quantity = $quantity_array[$key] * $quantity_to_be_dem;
			$sql = "INSERT INTO adjustment_event (reference,quantity,transaction,code_adjustment_event) 
			VALUES ('$reference','$quantity','OUT','$last_id')";
			$conn->query($sql);
			next($reference_array);
		}
	}
	
	header('location:/agungelektrindo/inventory');
?>