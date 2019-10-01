<?php
	include('../codes/connect.php');
	session_start();
	$confirmed_by	= $_SESSION['user_id'];
	
	$event_id						= $_POST['event_id'];
	$sql							= "SELECT * FROM code_adjustment_event WHERE id = '$event_id' AND isconfirm = '0'";
	$result							= $conn->query($sql);
	if(mysqli_num_rows($result) 	== 1){
		$validation_stock			= true;
		$row						= $result->fetch_assoc();
		$date						= $row['date'];
		$sql_detail					= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
		$result_detail				= $conn->query($sql_detail);
		while($detail				= $result_detail->fetch_assoc()){
			$reference				= $detail['reference'];
			$quantity				= $dtail['quantity'];
			$sql_stock				= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC";
			$result_stock			= $conn->query($sql_stock);
			$row_stock				= $result_stock->fetch_assoc();
			$stock					= $row_stock['stock'];
			
			if($stock < $quantity){
				$validation_stock	= false;
			}
		};
		
		if($validation_stock){
			$i						= 1;
			$sql_event				= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
			$result_event			= $conn->query($sql_event);
			while($event			= $result_event->fetch_assoc()){
				$reference			= $event['reference'];
			$sql_stock_value_in		= "SELECT * FROM stock_value_in WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		}
	}
?>