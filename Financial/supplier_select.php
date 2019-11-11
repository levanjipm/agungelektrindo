<?php
	include('../codes/connect.php');
?>
	<select class='form-control' id='transaction_select_to'  name='transaction_select_to'>
		<option value='0'>Please select a supplier</option>
<?php
	$sql_supplier			= "SELECT id,name,city FROM supplier";
	$result_supplier		= $conn->query($sql_supplier);
	while($supplier			= $result_supplier->fetch_assoc()){
		$supplier_id		= $supplier['id'];
		$supplier_name		= $supplier['name'];
		$supplier_address	= $supplier['city'];
?>
		<option value='<?= $supplier_id ?>' data-subtext="<?= $supplier_address ?>">
			<?= $supplier_name ?>
		</option>
<?php
	}
?>
	</select>