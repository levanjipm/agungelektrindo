<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>On Delivery Process</h2>
	<hr>
<?php
	$sql			= "SELECT id FROM code_delivery_order WHERE sent = '0' AND company = 'AE'";
	$result			= $conn->query($sql);
	if(mysqli_num_rows($result) > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>DO Number</th>
			<th>Customer</th>
		</tr>
<?php
	$sql_on_delivery		= "SELECT code_delivery_order.date, code_delivery_order.name, customer.name as customer_name,
								customer.address, customer.city
								FROM code_delivery_order 
								JOIN customer ON code_delivery_order.customer_id = customer.id
								WHERE code_delivery_order.sent = '0' AND code_delivery_order.company = 'AE'";
	$result_on_delivery		= $conn->query($sql_on_delivery);
	while($row				= $result_on_delivery->fetch_assoc()){
		$delivery_order_name	= $row['name'];
		$delivery_order_date	= $row['date'];
		$customer_name			= $row['customer_name'];
		$customer_address		= $row['address'];
		$customer_city			= $row['city'];
?>
		<tr>
			<td><p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p></td>
			<td><p style='font-family:museo'><?= $delivery_order_name ?></p></td>
			<td>
				<p style='font-family:museo'><strong><?= $customer_name ?></strong></p>
				<p style='font-family:museo'><?= $customer_address ?></p>
				<p style='font-family:museo'><?= $customer_city ?></p>
			</td>
			<td>
				<button type='button' class='button_success_dark'><i class='fa fa-eye'></i></button>
			</td>
		</tr>
<?php	
	}
?>
	</table>
<?php
	} else {
?>	
	<p style='font-family:museo'>There is no delivery</p>
<?php
	}
?>
</div>