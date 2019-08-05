<?php
	include('../codes/connect.php');
	session_start();
	$confirm = $_SESSION['user_id'];
	
	$sql_user = "SELECT role FROM users WHERE id = '" . $confirm . "'";
	$result_user = $conn->query($sql_user);
	$user = $result_user->fetch_assoc();
	
	$role = $user['role'];
	
	$id = $_POST['id'];
	$sql_event = "SELECT date,event_name,isconfirm FROM code_adjustment_event WHERE id = '" . $id . "'";
	$result_event = $conn->query($sql_event);
	$event = $result_event->fetch_assoc();
	
	if($event['isconfirm'] == 1 || mysqli_num_rows($result_event) == 0 || $role != 'superadmin'){
		echo 0; //Confirm event failed//
	} else if($event['isconfirm'] == 0){
		$date = $event['date'];
		$document = $event['event_name'];
		
		$sql_get = "SELECT * FROM adjustment_event WHERE code_adjustment_event = '" . $id . "'";
		$result_get = $conn->query($sql_get);
		while($get = $result_get->fetch_assoc()){
			$reference = $get['reference'];
			$quantity = $get['quantity'];
			$transaction = $get['transaction'];
			
			$sql_last_stock = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
			$result_last_stock = $conn->query($sql_last_stock);
			$last_stock = $result_last_stock->fetch_assoc();
			$stock = $last_stock['stock'];
			
			$final_quantity = $stock - $quantity;
			
			$sql = "INSERT INTO stock (date,reference,transaction,quantity,stock,document)
			VALUES ('$date','$reference','$transaction','$quantity','$final_quantity','$document')";
			$result = $conn->query($sql);
			
			$sql = "SELECT * FROM stock_value_in WHERE sisa> 0 AND reference = '" . $reference . "' ORDER BY id ASC";
			$result = $conn->query($sql);
			while($in = $result->fetch_assoc()){
				$in_id = $in['id'];
				$sisa = $in['sisa'];
				$pengurang = min($sisa,$quantity);
				$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
				$result_update = $conn->query($sql_update);
				$sql_out = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
				VALUES ('$date','$in_id	','$pengurang','')";
				$result_out = $conn->query($sql_out);
				$quantity = $quantity - $pengurang;
				if ($quantity == 0){
					break;
				}
			}
		}
		$sql = "UPDATE code_adjustment_event SET isconfirm = '1', confirmed_by = '" . $confirm . "', confirm_time = SYSDATE() WHERE id = '" . $id . "'";
		$result = $conn->query($sql);
		if($result){
			echo 1;
		}
	};
?>