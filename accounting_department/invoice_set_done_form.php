<?php
	include('../codes/connect.php');
	if(empty($_POST['id'])){
?>
<script>
	window.history.back();
</script>
<?php
	}
	
	$invoice_id 		= (int) $_POST['id'];
	$sql_invoice 		= "SELECT customer.name as customer_name, customer.address, customer.city, invoices.id, invoices.name, invoices.ongkir, invoices.value
							FROM invoices 
							JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							JOIN customer ON code_delivery_order.customer_id = customer.id
							WHERE invoices.id = '$invoice_id'";
	$result_invoice 	= $conn->query($sql_invoice);
	$invoice 			= $result_invoice->fetch_assoc();
	
	$invoice_name		= $invoice['name'];
	$invoice_value		= $invoice['value'];
	$invoice_delivery	= $invoice['ongkir'];
	
	$customer_name		= $invoice['customer_name'];
	$customer_address	= $invoice['address'];
	$customer_city		= $invoice['city'];
?>
	<label>Customer</label>
	<p style='font-family:museo'><?=$customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<form method='POST' action='invoice_set_done_input'>
		<label>Date done</label>
		<input type='date' class='form-control' name='date' required>
		<br>
		
		<label>Invoice detail</label>
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
		
		<label>Payment detail</label>
<?php
	$sql_paid 		= "SELECT date,value FROM receivable WHERE invoice_id = '" . $invoice['id'] . "'";
	$result_paid 	= $conn->query($sql_paid);
	$count_paid		= mysqli_num_rows($result_paid);
	
	if($count_paid > 0){
?>
		<table class='table table-bordered'>
			<tr>
				<td><strong>Date</strong></td>
				<td><strong>Value</strong></td>
			</tr>
<?php
		while($paid 	= $result_paid->fetch_assoc()){
?>
			<tr>
				<td><?= date('d M Y',strtotime($paid['date'])) ?></td>
				<td>Rp. <?= number_format($paid['value'],2) ?></td>
			</tr>
<?php
		}
?>
		</table>
<?php
	} else {
?>
	<p style='font-family:museo'><strong>There is no payment data</strong></p>
<?php
	}
?>
		<br>
		<button type='submit' class='button_success_dark'>Submit</button>
		<input type='hidden' value='<?= $invoice_id ?>' name='id'>
	</form>