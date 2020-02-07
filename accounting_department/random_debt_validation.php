<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Input random debt document</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Debt document</h2>
	<p style='font-family:museo'>Input random debt document</p>
	<hr>
	<form action='random_debt_input' method='POST'>
<?php
	$date					= $_POST['date'];
	$supplier_id			= $_POST['supplier'];
	$tax					= $_POST['tax'];
	$value					= $_POST['value'];
	$document_name			= mysqli_real_escape_string($conn,$_POST['document']);
	$description			= mysqli_real_escape_string($conn,$_POST['description']);
	
	if($tax	== 1){
		$value_before_tax	= $value * 10 / 11;
		$tax_value			= $value  - $value_before_tax;
	} else {
		$value_before_tax	= $value;
		$tax_value			= 0;
	}
	
	$sql_supplier			= "SELECT name,address,city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier		= $conn->query($sql_supplier);
	$supplier				= $result_supplier->fetch_assoc();
	
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	$guid = GUID();
?>
		<h4><?= $supplier_name ?></h4>
		<p><?= $supplier_address ?></p>
		<p><?= $supplier_city ?></p>
		<label>GUID</label>
		<p><?= $guid ?></p>
<?php
	if($tax	== 1){
?>
		<label>Tax document</label>
		<input type='text' class='form-control' name='tax_document' id='tax_document'>
		<br>
<?php
	}
?>
		<input type='hidden' value='<?= $guid ?>' 			name='guid'>
		<input type='hidden' value='<?= $date ?>' 			name='date'>
		<input type='hidden' value='<?= $supplier_id ?>'	name='supplier'>
		<input type='hidden' value='<?= $tax ?>' 			name='tax'>
		<input type='hidden' value='<?= $value ?>' 			name='value'>
		<input type='hidden' value='<?= $document_name ?>' 	name='document_name'>
		<input type='hidden' value='<?= $description ?>' 	name='description'>
		<table class='table table-bordered'>
			<tr>
				<th>Date</th>
				<th>Document</th>
				<th>Value</th>
			</tr>
			<tr>
				<td><?= date('d M Y',strtotime($date)) ?></td>
				<td><?= $_POST['document'] ?></td>
				<td>Rp. <?= number_format($value_before_tax,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td><strong>Total</strong></td>
				<td>Rp. <?= number_format($value_before_tax,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td><strong>Tax</strong></td>
				<td>Rp. <?= number_format($tax_value,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td><strong>Grand Total</strong></td>
				<td>Rp. <?= number_format($value,2) ?></td>
			</tr>
		</table>
		<button type='submit' class='button_success_dark'>Submit</button>
	</div>
</div>