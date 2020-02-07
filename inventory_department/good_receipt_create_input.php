<?php
	include('../codes/connect.php');
	session_start();
	
	$created_by				= $_SESSION['user_id'];
	
	$purchase_order_id		= $_POST['purchase_order_id'];
	$date					= $_POST['date'];
	$document				= mysqli_real_escape_string($conn,$_POST['document']);
	
	$receive_array			= $_POST['qty_receive'];
	$array_sum				= array_sum($receive_array);
	
	$sql_check				= "SELECT id FROM code_goodreceipt WHERE document = '$document' AND YEAR(date) = YEAR($date)";
	$result_check			= $conn->query($sql_check);
	$check					= mysqli_num_rows($result_check);
		
	if($check == 0 && $array_sum > 0){
		$sql_supplier 		= "SELECT supplier_id FROM code_purchaseorder WHERE id = '$purchase_order_id'";
		$result_supplier 	= $conn->query($sql_supplier);
		$supplier 			= $result_supplier->fetch_assoc();
		$supplier_id		= $supplier['supplier_id'];
		
		$sql_gr 			= "INSERT INTO code_goodreceipt (supplier_id,date,received_date,document,po_id,created_by)
								VALUES ('$supplier_id','$date',CURDATE(),'$document','$purchase_order_id','$created_by')";
		$result_gr 			= $conn->query($sql_gr);
		if($result_gr){
			foreach($receive_array as $receive){
				$po_id							= key($receive_array);
				if($receive > 0){
					$sql_receive 				= "SELECT id,quantity,status, received_quantity FROM purchaseorder WHERE id = '" . $po_id . "'";
					$result_receive 			= $conn->query($sql_receive);
					$row_receive 				= $result_receive->fetch_assoc();
					
					$status 					= $row_receive['status'];
					$quantity 					= $row_receive['quantity'];
					$received_quantity 			= $row_receive['received_quantity'];
					
					$sql_code_good_receipt 		= "SELECT id FROM code_goodreceipt ORDER BY id DESC LIMIT 1";
					$result_code_good_receipt	= $conn->query($sql_code_good_receipt);
					$row_code_good_receipt		= $result_code_good_receipt->fetch_assoc();
					$code_good_receipt 			= $row_code_good_receipt['id'];
					
					$sql_final = "INSERT INTO goodreceipt (received_id,quantity,gr_id) VALUES ('$po_id','$receive','$code_good_receipt')";
					$conn->query($sql_final);

					if ($status == 0){
						if ($receive + $received_quantity == $quantity){
							$final_quantity = $received_quantity + $receive;
							$sql = "UPDATE purchaseorder SET received_quantity = '" . $final_quantity . "', status = '1' 
							WHERE id = '" . $po_id . "'";
							$conn->query($sql);
						} else {
							$final_quantity = $received_quantity + $receive;
							$sql = "UPDATE purchaseorder SET received_quantity = '" . $final_quantity . "' WHERE id = '" . $po_id . "'";
							$conn->query($sql);
						}
					}			
				}
				
				next($receive_array);
			}
		}
	}
	
	header('location:/agungelektrindo/inventory');
?>