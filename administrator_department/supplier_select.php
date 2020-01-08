<?php
	include('../codes/connect.php');
	if(empty($_POST['opponent'])){
		$opponent		= '';
	} else {
		$opponent			= $_POST['opponent'];
	}
?>
	<select class='form-control' id='transaction_select_to'  name='transaction_select_to'>
<?php
	$sql_supplier			= "SELECT id,name,city FROM supplier ORDER BY name ASC";
	$result_supplier		= $conn->query($sql_supplier);
	while($supplier			= $result_supplier->fetch_assoc()){
		$supplier_id		= $supplier['id'];
		$supplier_name		= $supplier['name'];
		$supplier_address	= $supplier['city'];
?>
		<option value='<?= $supplier_id ?>' <?php if($supplier_id == $opponent){ echo 'selected'; } ?>><?= $supplier_name ?></option>
<?php
	}
?>
	</select>