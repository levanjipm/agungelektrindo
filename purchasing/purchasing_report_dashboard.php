<?php
	include('purchasingheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Report</h2>
	<p>Create purchasing report</p>
	<hr>
	<label>Supplier</label>
	<select class='form-control' name='supplier'>
		<option value='0'>--Please select a supplier</option>
<?php
	$sql_supplier = "SELECT id,name FROM supplier ORDER BY name";
	$result_supplier = $conn->query($sql_supplier);
	while($supplier = $result_supplier->fetch_assoc()){
?>
		<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
	}
?>
	</select>
</div>