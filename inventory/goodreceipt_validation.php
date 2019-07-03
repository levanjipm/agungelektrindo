<?php
	//Getting all the Data submited//
	include('../codes/connect.php');
	$date = $_POST['date'];
	$po_id = $_POST['po'];
	$document = $_POST['document'];
	//Select the corresponding supplier where the purchase order//
	$sql_i = "SELECT supplier_id FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_i = $conn->query($sql_i);
	while($row_i = $result_i->fetch_assoc()){
		$supplier_id = $row_i['supplier_id'];
	}
	//Inserting into code_goodreceipt//
	$sql_gr = "INSERT INTO code_goodreceipt (supplier_id,date,received_date,document,po_id) VALUES ('$supplier_id','$date',CURDATE(),'$document','$po_id')";
	$result_gr = $conn->query($sql_gr);
	$x = $_POST['x'];
	$i = 1;
	for ($i = 1; $i < $x; $i++){
		$id = $_POST['id' . $i];
		$quantity_received = $_POST['qty_receive' . $i];
		if($quantity_received > 0){
			$sql_receive = "SELECT id,quantity,status FROM purchaseorder_received WHERE id = '" . $id . "'";
			$result_receive = $conn->query($sql_receive);
			while($row_receive = $result_receive->fetch_assoc()){
				$status = $row_receive['status'];
				$quantity = $row_receive['quantity'];
			}
			$sql_order = "SELECT quantity FROM purchaseorder WHERE id = '" . $id . "'";
			$result_order = $conn->query($sql_order);
			while($row_order = $result_order->fetch_assoc()){
				$quantity_ordered = $row_order['quantity'];
			}
			$sql_gr2 = "SELECT MAX(id) AS max_id FROM code_goodreceipt";
			$result_gr2 = $conn->query($sql_gr2);
			$row_gr2 = $result_gr2->fetch_assoc();
			$gr_id = $row_gr2['max_id'];
			$sql_final = "INSERT INTO goodreceipt (received_id,quantity,gr_id) VALUES ('$id','$quantity_received','$gr_id')";
			$result_final = $conn->query($sql_final);
			
			if ($status == 0){
				if ($quantity + $quantity_received == $quantity_ordered){
					$final_quantity = $quantity_received + $quantity;
					$sql = "UPDATE purchaseorder_received SET quantity = '" . $final_quantity . "', status = '1' 
					WHERE id = '" . $id . "'";
					$result = $conn->query($sql);
				} else {
					$final_quantity = $quantity_received + $quantity;
					$sql = "UPDATE purchaseorder_received SET quantity = '" . ($quantity_received + $quantity) . "' WHERE id = '" . $id . "'";
					$result = $conn->query($sql);
				}
			} else {
			}				
		}
	}
	header('location:inventory.php');
?>