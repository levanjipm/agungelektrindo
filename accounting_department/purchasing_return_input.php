<?php
	include('../codes/connect.php');
	$id				= $_POST['id'];
	$bank_date		= $_POST['date'];
	
	$sql_code_purchase_return		= "SELECT code_purchase_return_sent.document, code_purchase_return_sent.date, code_purchase_return.supplier_id
										FROM code_purchase_return_sent 
										JOIN code_purchase_return ON code_purchase_return_sent.code_purchase_return_id = code_purchase_return.id
										WHERE code_purchase_return_sent.id = '$id'";
	$result_code_purchase_return	= $conn->query($sql_code_purchase_return);
	$code_purchase_return			= $result_code_purchase_return->fetch_assoc();
	
	$date							= $code_purchase_return['date'];
	$document						= $code_purchase_return['document'];
	$supplier_id					= $code_purchase_return['supplier_id'];
	
	$return_value					= 0;
	$sql_return						= "SELECT purchase_return_sent.quantity, purchase_return.reference, itemlist.description, purchase_return.price
										FROM purchase_return_sent
										JOIN purchase_return ON purchase_return_sent.purchase_return_id = purchase_return.id
										JOIN itemlist ON purchase_return.reference = itemlist.reference
										WHERE purchase_return_sent.sent_id = '$id'";
	$result_return					= $conn->query($sql_return);
	while($return					= $result_return->fetch_assoc()){
		$reference					= $return['reference'];
		$quantity					= $return['quantity'];
		$description				= $return['description'];
		$price						= $return['price'];
		$total_price				= $price * $quantity;
		$return_value				+= $total_price;
	}
	
	$sql			= "INSERT INTO code_bank (date, value, transaction, bank_opponent_id, label, isdone)
						VALUES ('$bank_date', '$return_value', '1', '$supplier_id', 'SUPPLIER', '0')";
						echo $sql;
	$result			= $conn->query($sql);
	if($result){
		$sql_bank	= "INSERT INTO code_bank (date, value, transaction, bank_opponent_id, label, isdone, description)
						VALUES ('$bank_date', '$return_value', '2', '$supplier_id', 'SUPPLIER', '1', '$document')";
		$conn->query($sql_bank);
	}
	
	$sql_update		= "UPDATE code_purchase_return_sent SET isdone = '1' WHERE id = '$id'";
	$result_update	= $conn->query($sql_update);
?>