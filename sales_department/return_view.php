<?php
	include('../codes/connect.php');
	
	$id						= $_POST['id'];
	$sql_code				= "SELECT customer_id, do_id FROM code_sales_return WHERE id = '$id'";
	$result_code			= $conn->query($sql_code);
	$code					= $result_code->fetch_assoc();
		
	$delivery_order_id		= $code['do_id'];
	$sql_do					= "SELECT name FROM code_delivery_order WHERE id = '$delivery_order_id'";
	$result_do				= $conn->query($sql_do);
	$do						= $result_do->fetch_assoc();
	
	$delivery_order_name	= $do['name'];

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
		</tr>
<?php
	$sql_sales_return	= "SELECT * FROM sales_return WHERE return_code = '$id'";
	$result_sales_return	= $conn->query($sql_sales_return);
	while($sales_return		= $result_sales_return->fetch_assoc()){
?>
		<tr>
			<td><?