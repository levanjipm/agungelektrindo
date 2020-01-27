<?php
	include('../codes/connect.php');
	session_start();
	
	$confirmer		= $_SESSION['user_id'];
	
	$event_id		= $_POST['event_id'];
	$sql_code		= "SELECT event_name, date FROM code_adjustment_event WHERE id = '$event_id'";
	$result_code	= $conn->query($sql_code);
	$code			= $result_code->fetch_assoc();
	
	$document		= $code['event_name'];
	$date			= $code['date'];
	
	$validation		= TRUE;
	$sql			= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
	$result			= $conn->query($sql);
	
	while($row		= $result->fetch_assoc()){
		$reference	= $row['reference'];
		$quantity	= $row['quantity'];
		
		$sql_stock	= "SELECT stock FROM stock WHERE reference = '$reference' ORDER BY id DESC";
		$result_stock	= $conn->query($sql_stock);
		
		$row_stock	= $result_stock->fetch_assoc();
		
		$stock		= $row_stock['stock'];
		
		if($stock < $quantity){
			$validation = FALSE;
		};
	};
	
	if($validation){
		$sql					= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
		$result					= $conn->query($sql);
		$total_price			= 0;
		while($row				= $result->fetch_assoc()){
			$id					= $row['id'];
			$reference			= $row['reference'];
			$quantity			= $row['quantity'];
			$quantitys			= $row['quantity'];
			$item_price			= 0;
			$sql_in 			= "SELECT * FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id ASC";
			$result_in 			= $conn->query($sql_in);
			while($in 			= $result_in ->fetch_assoc()){
				
				$in_id 			= $in['id'];
				$sisa 			= $in['sisa'];
				$price			= $in['price'];
				$pengurang 		= min($sisa,$quantity);
				$total_price	+= $price * $pengurang;
				$item_price		+= $price * $pengurang;
				$sql_update 	= "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
				$result_update 	= $conn->query($sql_update);
				$sql_out 		= "INSERT INTO stock_value_out (date,in_id,quantity, document)
									VALUES ('$date','$in_id	','$pengurang', '$document')";
				$conn->query($sql_out);
				
				$quantity 		= $quantity - $pengurang;
				if ($quantity 	== 0){
					break;
				}
				$item_unit_price	= $item_price / $quantity;
				$sql_update			= "UPDATE adjustment_event SET price_input = '$item_unit_price' WHERE id = '$id'";
				$conn->query($sql_update);
			}
			
			$sql_stock 		= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
			$result_stock 	= $conn->query($sql_stock);
			$row_stock 		= $result_stock->fetch_assoc();
			
			$initial_stock 	= $row_stock['stock'];
			$end_stock 		= $initial_stock - $quantitys;

			$sql_stock_out 	= "INSERT INTO stock (date,reference,transaction,quantity,stock,document)
							VALUES ('$date','$reference','OUT','$quantitys','$end_stock','$document')";
			$conn->query($sql_stock_out);
		}
		
		$sql			= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'IN'";
		$result			= $conn->query($sql);
		$row			= $result->fetch_assoc();
		
		$id				= $row['id'];
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$price_input	= $total_price / $quantity;
		
		$sql_stock 		= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_stock 	= $conn->query($sql_stock);
		$row_stock 		= $result_stock->fetch_assoc();
		
		$initial_stock 	= $row_stock['stock'];
		$end_stock 		= $initial_stock + $quantity;
		
		$sql_stock	 	= "INSERT INTO stock (date,reference,transaction,quantity,stock,document)
							VALUES ('$date','$reference','IN','$quantity','$end_stock','$document')";
		$conn->query($sql_stock);
		
		$sql_stock_value	= "INSERT INTO stock_value_in (date,reference,quantity,price, sisa, document)
								VALUES ('$date','$reference','$quantity','$price_input', '$quantity', '$document')";
		$conn->query($sql_stock_out);
		
		$sql_update			= "UPDATE adjustment_event SET price = '$price_input' WHERE id = '$id'";
		$conn->query($sql_update);
		
		$sql_update			= "UPDATE code_adjustment_event SET isconfirm = '1', confirmed_by = '$confirmer', confirm_time = CURTIME() WHERE id = '$event_id'";
		$conn->query($sql_update);
	};
?>