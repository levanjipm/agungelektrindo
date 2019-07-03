<?php
	include('../codes/connect.php');
	$id_do = $_POST['id'];
	$sql_code = "SELECT so_id,isdelete FROM code_delivery_order WHERE id ='" . $id_do . "'";
	$result_code = $conn->query($sql_code);
	$code = $result_code->fetch_assoc();
	$so_id = $code['so_id'];
	$isdelete = $code['isdelete'];
	if($isdelete != 1){
		$sql = "SELECT reference,quantity FROM delivery_order WHERE do_id = '" . $id_do . "'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$reference = $row['reference'];
			$quantity = $row['quantity'];
			$sql_so = "SELECT id,quantity FROM sales_order_sent WHERE so_id = '" . $so_id . "' AND reference = '" . $reference . "'";
			$result_so = $conn->query($sql_so);
			$so = $result_so->fetch_assoc();
			$new_quantity = $so['quantity'] - $quantity;
			$id = $so['id'];
			
			$sql_insert = "UPDATE sales_order_sent SET quantity = '" . $new_quantity . "' WHERE id = '" . $id . "' AND status = '0'";
			$result_insert = $conn->query($sql_insert);
		};
		$sql_delete = "DELETE FROM code_delivery_order WHERE id = '" . $id_do . "'";
		$result_delete = $conn->query($sql_delete);
		
		$sql_delete = "DELETE FROM delivery_order WHERE do_id = '" . $id_do . "'";
		$result_delete = $conn->query($sql_delete);
	}
?>