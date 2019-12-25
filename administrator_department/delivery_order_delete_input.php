<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_POST['id'];
	$sql_name				= "SELECT name, customer_id FROM code_delivery_order WHERE id = '$delivery_order_id'";
	$result_name			= $conn->query($sql_name);
	
	$name					= $result_name->fetch_assoc();
	
	$do_name				= $name['name'];
	$customer_id			= $name['customer_id'];
	
	$sql					= "SELECT * FROM stock_value_out WHERE customer_id = '$customer_id' AND document = '$do_name'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$out_id				= $row['id'];
		$in_id				= $row['in_id'];
		$quantity			= $row['quantity'];
		
		$sql_in				= "SELECT id, sisa FROM stock_value_in WHERE id = '$in_id'";
		$result_in			= $conn->query($sql_in);
		$in					= $result_in->fetch_assoc();
		
		$sisa_i				= $in['sisa'];
		
		$sisa_f				= $sisa_i + $quantity;
		
		$sql_update			= "UPDATE stock_value_in SET sisa = '$sisa_f' WHERE id = '$in_id'";
		$result_update		= $conn->query($sql_update);
		if($result_update){
			$sql_delete			= "DELETE FROM stock_value_out WHERE id = '$out_id'";
			$conn->query($sql_delete);
		}
	}
	
	$sql_delivery_order		= "SELECT * FROM delivery_order WHERE do_id = '$delivery_order_id'";
	$result_delivery_order	= $conn->query($sql_delivery_order);
	while($delivery_order	= $result_delivery_order->fetch_assoc()){
		$reference			= $delivery_order['reference'];
		$quantity			= $delivery_order['quantity'];
		
		$sql_delete			= "DELETE FROM stock WHERE document = '$do_name' AND reference = '$reference' AND customer_id = '$customer_id'";
		$result_delete		= $conn->query($sql_delete);
		
		if($result_delete){
			$stock_i		= 0;
			$sql_stock		= "SELECT * FROM stock WHERE reference = '$reference' ORDER BY id ASC";
			$result_stock	= $conn->query($sql_stock);
			while($stock	= $result_stock->fetch_assoc()){
				$id			= $stock['id'];
				$quantity	= $stock['quantity'];
				$transaction	= $stock['transaction'];
				
				if($transaction == 'IN'){
					$stock_i	+= $quantity;
					$sql_update		= "UPDATE stock SET stock = '$stock_i' WHERE id = '$id'";
				} else {
					$stock_i	-= $quantity;
					$sql_update		= "UPDATE stock SET stock = '$stock_i' WHERE id = '$id'";
				}
				
				$conn->query($sql_update);	
			}
		};
	}
	
	$sql_delete_do			= "DELETE FROM code_delivery_order WHERE do_id = '$delivery_order_id'";
	$conn->query($sql_delete_do);
	
	$sql_delete_do			= "DELETE FROM code_delivery_order WHERE id = '$delivery_order_id'";
	$conn->query($sql_delete_do);
	
	header('location:/agungelektrindo/administrator');
?>