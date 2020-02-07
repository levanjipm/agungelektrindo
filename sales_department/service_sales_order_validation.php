<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$customer_id 		= mysqli_real_escape_string($conn,$_POST['customer']);
	$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
	
	$po_number 			= mysqli_real_escape_string($conn,$_POST['po_name']);
	if(mysqli_num_rows($result_customer) == 0){
?>
	<script>
		window.history.back();
	</script>
<?php
	}
	
	$date 				= $_POST['date'];
	$tax 				= $_POST['tax'];
	$seller 			= $_POST['seller'];
	
	$service_name_array			= $_POST['service_name'];
	$service_quantity_array		= $_POST['service_quantity'];
	$service_unit_array			= $_POST['service_unit'];
	$service_price_array		= $_POST['service_price'];
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid	= GUID();
?>
<head>
	<title>Service sales order</title>
</head>
<div class='main'>
	<form action='service_sales_order_input' method='POST' id='service_sales_order_form'>
	
	<input type='hidden' value='<?= $seller ?>' name='seller'>
	<input type='hidden' value='<?= $tax ?>' name='tax'>
	<input type='hidden' value='<?= $customer_id ?>' name='customer'>
	<input type='hidden' value='<?= $po_number ?>' name='po_number'>
	<input type='hidden' value='<?= $date ?>' name='date'>
	
	<h2 style='font-family:bebasneue'>Sales order</h2>
	<p>Service sales order validation</p>
	<hr>
	<label>Date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	
	<label>Customer :</label>
	<p style='font-family:museo'><?= $customer['name'] ?></p>
	
	<label>Purchase Order</label>
	<p style='font-family:museo'><?= $po_number ?></p>
	
	<label>GUID</label>
	<p style='font-family:museo'><?= $guid ?></p>
	<input type='hidden' value='<?= $guid ?>' name='guid'>
	
	<table class='table table-bordered'>
		<tr>
			<th>Service name</th>
			<th>Quantity</th>
			<th>Unit price</th>
			<th>Total Price</th>
		</tr>
		
<?php
	$total 			= 0;
	$i				= 1;
	foreach($service_name_array as $service_name){
		$key 		= key($service_name_array);
		$quantity 	= $service_quantity_array[$key];
		$unit 		= $service_unit_array[$key];
		$price 		= $service_price_array[$key];
?>
		<tr>
			<td>
				<?= $service_name ?>
				<input type='hidden' value='<?= mysqli_real_escape_string($conn,$service_name) ?>' name='descriptions[<?= $i ?>]'>
			</td>
			<td>
				<?= $quantity ?>
				<input type='hidden' value='<?= $quantity ?>' name='quantities[<?= $i ?>]'>
			</td>
			<td>
				Rp. <?= number_format($price,2) ?>
				<input type='hidden' value='<?= $price ?>' name='prices[<?= $i ?>]'>
			</td>
			<td>Rp. <?= number_format($quantity * $price,2) ?></td>
		</tr>
<?php
		$total = $total + $price * $quantity;
		next($service_name_array);
		$i++;
	}
?>
		<tr>
			<td colspan='2'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($total,2) ?></td>
		</tr>
	</table>
	</form>
	<button type='button' class='button_default_dark' id='submit_button'>Submit</button>
</div>
<script>
	$('#submit_button').click(function(){
		$('#service_sales_order_form').submit();
	});
</script>