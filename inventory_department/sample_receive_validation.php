<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$id			= $_POST['id'];
	$sql_check	= "SELECT id FROM code_sample_delivery_order WHERE id = '$id'";
	$result_check	= $conn->query($sql_check);
	$check			= mysqli_num_rows($result_check);
	
	if(empty($_POST['id']) || $check == 0){
?>
<script>
	window.location.href='/agungelektrindo/inventory_department/sample_dashboard';
</script>
<?php
	}
?>
<head>
	<title>Receive sample</title>
</head>
<?php
	$sql					= "SELECT customer.name, customer.address, customer.city, code_sample_delivery_order.name as delivery_order_name, code_sample_delivery_order.date
								FROM code_sample_delivery_order
								JOIN code_sample ON code_sample_delivery_order.code_sample = code_sample.id
								JOIN customer ON code_sample.customer_id = customer.id
								WHERE code_sample_delivery_order.id = '$id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	
	$customer_name			= $row['name'];
	$customer_address		= $row['address'];
	$customer_city			= $row['city'];
	$delivery_order_name	= $row['delivery_order_name'];
	$delivery_order_date	= $row['date'];
?>
<head>
	<title>Validate sample</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Validate sample</p>
	<hr>
	<label>Customer data</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Sample data</label>
	<p style='font-family:museo'>Sent on <?= date('d M Y',strtotime($delivery_order_date)) ?></p>
	<form action='sample_receive_input' method='POST'>
	<label>Receive date</label>
	<input type='date' class='form-control' name='date' value='<?= date('Y-m-d') ?>' required min='<?= date('Y-m-d',strtotime($delivery_order_date)) ?>'>
	<br>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
<?php
	$validation				= TRUE;
	$sql					= "SELECT sample_delivery_order.quantity, sample.reference, itemlist.description
								FROM sample_delivery_order
								JOIN sample ON sample.id = sample_delivery_order.sample_id
								JOIN itemlist ON itemlist.reference = sample.reference
								WHERE sample_delivery_order.delivery_order_id = '$id'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$reference			= $row['reference'];
		$quantity			= $row['quantity'];
		$description		= $row['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= number_format($quantity,0) ?></td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
		<input type='hidden' value='<?= $id ?>' name='id'>
		<button type='submit' class='button_success_dark'>Receive</button>
	</form>
</div>