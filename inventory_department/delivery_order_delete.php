<?php
	include('../codes/connect.php');
	$id_do 					= $_POST['do_id'];
	
	$sql_code 				= "SELECT so_id FROM code_delivery_order WHERE id ='$id_do'";
	$result_code 			= $conn->query($sql_code);
	$code 					= $result_code->fetch_assoc();
	$so_id 					= $code['so_id'];
	$sql 					= "SELECT reference,quantity, billed_price FROM delivery_order WHERE do_id = '$id_do'";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		$reference 			= $row['reference'];
		$quantity 			= $row['quantity'];
		$billed_price		= $row['billed_price'];
		$sql_so 			= "SELECT id,sent_quantity FROM sales_order WHERE so_id = '$so_id' 
								AND reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND price = '$billed_price'";
		$result_so 			= $conn->query($sql_so);
		$so					= $result_so->fetch_assoc();
		
		$updated_quantity	= $so['sent_quantity'] - $quantity;
		$id 				= $so['id'];
		
		$sql_insert 		= "UPDATE sales_order SET sent_quantity = '$updated_quantity', status = '0' WHERE id = '$id'";
		$conn->query($sql_insert);
	};
	
	$sql_delete 			= "DELETE FROM delivery_order WHERE do_id = '$id_do'";
	$conn->query($sql_delete);
	
	$sql_delete 			= "DELETE FROM code_delivery_order WHERE id = '$id_do'";
	$conn->query($sql_delete);
?>