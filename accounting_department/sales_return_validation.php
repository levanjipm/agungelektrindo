<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');

	if(empty($_POST['id'])){
?>
<script>
	window.location.href='/agungelektrindo/accounting';
</script>
<?php } ?>
<head>
	<title>Validate sales return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Sales return</p>
	<hr>
	<form action='sales_return_input' method='POST'>
		<label>Date input to bank</label>
		<input type='date' class='form-control' name='date' required>
		<input type='hidden' value='<?= $_POST['id'] ?>' name='id'>
		<br>
		<button type='submit' class='button_success_dark'>Submit</button>
	</form>
	<br>
<?php
	
	$return_id 				= $_POST['id'];
		
	$sql					= "SELECT code_sales_return.id, code_sales_return_received.document, code_sales_return_received.date, 
								code_delivery_order.customer_id, code_delivery_order.name
								FROM code_sales_return_received 
								JOIN code_sales_return ON code_sales_return_received.code_sales_return_id = code_sales_return.id
								JOIN code_delivery_Order ON code_sales_return.do_id = code_delivery_order.id
								WHERE code_sales_return_received.id = '$return_id'";
	$result			 		= $conn->query($sql);
	$row	 				= $result->fetch_assoc();
	
	$delivery_order_name	= $row['name'];
	$return_date			= $row['date'];
	$return_document		= $row['document'];
	
	$customer_id			= $row['customer_id'];
		
	$sql_customer 			= "SELECT name,city, address FROM customer WHERE id = '$customer_id'";
	$result_customer 		= $conn->query($sql_customer);
	$customer 				= $result_customer->fetch_assoc();
		
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
?>
	<label>Customer data</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Return data</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($return_date)) ?></p>
	<p style='font-family:museo'><?= $return_document ?></p>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Item name</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit price</th>
				<th>Total price</th>
			</tr>
		</thead>
		<tbody>
<?php
	$return_price		= 0;
	$sql				= "SELECT sales_return_received.quantity, delivery_order.reference, delivery_order.billed_price
							FROM sales_return_received 
							JOIN sales_return ON sales_return_received.sales_return_id = sales_return.id
							JOIN delivery_order ON sales_return.delivery_order_id = delivery_order.id
							WHERE sales_return_received.received_id = '$return_id'";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$price			= $row['billed_price'];
		$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
		
		$return_price	+= $price * $quantity;
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $quantity ?></td>
				<td>Rp. <?= number_format($price,2) ?></td>
				<td>Rp. <?= number_format($price * $quantity,2) ?></td>
			</tr>
<?php
	}
?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan='3'></td>
				<td><strong>Total</strong></td>
				<td>Rp. <?= number_format($return_price,2) ?></td>
			</tr>
		</tfoot>
	</table>
</div>