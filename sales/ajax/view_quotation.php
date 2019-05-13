<?php
	include('../../codes/connect.php');
	$quotation_id = $_POST['term'];
	$sql = "SELECT * FROM code_quotation WHERE id = '" . $quotation_id . "'";
	$result = $conn->query($sql);
	$code = $result->fetch_assoc();
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
			<td><?= $detail['discount'] ?>%</td>
			<td>Rp. <?= number_format($detail['net_price'],2) ?></td>
			<td><?= $detail['quantity'] ?></td>
			<td>Rp. <?= number_format($detail['total_price']) ?></td>
		</tr>
<?php
	}
?>
		<tr>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td style='border:none'></td>
			<td colspan='2'>Total</td>
			<td><strong>Rp. <?= number_format($code['value'],2) ?></td>
		</tr>
	</table>