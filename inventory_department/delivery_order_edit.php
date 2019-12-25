<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	if(empty($_POST['id'])){
?>
	<script>
		window.location.replace("edit_delivery_order_dashboard.php");
	</script>
<?php
	} else {
		$do_id 					= $_POST['id'];
		$sql_so 				= "SELECT so_id,name,customer_id, date, tax FROM code_delivery_order WHERE id = '" . $do_id . "'";
		$result_so 				= $conn->query($sql_so);
		$row_so 				= $result_so->fetch_assoc();
		
		$so_id 					= $row_so['so_id'];
		$delivery_order_name	= $row_so['name'];
		$delivery_order_date	= $row_so['date'];
		$customer_id			= $row_so['customer_id'];
		$tax					= $row_so['tax'];
		
		if($customer_id != 0 || $customer_id != NULL){
			$sql_customer 			= "SELECT name FROM customer WHERE id = '$customer_id'";
			$result_customer 		= $conn->query($sql_customer);
			$customer 				= $result_customer->fetch_assoc();
				
			$customer_name			= $customer['name'];
		} else {
			$sql_customer			= "SELECT retail_name FROM code_salesorder WHERE id = '$so_id'";
			$result_customer		= $conn->query($sql_customer);
			$customer				= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['retail_name'];
		}
?>
<head>
	<title>Edit <?= $delivery_order_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p style='font-family:museo'>Edit delivery order</p>
	<hr>
	<label>Delivery order data</label>
	<p style='font-family:museo'><?= $delivery_order_name ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
	
	<p style='font-family:museo'><?= $customer_name ?></p>
	<form method='POST' action='edit_delivery_order_validation' id='myForm'>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Sent item</th>
			<th>Quantity ordered</th>
			<th>Quantity to be sent</th>
		</tr>
<?php
		$sql 					= "SELECT sales_order.reference, sales_order.quantity, sales_order.sent_quantity, itemlist.description
									FROM sales_order 
									JOIN itemlist ON sales_order.reference = itemlist.reference
									WHERE sales_order.so_id = '$so_id'";
		$results 				= $conn->query($sql);
		while($row 				= $results->fetch_assoc()){
			$reference			= $row['reference'];
			$quantity			= $row['quantity'];
			$sent_quantity		= $row['sent_quantity'];
			$description		= $row['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= $sent_quantity ?></td>
			<td><?= $quantity ?></td>
			<td>
				<input type='number' class='form-control' min ='0' name='quantity<?= $tt ?>' id='quantity<?= $tt ?>'>
			</td>
		</tr>
<?php	
		}
?>
	</table>
	<br><br>
	<input type='hidden' value='<?= $do_id ?>' name='do_id'>
	<button type='button' class='button_danger_dark' onclick='check()'>Edit Delivery Order</button>
</div>
<?php
	}
?>