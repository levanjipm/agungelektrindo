<?php
	include('accountingheader.php');
	$customer = $_POST['select_customer'];
	$purchaseorder_number = $_POST['purchaseordernumber'];
	$date = $_POST['today'];
	$reference_array = $_POST['reference'];
	$quantity_array = $_POST['quantity'];
	$price_array = $_POST['price'];
	$taxing = $_POST['taxing'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Random Invoice</h2>
	<p>Build proforma invoice validation</p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
		</tr>
		<form action='build_proforma_invoice_input.php' method='POST' id='proforma_invoice_form'>
			<input type='hidden' value='<?= $customer ?>' name='customer'>
			<input type='hidden' value='<?= $date ?>' name='date'>
			<input type='hidden' value='<?= $purchaseorder_number ?>' name='purchaseorder_number'>
			<input type='hidden' value='<?= $taxing ?>' name='taxing'>
<?php
	$total_price = 0;
	$i = 1;
	foreach($reference_array AS $reference){
		$key = key($reference_array);
		$quantity = $quantity_array[$key];
		$price = $price_array[$key];
		$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
		$result_item = $conn->query($sql_item);
		$item = $result_item->fetch_assoc();
?>
			<tr>
				<td>
					<?= $reference ?>
					<input type='hidden' value='<?= mysqli_real_escape_string($conn,$reference) ?>' name='reference[<?= $i ?>]'>
				</td>
				<td><?= $item['description']; ?></td>
				<td>
					Rp. <?= number_format($price,2) ?>
					<input type='hidden' value='<?= $price ?>' name='price[<?= $i ?>]'>
				</td>
				<td>
					<?= number_format($quantity,0) ?>
					<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $i ?>]'>
				</td>
				<td>Rp. <?= number_format($price * $quantity,2) ?></td>
			</tr>
<?php
		$total_price += $price * $quantity;
		next($reference_array);
	$i++;
	}
?>
		</form>
		<tr>
			<td style='background-color:white;border:none;' colspan='3'></td>
			<td>Grand Total</td>
			<td>Rp. <?= number_format($total_price,2) ?></td>
		</tr>
	</table>
	<br>
	<button type='button' class='btn btn-secondary' id='proforma_invoice_submit_button'>Submit</button>
</div>
<script>
	window.onunload = function() {
    alert('Bye.');
}
	$('#proforma_invoice_submit_button').click(function(){
		$('#proforma_invoice_form').submit();
	});
</script>