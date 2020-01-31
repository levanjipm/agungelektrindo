<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	$customer_id			= $_GET['id'];
	$sql_customer			= "SELECT id FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer_count			= mysqli_num_rows($result_customer);
	$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '$customer_id'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	$customer_address	= $customer['address'];
	$customer_city		= $customer['city'];
	
	$sql_invoice 		= "SELECT SUM(invoices.value) AS jumlah
							FROM invoices
							JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
							WHERE code_delivery_order.customer_id = '$customer_id'";
	$result_invoice 	= $conn->query($sql_invoice);
	$invoice 			= $result_invoice->fetch_assoc();
?>
<head>
	<title>View <?= $customer_name ?></title>
</head>
<div class='main'>
	<div class='row'>
		<div class='col-sm-5'>
			<h2 style='font-family:bebasneue'><?= $customer_name ?></h2>
			<p><?= $customer_address ?></p>
			<p><?= $customer_city ?></p>
		</div>
		<div class='col-sm-3 col-sm-offset-3' style='background-color:#ddd;box-shadow: 10px 10px 8px #888888;padding:20px'>
			<div class='row'>
				<div class='col-sm-4'>
					<h1><i class="fa fa-credit-card-alt" aria-hidden="true"></i></h1>
				</div>
				<div class='col-sm-8'>
				<p><strong>Overall purchases</strong></p>
				<p>Rp. <?= number_format($invoice['jumlah'],2) ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<h3 style='font-family:bebasneue'>Unpaid invoices</h2>
			<p id='unpaid_invoice_total'></p>
			<a href='receivable_view.php?id=<?= $customer_id ?>'>
				<button type='button' class='button_success_dark' id='view_receivable_table_button' title='View report'><i class='fa fa-eye'></i></button>
			</a>
			<br><br>
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
	$total_unpaid			= 0;
	$sql_invoice_detail 	= "SELECT invoices.id, invoices.date, invoices.name AS invoice_name, invoices.value, invoices.ongkir 
								FROM invoices
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.isdone = '0'";
	$result_invoice_detail 	= $conn->query($sql_invoice_detail);
	while($invoice_detail 	= $result_invoice_detail->fetch_assoc()){
		 $sql_receivable	= "SELECT SUM(value) AS paid FROM receivable WHERE invoice_id = '" . $invoice_detail['id'] . "'";
		 $result_receivable	= $conn->query($sql_receivable);
		 $receivable		= $result_receivable->fetch_assoc();
		 $paid				= $receivable['paid'];
?>
				<tr>
					<td><?= date('d M Y',strtotime($invoice_detail['date'])) ?></td>
					<td><?= $invoice_detail['invoice_name'] ?></td>
					<td>Rp. <?= number_format($invoice_detail['value'] + $invoice_detail['ongkir'] - $paid,2) ?></td>
<?php
	if($role == 'superadmin'){
?>
					<td><button type='button' class='button_default_dark' onclick='submiting(<?= $invoice_detail['id'] ?>)'>Set done</button></td>
<?php
	}
?>
				</tr>
<?php
		$total_unpaid		+= $invoice_detail['value'] + $invoice_detail['ongkir'] - $paid;
	}
?>
			</table>
		</div>
	</div>
</div>
<form id='set_invoice_done_form' action='invoice_set_done_dashboard' method='POST'>
	<input type='hidden' name='id' id='invoice_id' readonly>
</form>
<script>
	$(document).ready(function(){
		$('#unpaid_invoice_total').html('Rp. ' + numeral(<?= $total_unpaid ?>).format('0,0.00'));
	});
	function submiting(n){
		$('#invoice_id').val(n);
		$('#set_invoice_done_form').submit();
	};
</script>