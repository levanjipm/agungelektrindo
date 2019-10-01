<?php
	include('../codes/connect.php');
	session_start();
	$confirmed_by = $_SESSION['user_id'];
	
	$total_price 				= 0;
	$event_id 					= $_POST['id'];
	
	$sql_code					= "SELECT date, event_name, isconfirm FROM code_adjustment_event WHERE id = '" . $event_id . "'";
	$result_code				= $conn->query($sql_code);
	$code						= $result_code->fetch_assoc();
	
	$date						= $code['date'];
	$event_name					= $code['event_name'];
	$isconfirm					= $code['isconfirm'];
	
	$sql_adjustment_event 		= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
	$result_adjustment_event	= $conn->query($sql_adjustment_event);
	
	while($event = $result_adjustment_event->fetch_assoc()){
		$reference		= $event['reference'];
		$quantity		= $event['quantity'];
		$price			= $event['price_input'];
		
		$sql_check		= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_check	= $conn->query($sql_check);
		$check			= $result_check->fetch_assoc();
		if(mysqli_num_rows($result_check) == 0){
			$stock = 0;
		} else {
			$stock			= $check['stock'];
		}
		
		if($stock == 0 || $stock < $quantity || $isconfirm == 1){
?>
<script>
	window.history.back();
</script>
<?php
		}
		$sql_price = "SELECT sisa,price FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id DESC";
		$result_price = $conn->query($sql_price);
		$i = 1;
		while($price = $result_price->fetch_assoc()){
			$unit_price[$i] = $price['price'];
			$minimum_quantity = min($quantity, $price['sisa']);
			$total_price += $minimum_quantity * $price['price'];
			
			$quantity = $quantity - $minimum_quantity;
			$i++;
		}
	}
	
	$sql_adjustment_event 		= "SELECT reference,quantity, price_input FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'IN'";
	$result_adjustment_event	= $conn->query($sql_adjustment_event);
	$price_total_out			= 0;
	
	while($event = $result_adjustment_event->fetch_assoc()){
		$reference			= $event['reference'];
		$quantity			= $event['quantity'];
		$price				= $event['price_input'];
			
		$sql_stock			= "SELECT stock FROM stock WHERE reference = '$reference' ORDER BY id DESC LIMIT 1";
		$result_stock		= $conn->query($sql_stock);
		$stock				= $result_stock->fetch_assoc();
			
		$initial_stock		= $stock['stock'];
		$updated_stock		= $initial_stock + $quantity;
		
		$sql_insert_stock	= "INSERT INTO stock (date,reference,transaction,quantity,stock,document)
							VALUES ('$date','$reference','IN','$quantity','$updated_stock','$event_name')";
		$result_insert_stock = $conn->query($sql_insert_stock);
		$price_total_out	+= $price;
	}
	
	$sql_adjustment_event 		= "SELECT reference,quantity,price_input FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'IN'";
	$result_adjustment_event	= $conn->query($sql_adjustment_event);
	while($event = $result_adjustment_event->fetch_assoc()){
		$reference			= $event['reference'];
		$quantity			= $event['quantity'];
		$price				= $event['price_input'];
		
		$input_price		= $price * $total_price / $price_total_out;
		$sql_stock_value	= "INSERT INTO stock_value_in (date,reference,quantity,price,sisa) VALUES ('$date','$reference','$quantity','$input_price','$quantity')";
		$result_stock_value	= $conn->query($sql_stock_value);
	}
	
	$sql_adjustment_event 		= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
	$result_adjustment_event	= $conn->query($sql_adjustment_event);
	
	while($event = $result_adjustment_event->fetch_assoc()){
		$reference		= $event['reference'];
		$quantity		= $event['quantity'];
		$sql_in 		= "SELECT id,sisa FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id ASC";
		$result_in 		= $conn->query($sql_in);
		while($in = $result_in ->fetch_assoc()){
			$in_id 		= $in['id'];
			$sisa 		= $in['sisa'];
			$pengurang 	= min($sisa,$quantity);
			$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
			$conn->query($sql_update);
			$sql_out 	= "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
						VALUES ('$date','$in_id	','$pengurang','0')";
			$conn->query($sql_out);
			$quantity	= $quantity - $pengurang;
			if ($quantity == 0){
				break;
			}
		}
		
		$sql_stock			= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_stock		= $conn->query($sql_stock);
		$stock				= $result_stock->fetch_assoc();
		$quantity			= $event['quantity'];
		
		$initial_stock		= $stock['stock'];
		$updated_stock		= $initial_stock - $quantity;
		
		$sql_insert_stock	= "INSERT INTO stock (date,reference,transaction,quantity,stock,document)
							VALUES ('$date','$reference','OUT','$quantity','$updated_stock','$event_name')";
		$result_insert_stock = $conn->query($sql_insert_stock);
	}
	$sql = "UPDATE code_adjustment_event SET isconfirm = '1', confirmed_by = '$confirmed_by', confirm_time = CURRENT_TIMESTAMP)";
	$result = $conn->query($sql);
	
	header('location:inventory');
?>