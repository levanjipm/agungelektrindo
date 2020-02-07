<?php
	include('../codes/connect.php');
	
	$id_so				= $_POST['id_so'];
	$po_number			= $_POST['po_number'];
	$label				= $_POST['label'];
	$seller				= $_POST['seller'];
	$quantity_array		= $_POST['quantity'];
	$reference_array	= $_POST['reference'];
	$price_list_array	= $_POST['price_list'];
	$price_array		= $_POST['price'];
	
	if($seller			== ''){
		$sql			= "UPDATE code_salesorder SET po_number = '" . mysqli_real_escape_string($conn,$po_number) . "', 
							label = '$label' WHERE id = '$id_so'";
	} else {
		$sql			= "UPDATE code_salesorder SET po_number = '" . mysqli_real_escape_string($conn,$po_number) . "', 
							label = '$label', seller = '$seller' WHERE id = '$id_so'";
	}
	
	$conn->query($sql);
	
	foreach($quantity_array as $quantity){
		$key		= key($quantity_array);
		$reference	= $reference_array[$key];
		
		$sql_status		= "SELECT status,sent_quantity FROM sales_order WHERE id = '$key'";
		$result_status	= $conn->query($sql_status);
		$status_row		= $result_status->fetch_assoc();
		
		$status			= $status_row['status'];
		$sent_quantity	= $status_row['sent_quantity'];
		
		$sql_item		= "SELECT id FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		
		if(mysqli_num_rows($result_item) != 0){
			if($quantity >= $sent_quantity && $sent_quantity == 0){
				$sql		= "UPDATE sales_order SET reference = '" . mysqli_real_escape_string($conn,$reference) . "', quantity = '". $quantity . "'
							WHERE id = '$key'";
			} else if($quantity >= $sent_quantity && $sent_quantity > 0){
				$sql		= "UPDATE sales_order SET quantity = '". $quantity . "'	WHERE id = '$key'";
			}
			
			$conn->query($sql);
			
			$sql			= "SELECT quantity FROM sales_order WHERE id = '$key'";
			$result			= $conn->query($sql);
			$row			= $result->fetch_assoc();
			
			if($row['quantity'] == $sent_quantity){
				$sql		= "UPDATE sales_order SET status = '1' WHERE id = '$key'";
			} else {
				$sql		= "UPDATE sales_order SET status = '0' WHERE id = '$key'";
			}
			
			$conn->query($sql);
		}
	
		next($quantity_array);
	}
	
	if(!empty($_POST['reference-'])){
		$reference_array		= $_POST['reference-'];
		$quantity_array			= $_POST['quantity-'];
		$price_list_array		= $_POST['price_list-'];
		$price_array			= $_POST['price-'];
		
		foreach($reference_array as $reference){
			$key				= key($reference_array);
			$quantity			= $quantity_array[$key];
			$price_list			= $price_list_array[$key];
			$price				= $price_array[$key];
			
			$discount			= 100 - ($price / $price_list) * 100;
			
			$sql_item		= "SELECT id FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item	= $conn->query($sql_item);
			
			if(mysqli_num_rows($result_item) != 0){
				$sql		= "INSERT INTO sales_order (reference,price,discount,price_list,quantity, sent_quantity, status, so_id)
							VALUES ('" . mysqli_real_escape_string($conn,$reference) . "', '$price','$discount','$price_list','$quantity','0','0','$id_so')";
				$conn->query($sql);
			}
			
			next($reference_array);
		}
	}
	
	header('location:/agungelektrindo/sales');
?>