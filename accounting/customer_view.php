<?php
	include('accountingheader.php');
	if(empty($_POST['customer']) || $_POST['customer'] == 0){
?>
<script>
	window.location.href='accounting';
</script>
<?php
	}
	$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '" . $_POST['customer'] . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
	
	$sql_invoice 		= "SELECT SUM(invoices.value) AS jumlah
						FROM invoices
						JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
						WHERE code_delivery_order.customer_id = '" . $_POST['customer'] . "'";
	$result_invoice 	= $conn->query($sql_invoice);
	$invoice 			= $result_invoice->fetch_assoc();
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-5'>
			<h2><?= $customer['name'] ?></h2>
			<p><?= $customer['address'] ?></p>
			<p><?= $customer['city'] ?></p>
		</div>
		<div class='col-sm-3' style='background-color:#ddd;box-shadow: 10px 10px 8px #888888;padding:20px'>
			<div class='row'>
				<div class='col-sm-4'>
					<h1><i class="fa fa-credit-card-alt" aria-hidden="true"></i></h1>
				</div>
				<div class='col-sm-8'>
				<p><strong>Overall purchases</strong></p>
				Rp. <?= number_format($invoice['jumlah'],2) ?>
				</div>
			</div>
		</div>
		<div class='col-sm-3' style='background-color:#ddd;box-shadow: 10px 10px 8px #888888;padding:20px;margin-left:20px'>
			<div class='row'>
				<div class='col-sm-4'>
					<h1><i class="fa fa-money" aria-hidden="true"></i></h1>
				</div>
				<div class='col-sm-8'>
				<p><strong>Overall payment</strong></p>
				Rp. <?= number_format($invoice['jumlah'],2) ?>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<h3 style='font-family:bebasneue'>Unpaid invoices</h2>
			<table class='table table-bordered'>
				<tr>
					<th>Date</th>
					<th>Invoice number</th>
					<th>Value</th>
<?php
	if($role == 'superadmin'){
?>
					<th></th>
<?php
	}
?>
				</tr>
<?php
	$sql_invoice_detail = "SELECT invoices.id, invoices.date, invoices.name AS invoice_name, invoices.value, invoices.ongkir 
	FROM invoices
	JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
	WHERE code_delivery_order.customer_id = '" . $_POST['customer'] . "' AND invoices.isdone = '0'";
	$result_invoice_detail = $conn->query($sql_invoice_detail);
	while($invoice_detail = $result_invoice_detail->fetch_assoc()){
		 $sql_receivable	= "SELECT SUM(value) AS paid FROM receivable WHERE invoice_id = '" . $invoice_detail['id'] . "'";
		 $result_receivable	= $conn->query($sql_receivable);
		 $receivable		= $result_receivable->fetch_assoc();
		 $paid				= $receivable['paid'];
		 
		$sql_returned = "SELECT SUM(value) AS returned FROM return_invoice_sales WHERE invoice_id = '" . $invoice_detail['id'] . "'";
		$result_returned = $conn->query($sql_returned);
		$returned_row = $result_returned->fetch_assoc();
		$returned = $returned_row['returned'];
?>
				<tr>
					<td><?= date('d M Y',strtotime($invoice_detail['date'])) ?></td>
					<td><?= $invoice_detail['invoice_name'] ?></td>
					<td>Rp. <?= number_format($invoice_detail['value'] + $invoice_detail['ongkir'] - $paid - $returned) ?></td>
<?php
	if($role == 'superadmin'){
?>
					<td><button type='button' class='button_default_dark' onclick='submiting(<?= $invoice_detail['id'] ?>)'>Set done</button></td>
					<form id='hitung_lunas<?= $invoice_detail['id'] ?>' action='invoice_isdone.php' method='POST'>
						<input type='hidden' value='<?= $invoice_detail['id'] ?>' name='id' readonly>
					</form>
<?php
	}
?>
				</tr>
<?php
	}
?>
			</table>
		</div>
	</div>
</div>
<script>
	function submiting(n){
		$('#hitung_lunas' + n).submit();
	};
</script>