<?php
	include('purchasingheader.php');
	$jumlah = $_POST['jumlah'];
	$nilai = true;
	$supplier_id = $_POST['supplier'];
	$sql_supplier = "SELECT name,address,city FROM supplier WHERE id = '". $supplier_id . "'";
	$result_supplier = $conn->query($sql_supplier);
	$supplier = $result_supplier->fetch_assoc();
?>
<div class='main'>
<?php
	for($i = 1; $i < $jumlah; $i++){
		//Checking the reference//
		$reference = $_POST['reference' . $i];
		$sql_check_reference = "SELECT COUNT(id) AS jumlah FROM itemlist WHERE reference = '" . $reference . "'";
		$result_check_reference = $conn->query($sql_check_reference);
		$check = $result_check_reference->fetch_assoc();
		if($check['jumlah'] == 0){
			echo('There was an error when checking the reference to itemlist');
			$nilai = false;
			break;
		}
		$sql_check_stock = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_check_stock = $conn->query($sql_check_stock);
		$stock = $result_check_stock->fetch_assoc();
		if($stock['stock'] == 0){
			echo('There was an error when checking the reference to stock');
			$nilai = false;
			break;
		}
	}
	if($nilai == true){
?>
<h2><?= $supplier['name'] ?></h2>
<p><?= $supplier['address'] ?></p>
<p><?= $supplier['city'] ?></p>
	<form action='purchasing_return_input.php' method='POST' id='return_form'>
		<input type='hidden' value='<?= $supplier_id ?>' name='supplier'>
		<table class='table table-hover'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
<?php
		for($i = 1; $i < $jumlah; $i++){
?>
		<tr>
			<td>
				<?= $_POST['reference' . $i]; ?>
				<input type='hidden' value='<?= $_POST['reference' . $i] ?>' name='reference<?= $i ?>'
			</td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $_POST['reference' . $i] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td>
				<?= $_POST['quantity' . $i ] ?>
				<input type='hidden' value='<?= $_POST['quantity' . $i] ?>' name='quantity<?= $i ?>'
			</td>
		</tr>
<?php
		}
?>
	</table>
	<hr>
	<input type='hidden' value='<?= $jumlah ?>' name='jumlah'>
	<button type='button' class='btn btn-default' onclick='submiting()'>Submit</button>
<?php
	}
?>
<script>
	function submiting(){
		$('#return_form').submit();
	}
</script>