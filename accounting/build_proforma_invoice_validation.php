<?php
	include('accountingheader.php');
	$proforma_invoice_type		= $_POST['proforma_invoice_type'];
	$customer_id				= $_POST['select_customer'];
	$po_number					= mysqli_real_escape_string($conn,$_POST['purchaseordernumber']);
	$invoice_date				= $_POST['invoice_date'];
	$taxing						= $_POST['taxing'];
	$reference_array			= $_POST['reference'];
	$quantity_array				= $_POST['quantity'];
	$price_array				= $_POST['price'];
	
	$down_payment				= $_POST['down_payment'];
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid = GUID();
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Random Invoice</h2>
	<p>Build proforma invoice validation</p>
	<hr>
	<label>Unique GUID</label>
	<p><?= $guid ?></p>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
		</tr>
		<form action='build_proforma_invoice_input' method='POST' id='proforma_invoice_form'>
			<input type='hidden' value='<?= $customer_id ?>' name='customer'>
			<input type='hidden' value='<?= $invoice_date ?>' name='date'>
			<input type='hidden' value='<?= $po_number ?>' name='purchaseorder_number'>
			<input type='hidden' value='<?= $taxing ?>' name='taxing'>
			<input type='hidden' value='<?= $proforma_invoice_type ?>' name='proforma_invoice_type'>
			<input type='hidden' value='<?= $guid ?>' name='guid'>
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
			<td style='background-color:white;border:none;' colspan='2'></td>
			<td colspan='2'><strong>Grand Total</strong></td>
			<td>Rp. <?= number_format($total_price,2) ?></td>
		</tr>
<?php
	if($proforma_invoice_type != 3){
		if($proforma_invoice_type == 1){
			$text = "Down payment";
		} else {
			$text = "Paid in advance";
		}
?>
		<tr>
			<td colspan='2'></td>
			<td colspan='2'><?= $text ?></td>
			<td>Rp. <?= number_format($down_payment,2) ?></td>
		</tr>
		<tr>
			<td colspan='2'></td>
			<td colspan='2'>Billed price</td>
			<td>Rp. <?= number_format($total_price - $down_payment,2) ?></td>
		</tr>		
<?php
	}
?>
	</table>
	<br>
	<button type='button' class='button_default_dark' id='proforma_invoice_submit_button'>Submit</button>
</div>
<script>
	$('#proforma_invoice_submit_button').click(function(){
		$('#proforma_invoice_form').submit();
	});
</script>