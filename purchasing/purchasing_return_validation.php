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
				<th colspan='2'>Description</th>
				<th>Quantity</th>
				<th></th>
<?php
		for($i = 1; $i < $jumlah; $i++){
?>
		<tr>
			<td>
				<?= $_POST['reference' . $i]; ?>
				<input type='hidden' value='<?= $_POST['reference' . $i] ?>' name='reference<?= $i ?>'>
			</td>
			<td colspan='2'><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $_POST['reference' . $i] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td>
				<?= $_POST['quantity' . $i ] ?>
				<input type='hidden' value='<?= $_POST['quantity' . $i] ?>' name='quantity<?= $i ?>'>
			</td>
			<td></td>
		</tr>
		<tr>
			<td><strong>Date</strong></td>
			<td><strong>Supplier</strong></td>
			<td><strong>Quantity</strong></td>
			<td><strong>Price</strong></td>
			<td><input type="checkbox" value="1" id='check<?= $i ?>' name='check<?= $i ?>' onchange='perlihatkan(<?= $i ?>)'>Insert manually</td>
		</tr>
		<tr style='display:none' id='manual_tr<?= $i ?>'>
			<td colspan='3'></td>
			<td colspan='2'><input type='number' class='form-control' id='manual_price<?= $i ?>' name='manual_price<?= $i ?>'></td>
		</tr>
		<tbody id='automatic<?= $i ?>'>
<?php
			$sql_value = "SELECT * FROM stock_value_in WHERE reference = '" . $_POST['reference' . $i] . "' AND date >= '" . date('Y-m-d',strtotime('-2 year')) . "' AND sisa > 0 ORDER BY date DESC";
			$result_value = $conn->query($sql_value);
			while($value = $result_value->fetch_assoc()){
?>
			<tr>
				<td><?php
					echo (date('d M Y',strtotime($value['date'])));
				?></td>
				<td><?php
					if($value['supplier_id'] == 0){
						echo ("Stock awal");
					} else {
						$sql_supplier_in = "SELECT name,id FROM supplier WHERE id = '" . $value['supplier_id'] . "'";
						$result_supplier_in = $conn->query($sql_supplier_in);
						$supplier_in = $result_supplier_in->fetch_assoc();
						echo $supplier_in['name'];
					}
				?></td>
				<td><?= $value['quantity'] ?></td>
				<td style='width:20%'>Rp. <?= number_format($value['price'],2) ?></td>
				<td><input type='radio' value='<?= $value['price'] ?>' name='radio<?= $i ?>'>Pick</td>
			</tr>
<?php
			}
?>
		</tbody>
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
	function perlihatkan(n){
		if ($('#check' + n).is(':checked')) {
			$('#manual_tr' + n).show();
			$('#automatic' + n).hide();
		} else {
			$('#manual_tr' + n).hide();
			$('#automatic' + n).show();
		}
	}
	function submiting(){
		for(var i = 1; i < <?= $jumlah ?>; i++){
			console.log(i);
			if ($('#check' + i).is(':checked') && ($('#manual_price' + i).val() == '' || $('#manual_price' + i).val() == 0)){
				alert('Please insert correct price!');
				$('#manual_price' + i).focus();
				return false;
			} else if($('#check' + i).is(':checked') == false && $('input[name="radio' +i+'"]').is(':checked') == false){
				alert('Please select a correct price dsaa');
				return false;
			}				
		}
		$('#return_form').submit();
	}
</script>