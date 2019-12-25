<?php
	include('../codes/connect.php');
	$id								= $_POST['id'];
	$sql_code						= "SELECT * FROM code_purchase_return_sent WHERE id = '$id'";
	$result_code					= $conn->query($sql_code);
	$code							= $result_code->fetch_assoc();
	
	$return_document				= $code['document'];
	$purchase_return_id				= $code['code_purchase_return_id'];
	$date							= $code['date'];
	
	$sql_purchase_return			= "SELECT supplier_id FROM code_purchase_return WHERE id= '$purchase_return_id'";
	$result_purchase_return			= $conn->query($sql_purchase_return);
	$purchase_return				= $result_purchase_return->fetch_assoc();
	
	$supplier_id					= $purchase_return['supplier_id'];
	
	$x = 1;
	$sql_select 				= "SELECT purchase_return_sent.quantity, purchase_return.reference
									FROM purchase_return_sent
									JOIN purchase_return ON purchase_return_sent.purchase_return_id = purchase_return.id
									WHERE purchase_return_sent.sent_id = '$id'";
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
	
	if($x		== 1){
		$sql_select 				= "SELECT purchase_return_sent.quantity, purchase_return.reference
										FROM purchase_return_sent
										JOIN purchase_return ON purchase_return_sent.purchase_return_id = purchase_return.id
										WHERE purchase_return_sent.sent_id = '$id'";
		$result_select 				= $conn->query($sql_select);
		while($row_second		= $result_select->fetch_assoc()){
			$references 		= $row_second['reference'];
			$quantity_initial	= $row_second['quantity'];
			$quantity 			= $row_second['quantity'];
			$sql_in 			= "SELECT * FROM stock_value_in WHERE reference = '" . $references . "' AND sisa > 0 ORDER BY id ASC";
			$result_in 			= $conn->query($sql_in);
			while($in 			= $result_in ->fetch_assoc()){
				$in_id 			= $in['id'];
				$sisa 			= $in['sisa'];
				$pengurang 		= min($sisa,$quantity);
				$sql_update 	= "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
				$result_update 	= $conn->query($sql_update);
				$sql_out 		= "INSERT INTO stock_value_out (date,in_id,quantity, document)
									VALUES ('$date','$in_id	','$pengurang','$return_document')";
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
			$end_stock 		= $initial_stock - $quantity_initial;

			$sql_stock_out 	= "INSERT INTO stock (date,reference,transaction,quantity,stock,supplier_id,document)
							VALUES ('$date','$references','OUT','$quantity_initial','$end_stock','$supplier_id','$return_document')";
			$conn->query($sql_stock_out);
		}
		
		$sql_update_code	= "UPDATE code_purchase_return_sent SET isconfirm = '1' WHERE id = '$id'";
		$conn->query($sql_update_code);
	}
?>