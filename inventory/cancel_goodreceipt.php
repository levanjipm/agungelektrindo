<?php
	//canceling good receipt//
	include('../codes/connect.php');
	$id = $_GET['id'];
	$sql_code = "SELECT received_id,quantity FROM goodreceipt WHERE gr_id = '" . $id . "'";
	$result_code = $conn->query($sql_code);
	while($row_code = $result_code->fetch_assoc()){
		$id_out = $row_code['received_id'];
		$sql_received = "SELECT quantity,status FROM purchaseorder_received WHERE id = '" . $id_out . "'";
		$result_received = $conn->query($sql_received);
		$row_received = $result_received->fetch_assoc();
		
		$quantity_initial = $row_received['quantity'];
		$status = $row_received['status'];
		
		$quantity_canceled = $row_code['quantity'];
		if($status == 1){
			$final_quantity = $quantity_initial - $quantity_canceled;
			$sql_update = "UPDATE purchaseorder_received SET quantity = '" . $final_quantity . "', status = '0' WHERE id = '" . $id_out . "'";
			$result_update = $conn->query($sql_update);
		} else {
			$final_quantity = $quantity_initial - $quantity_canceled;
			$sql_update = "UPDATE purchaseorder_received SET quantity = '" . $final_quantity . "' WHERE id = '" . $id_out . "'";
			$result_update = $conn->query($sql_update);	
		}
	}
	$sql_update1 = "DELETE FROM code_goodreceipt WHERE id = '" . $id . "'";
	$result_update1 = $conn->query($sql_update1);
	$sql_delete = "DELETE FROM goodreceipt WHERE gr_id = '" . $id . "'";
	$result_delete = $conn->query($sql_delete);
	header('location:goodreceipt_confirm_dashboard.php');
?>