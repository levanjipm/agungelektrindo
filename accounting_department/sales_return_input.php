<?php
	include('../codes/connect.php');
	$date			= $_POST['date'];
	$id				= $_POST['id'];
	$return_price		= 0;
	
	$sql				= "SELECT code_delivery_order.customer_id, code_sales_return_received.document
							FROM code_sales_return_received 
							JOIN code_sales_return ON code_sales_return_received.code_sales_return_id = code_sales_return.id
							JOIN code_delivery_Order ON code_sales_return.do_id = code_delivery_order.id
							WHERE code_sales_return_received.id = '$id'";
	$result			 	= $conn->query($sql);
	$row	 			= $result->fetch_assoc();
	
	$customer_id		= $row['customer_id'];
	$document			= mysqli_real_escape_string($conn,$row['document']);
	
	$sql				= "SELECT sales_return_received.quantity, delivery_order.billed_price
							FROM sales_return_received 
							JOIN sales_return ON sales_return_received.sales_return_id = sales_return.id
							JOIN delivery_order ON sales_return.delivery_order_id = delivery_order.id
							WHERE sales_return_received.received_id = '$id'";
	$result				= $conn->query($sql);
	$return_price		= 0;
	while($row			= $result->fetch_assoc()){
		$quantity		= $row['quantity'];
		$price			= $row['billed_price'];
		$return_price	+= $quantity * $price;
	}
	
	$sql				= "UPDATE code_sales_return_received SET isdone = '1' WHERE id = '$id'";
	$result				= $conn->query($sql);
	
	if($result){
		$sql			= "INSERT INTO code_bank (date, value, transaction, bank_opponent_id, label, isdone, major_id, description)
							VALUES ('$date', '$return_price', '2', '$customer_id', 'CUSTOMER', '0', '0', '$document')";
		$conn->query($sql);
	}
	
	header('location:../accounting');
?>