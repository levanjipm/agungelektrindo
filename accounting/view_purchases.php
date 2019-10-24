<?php
	include('accountingheader.php');
	$id 				= $_POST['id'];
	$sql_code 			= "SELECT * FROM purchases WHERE id = '" . $id . "'";
	$result_code 		= $conn->query($sql_code);
	$code 				= $result_code->fetch_assoc();
		
	$supplier_id 		= $code['supplier_id'];
	$sql_supplier 		= "SELECT name,address,city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier 	= $conn->query($sql_supplier);
	$supplier 			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
	
?>
<div class='main'>
	<h3 style='font-family:bebasneue'><?= $supplier_name ?></h3>
	<p><?= $supplier_address ?></p>
	<p><?= $supplier_city ?></p>
	<p><strong>Total tagihan :</strong> Rp. <span id='purchase_total'></span></p>
	<hr>
<?php
	$value_total 		= 0;
	$sql_code_gr 		= "SELECT * FROM code_goodreceipt WHERE invoice_id = '" . $id . "'";
	$result_code_gr 	= $conn->query($sql_code_gr);
	while($code_gr 		= $result_code_gr->fetch_assoc()){
?>
		<h4 style='font-family:bebasneue'><?= $code_gr['document'] ?></h4>
			<table class='table'>
				<tr>
					<th>Reference</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total Price</th>
				</tr>
<?php
		$value 				= 0;
		$sql_gr 			= "SELECT goodreceipt.quantity, purchaseorder.reference, goodreceipt.billed_price
							FROM goodreceipt 
							JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
							WHERE gr_id = '" . $code_gr['id'] . "'";
		$result_gr 			= $conn->query($sql_gr);
		while($gr 			= $result_gr->fetch_assoc()){
			$reference		= $gr['reference'];
			$quantity		= $gr['quantity'];
			$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item	= $conn->query($sql_item);
			$item			= $result_item->fetch_assoc();
			$description	= $item['description'];
?>
				<tr>
					<td><?= $reference ?></td>
					<td><?= $description ?></td>
					<td><?= $quantity ?></td>
					<td>Rp. <?= number_format($gr['billed_price'],2) ?></td>
					<td>Rp. <?= number_format($gr['billed_price'] * $gr['quantity'],2) ?></td>
				</tr>
<?php
		$value += $gr['billed_price'] * $gr['quantity'];
		}
?>
				<tfoot>
					<tr>
						<td style='background-color:white;border:none' colspan='3'>
						<td><strong>Total</strong></td>
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