<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	$return_id				= (int)$_POST['id'];
	$sql_code 				= "SELECT code_delivery_order.customer_id FROM code_sales_return 
								JOIN code_delivery_order ON code_delivery_order.id = code_sales_return.do_id
								WHERE code_sales_return.id = '$return_id'";
	$result_code 			= $conn->query($sql_code);
	$code 					= $result_code->fetch_assoc();
	
	if(empty($_POST['id']) || mysqli_num_rows($result_code) == 0){
?>
<script>
	window.location.href='/agungelektrindo/inventory';
</script>
<?php } ?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Sales return</p>
	<hr>
	<form method='POST' action='sales_return_input'>
<?php
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid = GUID();
	
	$sql_customer 			= "SELECT name,address,city FROM customer WHERE id = '" . $code['customer_id'] . "'";
	$result_customer 		= $conn->query($sql_customer);
	$customer 				= $result_customer->fetch_assoc();
	
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
?>
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		
		<label>Document number</label>
		<input type='text' class='form-control' style='width:50%'  id='document' name='document' required>
		
		<label>Date</label>
		<input type='date' value='<?= date('Y-m-d') ?>' name='return_date' class='form-control' style='width:50%'>
		<br>
		<input type='hidden' value='<?= $guid ?>' name='guid'>
		<table class='table table-bordered'>
			<tr>
				<th style='width:20%'>Reference</th>
				<th style='width:40%'>Description</th>
				<th style='width:15%'>Return quantity</th>
				<th style='width:15%'>Received quantity</th>
			</tr>
<?php
	$sql_return			= "SELECT sales_return.id, sales_return.delivery_order_id, delivery_order.reference, sales_return.quantity, sales_return.received FROM sales_return 
							JOIN delivery_order ON delivery_order.id = sales_return.delivery_order_id
							WHERE sales_return.return_id = '" . $return_id . "'";
	$result_return 		= $conn->query($sql_return);
	while($return 		= $result_return->fetch_assoc()){
		$reference		= $return['reference'];
		$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item 	=  $conn->query($sql_item);
		$item 			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $return['quantity'] - $return['received'] ?></td>
				<td><input type='number' value='0' id='received<?= $return['id'] ?>' name='received[<?= $return['id'] ?>]' class='form-control' max='<?= $return['quantity'] - $return['received'] ?>'></td>
			</tr>
<?php
	}
?>
		</table>
		<input type='hidden' value='<?= $return_id ?>' name='return_id'>
		<button type='submit' class='button_default_dark'>Next</button>
	</form>
</div>