<?php
	include('../codes/connect.php');
	$good_receipt_id		= $_POST['id'];
	$sql_name				= "SELECT code_goodreceipt.date, code_goodreceipt.id, code_goodreceipt.document, code_purchaseorder.supplier_id FROM code_goodreceipt 
								JOIN code_purchaseorder ON code_purchaseorder.id = code_goodreceipt.po_id
								WHERE code_goodreceipt.id = '$good_receipt_id'";
	$result_name			= $conn->query($sql_name);
	
	$name					= $result_name->fetch_assoc();
	
	$gr_name				= $name['document'];
	$supplier_id			= $name['supplier_id'];
	$gr_date				= $name['date'];
	
	$detail_array			= array();
	$sql_detail				= "SELECT id FROM goodreceipt WHERE gr_id = '$good_receipt_id'";
	$result_detail			= $conn->query($sql_detail);
	while($detail			= $result_detail->fetch_assoc()){
		array_push($detail_array, $detail['id']);
	};
	
	$array						= implode("','",$detail_array);
	
	$validation					= TRUE;
	$sql_status					= "SELECT quantity, sisa FROM stock_value_in WHERE supplier_id = '$supplier_id' AND gr_id IN ('" . $array . "')";
	$result_status				= $conn->query($sql_status);
	while($row					= $result_status->fetch_assoc()){
		$sisa				= $row['sisa'];
		$quantity			= $row['quantity'];
		
		if($sisa			!= $quantity){
			$validation		== FALSE;
			break;
		}
	}
	
	if($validation				== TRUE){
		$sql_delete_value		= "DELETE FROM stock_value_in WHERE supplier_id = '$supplier_id' AND gr_id IN ('" . $array . "') AND date = '$gr_date'";
		$result_delete_value	= $conn->query($sql_delete_value);
		
		$sql					= "SELECT purchaseorder.quantity, purchaseorder.received_quantity, purchaseorder.id, purchaseorder.reference, 
									code_goodreceipt.date, code_goodreceipt.document, code_purchaseorder.supplier_id, goodreceipt.quantity as received
									FROM code_goodreceipt 
									JOIN code_purchaseorder ON code_purchaseorder.id = code_goodreceipt.po_id
									JOIN goodreceipt ON code_goodreceipt.id = goodreceipt.gr_id
									JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
									WHERE code_goodreceipt.id = '$good_receipt_id'";
									echo $sql;
		$result					= $conn->query($sql);
		while($row				= $result->fetch_assoc()){
			$purchase_order_id	= $row['id'];
			$quantity_ordered	= $row['quantity'];
			$quantity_i			= $row['received_quantity'];
			$quantity_received	= $row['received'];
			
			$quantity_f			= $quantity_i - $quantity_received;
			
			$reference			= $row['reference'];
			$supplier_id		= $row['supplier_id'];
			$sql_delete			= "DELETE FROM stock WHERE document = '$gr_name' AND reference = '$reference' AND supplier_id = '$supplier_id' AND date = '$gr_date'";
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
			
			$sql_update			= "UPDATE purchaseorder SET status = '0', received_quantity = '$quantity_f' WHERE id = '$purchase_order_id'";
			$conn->query($sql_update);
		}
	}
	
	$sql_delete_do			= "DELETE FROM goodreceipt WHERE gr_id = '$good_receipt_id'";
	$conn->query($sql_delete_do);
	
	$sql_delete_do			= "DELETE FROM code_goodreceipt WHERE id = '$good_receipt_id'";
	$conn->query($sql_delete_do);
	
	header('location:/agungelektrindo/administrator');
?>