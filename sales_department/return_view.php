<?php
	include('../codes/connect.php');
	$id						= $_POST['id'];
	$sql_code				= "SELECT code_delivery_order.name, code_delivery_order.customer_id FROM code_sales_return 
							JOIN code_delivery_order ON code_delivery_order.id = code_sales_return.do_id
							WHERE code_sales_return.id = '$id'";
	$result_code			= $conn->query($sql_code);
	$code					= $result_code->fetch_assoc();
	
	$delivery_order_name	= $code['name'];

	$customer_id			= $code['customer_id'];
		
	$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer				= $result_customer->fetch_assoc();
		
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
?>	
	<h3 style='font-family:museo'>General data</h3>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Delivery Order name</label>
	<p style='font-family:museo'><?= $delivery_order_name ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Unit Price</th>
			<th>Total price</th>
		</tr>
<?php
	$total_price			= 0;
	$sql_sales_return		= "SELECT sales_return.quantity, delivery_order.reference, delivery_order.billed_price FROM sales_return
							JOIN delivery_order ON sales_return.delivery_order_id = delivery_order.id 
							WHERE sales_return.return_id = '$id'";
	$result_sales_return	= $conn->query($sql_sales_return);
	while($sales_return		= $result_sales_return->fetch_assoc()){
		$reference			= $sales_return['reference'];
		$quantity			= $sales_return['quantity'];
		$billed_price		= $sales_return['billed_price'];
		
		$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$description		= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= $quantity ?></td>
			<td>Rp. <?= number_format($billed_price,2) ?></td>
			<td>Rp. <?= number_format($quantity * $billed_price,2) ?></td>
		</tr>
<?php
		$total_price		+= $billed_price * $quantity;
	}
?>
		<tr>
			<td colspan='3'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($total_price,2) ?></td>
		</tr>
	</table>
	<button type='button' class='button_danger_dark' onclick='delete_sales_return(<?= $id ?>)' id='cancel_button'>Cancel</button>
	<button type='button' class='button_success_dark' onclick='confirm_sales_return(<?= $id ?>)' id='confirm_button'>Confirm</button>