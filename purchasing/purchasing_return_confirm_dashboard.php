<?php
	include('purchasingheader.php');
?>
<div class='main'>
	<h2>Purchasing Return</h2>
	<p>Confirm return</p>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Supplier</th>
			<th>
		</tr>
<?php
	$sql_code = "SELECT * FROM code_purchase_return WHERE isconfirm = '0'";
	$result_code = $conn->query($sql_code);
	while($code = $result_code->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['date'])) ?></td>
			<td><?php
				$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $code['supplier_id'] . "'";
				$result_supplier = $conn->query($sql_supplier);
				$supplier = $result_supplier->fetch_assoc();
				echo $supplier['name'];
			?></td>
			<td><button type='button' class='btn btn-default' onclick='submit(<?= $code['id'] ?>)'>Confirm</button></td>
			<form action='return_confirm_input.php' method='POST' id='form_return<?= $code['id'] ?>'>
				<input type='hidden' value='<?= $code['id'] ?>' name='id' readonly'>
			</form>
		</tr>
		<tbody>
<?php
		$sql_return = "SELECT * FROM purchase_return WHERE code_id = '" . $code['id'] . "'";
		$result_return = $conn->query($sql_return);
		while($return = $result_return->fetch_assoc()){
?>
			<tr>
				<td><?= $return['reference'] ?></td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $return['reference'] . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $return['quantity'] ?></td>
			</tr>
<?php
		}
?>
		</tbody>
<?php
	}
?>
</div>
<script>
	function submit(n){
		$('#form_return' + n).submit();
	}
</script>