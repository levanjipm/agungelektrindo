<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	if(empty($_POST['id'])){
?>
<script>
	window.history.back();
</script>
<?php
	}
	
	$invoice_id 		= $_POST['id'];
	$sql_invoice 		= "SELECT invoices.id, invoices.name, invoices.ongkir, invoices.value, code_delivery_order.customer_id
						FROM invoices 
						JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
						WHERE invoices.id = '" . $invoice_id . "'";
	$result_invoice 	= $conn->query($sql_invoice);
	$invoice 			= $result_invoice->fetch_assoc();
	
	$invoice_name		= $invoice['name'];
	$invoice_value		= $invoice['value'];
	$invoice_delivery	= $invoice['ongkir'];
	$customer_id		= $invoice['customer_id'];
	
	$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '$customer_id'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	$customer_address	= $customer['address'];
	$customer_city		= $customer['city'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p>Set invoice done</p>
	<hr>
	<h3 style='font-family:bebasneue'><?=$customer_name ?></h3>
	<p><?= $customer_address ?></p>
	<p><?= $customer_city ?></p>
	<form method='POST' action='invoice_set_done_input' id='form_danil'>
		<label>Date done</label>
		<input type='date' class='form-control' name='date' id='date'>
		<br>
		<h3 style='font-family:bebasneue'>Invoice detail</h3>
		<table class='table table-bordered'>
			<tr>
				<td><strong>Invoice name</strong></td>
				<td><?= $invoice['name'] ?></td>
			</tr>
			<tr>
				<td><strong>Value</strong></td>
				<td>Rp. <?= number_format($invoice['value'],2) ?></td>
			</tr>
				<td><strong>Delivery fee</strong></td>
				<td>Rp. <?= number_format($invoice['ongkir'],2) ?></td>
			</tr>
		</table>
		<h3 style='font-family:bebasneue'>Payment detail</h3>
		<table class='table table-bordered'>
			<tr>
				<td><strong>Date</strong></td>
				<td><strong>Value</strong></td>
			</tr>
<?php
	$sql_paid = "SELECT date,value FROM receivable WHERE invoice_id = '" . $invoice['id'] . "'";
	$result_paid = $conn->query($sql_paid);
	while($paid = $result_paid->fetch_assoc()){
?>
			<tr>
				<td><?= date('d M Y',strtotime($paid['date'])) ?></td>
				<td>Rp. <?= number_format($paid['value'],2) ?></td>
			</tr>
<?php
	}
?>
		</table>
		<br>
		<button type='button' class='button_warning_dark'>Back</button>
		<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
		<input type='hidden' value='<?= $invoice_id ?>' name='id'>
	</form>
</div>
<script>
	$('#submit_button').click(function(){
		if($('#date').val() == ''){
			$('#date').focus();
			alert('Please insert date!');
			return false;
		}
		$('#form_danil').submit();
	});
</script>