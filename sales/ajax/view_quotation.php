<?php
	include('../../codes/connect.php');
	$quotation_id = $_POST['term'];
	$sql = "SELECT * FROM code_quotation WHERE id = '" . $quotation_id . "'";
	$result = $conn->query($sql);
	$code = $result->fetch_assoc();
	$additional_discount = $code['additional_discount'];
?>
	<h2><?= $code['name'] ?></h2>
	<p><?php
		$sql_customer = "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		echo $customer['name'];
	?></p>
	<table class='table table-responsive'>
		<tr>
			<th style='width:10%'>Reference</th>
			<th style='width:15%'>Description</th>
			<th style='width:20%'>Price list</th>
			<th style='width:5%'>Disc.</th>
			<th style='width:20%'>Price</th>
			<th style='width:5%'>Qty</th>
			<th style='width:20%'>Total price</th>
		</tr>
<?php
	$total = 0;
	$sql_detail = "SELECT * FROM quotation WHERE quotation_code = '" . $quotation_id . "'";
	$result_detail = $conn->query($sql_detail);
	while($detail = $result_detail->fetch_assoc()){
?>
		<tr>
			<td><?= $detail['reference'] ?></td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $detail['reference'] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td>Rp. <?= number_format($detail['price_list'],2) ?></td>
			<td><?= number_format($detail['discount'],2) ?>%</td>
			<td>Rp. <?= number_format($detail['net_price'],2) ?></td>
			<td><?= $detail['quantity'] ?></td>
			<td>Rp. <?= number_format($detail['quantity'] * $detail['net_price'],2) ?></td>
		</tr>
<?php
		$total = $total + $detail['quantity'] * $detail['net_price'];
	}
?>
		<tr>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td colspan='2'>Total</td>
			<td><strong>Rp. <?= number_format($total,2) ?></td>
		</tr>
<?php
	if($additional_discount > 0){
?>
		<tr>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td colspan='2'>Add. Disc.</td>
			<td><strong>Rp. <?= number_format($additional_discount,2) ?></td>
		</tr>
		<tr>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td colspan='2'>Grand Total</td>
			<td><strong>Rp. <?= number_format($total - $additional_discount,2) ?></td>
		</tr>
<?php
	}
?>
	</table>