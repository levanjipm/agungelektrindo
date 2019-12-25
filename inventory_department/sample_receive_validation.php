<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$id			= $_POST['id'];
?>
<head>
	<title>Receive sample</title>
</head>
<?php
	$sql					= "SELECT code_sample.date_sent, code_sample.id, customer.name, customer.address, customer.city
								FROM code_sample 
								JOIN customer ON code_sample.customer_id = customer.id
								WHERE code_sample.id = '$id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	$sample_id				= $row['id'];
	$customer_name			= $row['name'];
	$customer_address		= $row['address'];
	$customer_city			= $row['city'];
	
	$date_sent				= $row['date_sent'];
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
	<p style='font-family:museo'>Sent on <?= date('d M Y',strtotime($date_sent)) ?></p>
	
	<label>Receive date</label>
	<input type='date' class='form-control' id='date' name='send_sample_date' value='<?= date('Y-m-d') ?>'>
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
	$sql					= "SELECT sample.reference, itemlist.description, sample.quantity
								FROM sample 
								JOIN itemlist ON sample.reference = itemlist.reference
								WHERE sample.code_id = '$id'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$reference			= $row['reference'];
		$description		= $row['description'];
		$quantity			= $row['quantity'];
		$sql_stock			= "SELECT stock FROM stock WHERE reference = '$reference'";
		$result_stock		= $conn->query($sql_stock);
		$stock				= $result_stock->fetch_assoc();
		
		$stock_level		= $stock['stock'];
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
	<button type='button' class='button_success_dark' id='receive_button'>Receive</button>
</div>