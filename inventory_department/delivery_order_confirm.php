<?php
	include("../codes/connect.php");
	session_start();
	$id_do 							= $_POST['do_id'];
	
	$sql_get_type 					= "SELECT code_salesorder.type
									FROM code_salesorder
									JOIN code_delivery_order
									ON code_delivery_order.so_id = code_salesorder.id
									WHERE code_delivery_order.id = '" . $id_do . "'";
	$result_get_type 				= $conn->query($sql_get_type);
	$get_type						= $result_get_type->fetch_assoc();
	$type 							= $get_type['type'];
	
	if($type == 'GOOD'){
		$sql_code					= "SELECT id FROM code_delivery_order WHERE id = '$id_do' AND sent = '0'";
		$result_code				= $conn->query($sql_code);
		if($result_code){
			$sql_delivery_order 		= "SELECT customer_id,name,date FROM code_delivery_order WHERE id ='" . $id_do . "'";
			$result_delivery_order		= $conn->query($sql_delivery_order);
			$delivery_order 			= $result_delivery_order->fetch_assoc();
			$customer_id 				= $delivery_order['customer_id'];
			$document 					= $delivery_order['name'];
			$date 						= $delivery_order['date'];
			
			$x = 1;
			$sql_select 				= "SELECT * FROM delivery_order WHERE do_id = '" . $id_do . "'";
			$result_select 				= $conn->query($sql_select);
			while($row = $result_select->fetch_assoc()){
				$reference 				= $row['reference'];
				$quantity 				= $row['quantity'];
				$sql_check_stock 		= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
				$result_check_stock 	= $conn->query($sql_check_stock);
				$row_stock 				= $result_check_stock->fetch_assoc();
				$stock 					= $row_stock['stock'];
				if ($stock == NULL || $stock == 0){
					$x = 2;
				} else if($stock < $quantity){
					$x = 2;
				}
			}
			if($x > 1){
				echo ('Error on inputing data, Cannot proceed');
				header("Refresh:3; url=confirm_do_dashboard.php");
			} else {
				$sql_second 			= "SELECT * FROM delivery_order WHERE do_id = '" . $id_do . "'";
				$result_second 			= $conn->query($sql_second);
				while($row_second 		= $result_second->fetch_assoc()){
					$references 		= $row_second['reference'];
					$quantitys 			= $row_second['quantity'];
					$quantity 			= $row_second['quantity'];
					$sql_in 			= "SELECT * FROM stock_value_in WHERE reference = '" . $references . "' AND sisa > 0 ORDER BY id ASC";
					$result_in 			= $conn->query($sql_in);
					while($in 			= $result_in ->fetch_assoc()){
						$in_id 			= $in['id'];
						$sisa 			= $in['sisa'];
						$pengurang 		= min($sisa,$quantity);
						$sql_update 	= "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
						$result_update 	= $conn->query($sql_update);
						$sql_out 		= "INSERT INTO stock_value_out (date,in_id,quantity,customer_id, document)
										VALUES ('$date','$in_id	','$pengurang','$customer_id', '$document')";
						$conn->query($sql_out);
						
						$quantity 		= $quantity - $pengurang;
						if ($quantity 	== 0){
							break;
						}
					}
					
					$sql_stock 		= "SELECT stock FROM stock WHERE reference = '" . $references . "' ORDER BY id DESC LIMIT 1";
					$result_stock 	= $conn->query($sql_stock);
					$row_stock 		= $result_stock->fetch_assoc();
					
					$initial_stock 	= $row_stock['stock'];
					$end_stock 		= $initial_stock - $quantitys;

					$sql_stock_out 	= "INSERT INTO stock (date,reference,transaction,quantity,stock,supplier_id,customer_id,document)
									VALUES ('$date','$references','OUT','$quantitys','$end_stock','0','$customer_id','$document')";
					$conn->query($sql_stock_out);
				}
				
				$sql_updated = "UPDATE code_delivery_order SET sent = '1', confirmed_by = '" . $_SESSION['user_id'] . "', confirm_date = CURDATE() WHERE id = '" . $id_do . "'";
				$conn->query($sql_updated);
			}
		}
	}
?>