<?php
	include('../codes/connect.php');
	
	$return_quantity_array	= $_POST['return_quantity'];
	$jumlah_total 			= 0;
	$validation				= true;
	$do_id					= $_POST['delivery_order_id'];
	
	foreach($return_quantity_array as $return_quantity){
		$key					= key($return_quantity_array);
		
		$sql_delivery_order		= "SELECT quantity FROM delivery_order WHERE id = '$key'";
		$result_delivery_order	= $conn->query($sql_delivery_order);
		$delivery_order			= $result_delivery_order->fetch_assoc();
		$sent_quantity			= $delivery_order['quantity'];
		
		if($sent_quantity < $return_quantity){
			$validation		= false;
			break;
		}
		
		next($return_quantity_array);
	}
	
	$guid			= $_POST['guid'];
	$sql_guid		= "SELECT COUNT(id) as guid_control FROM code_sales_return WHERE guid = '" . $guid . "'";
	$result_guid	= $conn->query($sql_guid);
	$guid_row	 	= $result_guid->fetch_assoc();
	
	if($guid_row['guid_control'] > 0){
		$validation		= false;
	}
	
	if($validation == true){
		$reason 		= $_POST['reason'];
		$sql_do 		= "SELECT customer_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
		$result_do 		= $conn->query($sql_do);
		$row_do 		= $result_do->fetch_assoc();
		$customer_id 	= $row_do['customer_id'];
		
		$sql_insert 	= "INSERT INTO code_sales_return (submission_date,do_id,reason,guid) 
						VALUES (NOW(),'$do_id','$reason','$guid')";
		$conn->query($sql_insert);
		
		$sql_select 	= "SELECT id FROM code_sales_return WHERE guid = '$guid'";
		$result_select 	= $conn->query($sql_select);
		$row_select 	= $result_select->fetch_assoc();
		$return_id 		= $row_select['id'];
		
		$return_quantity_array	= $_POST['return_quantity'];

		foreach($return_quantity_array as $return_quantity){
			$key		= key($return_quantity_array);
			if($return_quantity > 0){
				$sql		= "INSERT INTO sales_return (delivery_order_id, quantity, return_id)
								VALUES ('$key','$return_quantity','$return_id')";
				$conn->query($sql);
				echo $sql;
			}
			next($return_quantity_array);
		}
	}
	
	header('location:../sales');
?>	