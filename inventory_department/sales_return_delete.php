<?php
	include('../codes/connect.php');
	$return_id					= $_POST['return_id'];
	$sql						= "SELECT * FROM sales_return_received WHERE received_id = '$return_id'";
	$result						= $conn->query($sql);
	while($row					= $result->fetch_assoc()){
		$sales_return_id		= $row['sales_return_id'];
		$quantity				= $row['quantity'];
		
		$sql_sales_return		= "SELECT * FROM sales_return WHERE id = '$sales_return_id'";
		$result_sales_return	= $conn->query($sql_sales_return);
		$sales_return			= $result_sales_return->fetch_assoc();
		
		$received_quantity		= $sales_return['received'];
		
		$final_quantity			= $received_quantity - $quantity;
		
		$sql_update				= "UPDATE sales_return SET received = '$final_quantity', isdone = '0' WHERE id = '$sales_return_id'";
		$conn->query($sql_update);
		
		$sql_delete				= "DELETE FROM sales_return_received WHERE id = '$sales_return_id'";
		$conn->query($sql_delete);
	}
	
	$sql_delete					= "DELETE FROM code_sales_return_received WHERE id = '$return_id'";
	$conn->query($sql_delete);
?>