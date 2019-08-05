<?php
	include('accountingheader.php');
?>
<div class='main'>
	<h3 style='font-family:bebasneue'>Debt document</h3>
	<hr>
	<label>Date</label>
	<input type='date' class='form-control' name='date' id='date'>
	<label>Supplier</label>
	<select class='form-control' id='supplier' name='supplier'>
		<option value='0'>Please select a supplier</option>
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
	<select class='form-control' name='tax' id='tax'>
		<option value='0'>Please select taxing option</option>
		<option value='1'>Tax</option>
		<option value='2'>Non-tax</option>
	</select>
	<label>Value</label>
	<input type='number' class='form-control' name='value' id='value'>
	<label>Description</label>
	<textarea name='description' id='description' class='form-control'></textarea>
	<br><br>
	<button type='button' class='btn btn-secondary'>Submit</button>
</div>