<?php	
	include('inventoryheader.php');
?>
<div class='main'>
	<h2>Return</h2>
	<p>Purchasing return</p>
	<hr>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Supplier</th>
			<th></th>
		</tr>
<?php
	$sql_code = "SELECT * FROM code_purchase_return WHERE isconfirm = '1'";
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
			<td>
				<button type='button' class='btn btn-default' id='plus<?= $code['id'] ?>' onclick='show(<?= $code['id'] ?>)'>+</button>
				<button type='button' class='btn btn-warning' id='minus<?= $code['id'] ?>' onclick='hide(<?= $code['id'] ?>)' style='display:none'>-</button>
			</td>
		</tr>
		<tbody id='table<?= $code['id'] ?>' style='display:none'>
<?php
		$sql = "SELECT * FROM purchase_return WHERE code_id = '" . $code['id'] . "'";
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
		<tr>
			<td colspan='2'></td>
			<td><button type='button' class='btn btn-default' onclick='submit(<?= $code['id'] ?>)'>Submit</button></td>
			<form action='purchasing_return_do.php' method='POST' id='form<?= $code['id'] ?>'>
				<input type='hidden' value='<?= $code['id'] ?>' name='id' readonly>
			</form>
		</tbody>
<?php
	}
?>
	</table>
</div>
<script>
	function show(n){
		$('#table' + n).show();
		$('#minus' + n).show();
		$('#plus' + n).hide();
	}
	function hide(n){
		$('#table' + n).hide();
		$('#minus' + n).hide();
		$('#plus' + n).show();
		
	}
	function submit(n){
		$('#form' + n).submit();
	}
</script>