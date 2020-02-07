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
	<form action='random_debt_validation' method='POST'>
		<label>Date</label>
		<input type='date' class='form-control' name='date' id='date' required>
		<label>Supplier</label>
		<select class='form-control' id='supplier' name='supplier' required>
			<option value=''>Please select a supplier</option>
<?php
	$sql_supplier = "SELECT id,name FROM supplier ORDER BY name ASC";
	$result_supplier = $conn->query($sql_supplier);
	while($supplier = $result_supplier->fetch_assoc()){
?>
			<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
	}
?>
		</select>
		<label>Taxing</label>
		<select class='form-control' name='tax' id='tax' required>
			<option value=''>Please select taxing option</option>
			<option value='1'>Tax</option>
			<option value='0'>Non-tax</option>
		</select>
		<label>Document name</label>
		<input type='text' class='form-control' name='document' required>
		<label>Value</label>
		<input type='number' class='form-control' name='value' id='value' min='0'>
		<label>Description</label>
		<textarea name='description' id='description' class='form-control' style='resize:none' required></textarea>
		<br>
		<button type='submit' class='button_default_dark'>Submit</button>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#date').focus();
	});
</script>