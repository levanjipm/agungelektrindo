<?php
	include('accountingheader.php');
	$id = $_POST['id'];
	$sql_code = "SELECT * FROM purchases WHERE id = '" . $id . "'";
	$result_code = $conn->query($sql_code);
	$code = $result_code->fetch_assoc();
	
	$supplier_id = $code['supplier_id'];
	$sql_supplier = "SELECT name,address,city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier = $conn->query($sql_supplier);
	$supplier = $result_supplier->fetch_assoc();
	
?>
<div class='main'>
	<h3 style='font-family:bebasneue'><?= $supplier['name'] ?></h3>
	<p><?= $supplier['address'] ?></p>
	<p><?= $supplier['city'] ?></p>
	<p><strong>Total tagihan :</strong> Rp. <span id='purchase_total'></span></p>
	<hr>
<?php
	$value_total = 0;
	$sql_code_gr = "SELECT * FROM code_goodreceipt WHERE invoice_id = '" . $id . "'";
	$result_code_gr = $conn->query($sql_code_gr);
	while($code_gr = $result_code_gr->fetch_assoc()){
?>
		<h4 style='font-family:bebasneue'><?= $code_gr['document'] ?></h4>
			<table class='table'>
				<tr>
					<th>Reference</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total Price</th>
				</tr>
<?php
		$value = 0;
		$sql_gr = "SELECT goodreceipt.quantity, purchaseorder.reference, purchaseorder.billed_price
		FROM goodreceipt 
		JOIN purchaseorder_received ON purchaseorder_received.id = goodreceipt.received_id
		JOIN purchaseorder ON purchaseorder_received.id = purchaseorder.id
		WHERE gr_id = '" . $code_gr['id'] . "'";
		$result_gr = $conn->query($sql_gr);
		while($gr = $result_gr->fetch_assoc()){
?>
				<tr>
					<td><?= $gr['reference'] ?></td>
					<td><?= $gr['quantity'] ?></td>
					<td>Rp. <?= number_format($gr['billed_price'],2) ?></td>
					<td>Rp. <?= number_format($gr['billed_price'] * $gr['quantity'],2) ?></td>
				</tr>
<?php
		$value += $gr['billed_price'] * $gr['quantity'];
		}
?>
				<tfoot>
					<tr>
						<td style='background-color:white;border:none' colspan='2'>
						<td>Total</td>
						<td>Rp. <?= number_format($value,2) ?></td>
					</tr>
				</tfoot>
			</table>
<?php
	$value_total += $value;
	}
?>
</div>
<script>
	$('#purchase_total').html('<?= number_format($value_total,2) ?>');
</script>