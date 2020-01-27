<?php
	include('codes/connect.php');
	$value_customer				= array();
	$sql						= "SELECT customer_id, id FROM code_delivery_order WHERE YEAR(date) = '2019' AND company = 'AE'";
	$result						= $conn->query($sql);
	$i			= 1;
	while($row					= $result->fetch_assoc()){
		$customer_id			= $row['customer_id'];
		$delivery_order_id 		= $row['id'];
		$sql_delivery_order		= "SELECT reference FROM delivery_order WHERE do_id = '$delivery_order_id'";
		$result_delivery_order	= $conn->query($sql_delivery_order);
		$validation				= true;
		if(mysqli_num_rows($result_delivery_order) > 0){
			while($delivery_order	= $result_delivery_order->fetch_assoc()){
				$reference			= $delivery_order['reference'];
				
				$sql_item			= "SELECT type FROM itemlist WHERE reference = '$reference'";
				$result_item		= $conn->query($sql_item);
				$item				= $result_item->fetch_assoc();
				
				$item_type			= $item['type'];
				
				if($item_type != 2 && $item_type != 3 && $item_type != 4 && $item_type != 5 && $item_type != 17){
					$validation = false;
				}
			};
		} else {
			$validation				= true;
		}
		
		if($validation){
			$sql_value			= "SELECT value FROM invoices WHERE do_id = '$delivery_order_id'";
			$result_value		= $conn->query($sql_value);
			$row_value			= $result_value->fetch_assoc();
			
			$value				= $row_value['value'];
			$value_customer[$customer_id][$i] = $value;
		}
		
		$i++;
	}
?>
<table>
	<tr>
		<td>Customer name</td>
		<td>Value 2019</td>
	</tr>
<?php
	foreach($value_customer as $value_array){
		$customer		= key($value_customer);
		$value_dia		= 0;
		
		$sql_customer	= "SELECT name FROM customer WHERE id = '$customer'";
		$result_customer	= $conn->query($sql_customer);
		$row_customer		= $result_customer->fetch_assoc();
		
		$customer_name	= $row_customer['name'];
		foreach($value_array as $value){
			$value_dia += $value;
			
			next($value_array);
		}
?>
	<tr>
		<td><?= $customer_name ?></td>
		<td><?= $value_dia ?></td>
<?php
		next($value_customer);
		
	};
?>