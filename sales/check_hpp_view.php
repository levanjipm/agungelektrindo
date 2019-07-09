<?php
	include('salesheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Cost of Goods Sold</h2>
	<hr>
	<br>
	<div class='row' style='text-align:center'>
		<div class='col-sm-3'>
			Reference
		</div>
		<div class='col-sm-4'>
			Description
		</div>
		<div class='col-sm-4'>
			Unit price
		</div>
	</div>
	<hr>
<?php
	$references = $_POST['reference_array'];
	$quantities = $_POST['quantity_array'];
	foreach($references as $reference){
		$total = 0;
		$key = array_search($reference, $references);
		$quantity = $quantities[$key];
		$quantity_cek = $quantities[$key];
		$sql_value_in = "SELECT price,sisa FROM stock_value_in WHERE sisa > 0 AND reference = '" . $reference . "' ORDER BY id DESC";
		$result_value_in = $conn->query($sql_value_in);
		while($value_in = $result_value_in->fetch_assoc()){
			if($value_in['sisa'] > $quantity){
				$total = $total + $value_in['price'] * $quantity;
				break;
			} else {
				$total = $total + $value_in['price'] * $value_in['sisa'];
				$quantity_cek = $quantity_cek - $value_in['sisa'];
			}
		}
?>
	<div class='row' style='text-align:center'>
		<div class='col-sm-3'>
			<?= $reference ?>
		</div>
		<div class='col-sm-4'>
<?php
	$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
	$result_item = $conn->query($sql_item);
	$item = $result_item->fetch_assoc();
			echo $item['description'];
?>
		</div>
		<div class='col-sm-4'>
			Rp. <?= number_format(($total / $quantity),2) ?>
		</div>
	</div>
<?php
	}
?>