<?php
	include('inventoryheader.php');
	if(empty($_POST['id'])){
?>
<script>
	window.history.back();
</script>
<?php
	}
	$sql_name = "SELECT COUNT(*) AS jumlah FROM return_delivery_order WHERE YEAR(date) = '" . date('Y') . "' AND type='BELI'";
	$result_name = $conn->query($sql_name);
	$name = $result_name->fetch_assoc();
	if($name['jumlah'] == 0){
		$prefix = 1;
	} else {
		$prefix = $name['jumlah'] + 1;
	}
	$do_name = "RTB-" . $prefix . "-" . date('Y');
	
	$sql = "SELECT * FROM code_purchase_return WHERE id = '" . $_POST['id'] . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$sql_supplier = "SELECT name,address,city FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
	$result_supplier = $conn->query($sql_supplier);
	$supplier = $result_supplier->fetch_assoc();
?>
<div class='main'>
	<h2>Return</h2>
	<p>Purchasing return</p>
	<hr>
	<h3><?= $supplier['name'] ?></h3>
	<p><?= $supplier['address'] ?></p>
	<p><?= $supplier['city'] ?></p>
	<p><strong><?= $do_name ?></strong></p>
	<hr>
	<table class='table'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
		$sql = "SELECT * FROM purchase_return WHERE code_id = '" . $_POST['id'] . "'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
?>
			<tr>
				<td><?= $row['reference'] ?></td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $row['quantity'] ?></td>
			</tr>
<?php
		}
?>
	</table>
	<button type='button' class='btn btn-default' onclick='submiting()'>Submit</button>
	<form action='purchasing_return_input.php' method='POST' id='form_to'>
		<input type='hidden' name='name' value='<?= $do_name ?>' readonly>
		<input type='hidden' value='<?= $_POST['id'] ?>' name='id' readonly>
	</form>
</div>
<script>
	function submiting(){
		$('#form_to').submit();
	}
</script>