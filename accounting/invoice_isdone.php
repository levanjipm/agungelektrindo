<?php
	//invoice_isdone//
	include('accountingheader.php');
	if(empty($_POST['id'])){
?>
<script>
	window.history.back();
</script>
<?php
	}
	
	$invoice_id = $_POST['id'];
	$sql_invoice = "SELECT * FROM invoices WHERE id = '" . $invoice_id . "'";
	$result_invoice = $conn->query($sql_invoice);
	$invoice = $result_invoice->fetch_assoc();
?>
<div class='main'>
	<h2><?php
		$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $invoice['customer_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		echo $customer['name'];		
	?></h2>
	<p><?= $customer['address'] ?></p>
	<p><?= $customer['city'] ?></p>
	<form method='POST' action='invoice_isdone_input.php' id='form_danil'>
		<input type='date' class='form-control' name='date' style='width:40%' id='date'>
		<table class='table table-hover'>
			<tr>
				<td>Invoice name</td>
				<td><?= $invoice['name'] ?></td>
			</tr>
			<tr>
				<td>Value</td>
				<td>Rp. <?= number_format($invoice['value'],2) ?></td>
			</tr>
				<td>Ongkir</td>
				<td>Rp. <?= number_format($invoice['ongkir'],2) ?></td>
			</tr>
		</table>
		<br>
		Paid
		<table class='table'>
			<tr>
				<th>Date</th>
				<th>Value</th>
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
		<button type='button' class='btn btn-warning'>Back</button>
		<button type='button' class='btn btn-default' id='submit_button'>Submit</button>
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