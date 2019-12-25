<?php
	include('../codes/connect.php');
	$purchase_return_id			= $_POST['id'];
	$sql						= "SELECT purchase_return_sent.quantity, purchase_return.sent_quantity as sent_total 
									FROM purchase_return_sent 
									JOIN purchase_return ON purchase_return_sent.sent_id = purchase_return.id
									WHERE sent_id = '$purchase_return_id'";
	$result						= $conn->query($sql);
	while($row					= $result->fetch_assoc()){
		$sent_id				= $row['sent_id'];
		$initial_sent_quantity	= $row['sent_total'];
		$sent_quantity			= $row['quantity'];
		$input_quantity			= $initial_sent_quantity - $sent_quantity;
		
		$sql					= "UPDATE purchase_return SET quantity = '$input_quantity', isdone = '0' WHERE id = '$sent_id'";
		$conn->query($sql);
	}
	
	$sql_delete					= "DELETE FROM purchase_return_sent WHERE sent_id = '$purchase_return_id'";
	$conn->query($sql_delete);
	
	$sql_delete					= "DELETE FROM code_purchase_return_sent WHERE id = '$purchase_return_id'";
	$conn->query($sql_delete);
?>