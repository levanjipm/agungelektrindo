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
		$event_name					= $row['event_name'];
		$date						= $row['date'];
		$sql_detail					= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
		$result_detail				= $conn->query($sql_detail);
		while($detail				= $result_detail->fetch_assoc()){
			$reference				= $detail['reference'];
			$quantity				= $detail['quantity'];
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
			$price_array			= [];
			$unit_price_array		= [];
			$sql_event				= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
			$result_event			= $conn->query($sql_event);
			while($event			= $result_event->fetch_assoc()){
				$id					= $event['id'];
				$reference			= $event['reference'];
				$quantity			= $event['quantity'];
				$sql_stock_value_in	= "SELECT * FROM stock_value_in WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND sisa > 0";
				$result_stock_value_in	= $conn->query($sql_stock_value_in);
				$price_array[$i]				= 0;
				while($stock_value_in		= $result_stock_value_in->fetch_assoc()){
					$in_id 					= $stock_value_in['id'];
					$sisa					= $stock_value_in['sisa'];
					$pengurang				= min($sisa, $quantity);
					
					$sql_update 			= "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
					$conn->query($sql_update);
					
					$sql_insert_out			= "INSERT INTO stock_value_out (date,in_id,quantity,customer_id) VALUES (CURDATE(),'$in_id','$pengurang','0')";
					$conn->query($sql_insert_out);
					
					$price_array[$i] 		= $price_array[$i]  + $stock_value_in['price'] * $pengurang;
					$quantity 				= $quantity - $pengurang;
					
					if ($quantity == 0){
						break;
					}
				};
				
				$quantity					= $event['quantity'];
				$unit_price_array[$i]		= $price_array[$i] / $quantity;
				
				$sql_update			= "UPDATE adjustment_event SET price_input = '" . $unit_price_array[$i] . "' WHERE id = '$id'";
				$conn->query($sql_update);
				
				$sql_stock			= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC";
				$result_stock		= $conn->query($sql_stock);
				$row_stock			= $result_stock->fetch_assoc();
				
				$initial_stock		= $row_stock['stock'];
				$end_stock			= $initial_stock - $quantity;
				
				$sql_stock_insert	= "INSERT INTO stock (date, reference, transaction ,quantity, stock, supplier_id, customer_id, document)
									VALUES ('$date', '" . mysqli_real_escape_string($conn,$reference) . "', 'IN', '$quantity', '$end_stock', '', '', '$event_name')";
				$conn->query($sql_stock_insert);
				
				$i++;
			}
			$sum_unit_price				= array_sum($unit_price_array);
			
			$sql_sum_price_initial		= "SELECT SUM(price_input) AS price_input FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'IN'";
			echo $sql_sum_price_initial;
			$result_sum_price_initial	= $conn->query($sql_sum_price_initial); 
			$sum_price_initial			= $result_sum_price_initial->fetch_assoc();
			
			$total_price_input			= $sum_price_initial['price_input'];
			
			$sql_event_out			= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'IN'";
			$result_event_out		= $conn->query($sql_event_out);
			while($event_out		= $result_event_out->fetch_assoc()){
				$id					= $event_out['id'];
				$reference			= $event_out['reference'];
				$quantity			= $event_out['quantity'];
				$initial_price		= $event_out['price_input'];
				
				$price				= $initial_price * $sum_unit_price / $total_price_input;
				
				$sql_insert_in		= "INSERT INTO stock_value_in (date, reference, quantity, price, sisa, supplier_id, customer_id, gr_id)
									VALUES ('$date', '" . mysqli_real_escape_string($conn,$reference) . "', '$quantity', '$price', '$quantity', '0', '0', '0')";
				$conn->query($sql_insert_in);
				
				$sql_stock			= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC";
				$result_stock		= $conn->query($sql_stock);
				$row_stock			= $result_stock->fetch_assoc();
				
				$initial_stock		= $row_stock['stock'];
				$end_stock			= $initial_stock + $quantity;
				
				$sql_stock_insert	= "INSERT INTO stock (date, reference, transaction ,quantity, stock, supplier_id, customer_id, document)
									VALUES ('$date', '" . mysqli_real_escape_string($conn,$reference) . "', 'IN', '$quantity', '$end_stock', '', '', '$event_name')";
				$conn->query($sql_stock_insert);
				
				$sql_update_event	= "UPDATE adjustment_event SET price_input = '$price' WHERE id = '$id'";
				$conn->query($sql_update_event);
			};
			
			$sql_done			= "UPDATE code_adjustment_event SET isconfirm = '1', confirmed_by = '$confirmed_by', confirm_time = NOW() WHERE id = '$event_id'";
			$conn->query($sql_done);
		}
	}
?>