<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	$supplier_id			= (int) $_GET['id'];
	
	$sql_supplier 			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier 		= $conn->query($sql_supplier);
	$supplier 				= $result_supplier->fetch_assoc();
	if(!$result_supplier || empty($_GET['id'])){
?>
	<script>
		window.location.href='/agungelektrindo/payable_dashboard';
	</script>
<?php
	}
	
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
	
	$sql_invoice 			= "SELECT SUM(value) AS total FROM purchases WHERE supplier_id = '$supplier_id'";
	$result_invoice 		= $conn->query($sql_invoice);
	$invoice 				= $result_invoice->fetch_assoc();
	
	$total_purchase			= $invoice['total'];
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-5'>
			<h2 style='font-family:bebasneue'><?= $supplier_name ?></h2>
			<p style='font-family:museo'><?= $supplier_address ?></p>
			<p style='font-family:museo'><?= $supplier_city ?></p>
		</div>
		<div class='col-sm-3 col-sm-offset-3' style='background-color:#ddd;box-shadow: 10px 10px 8px #888888;padding:20px'>
			<div class='row'>
				<div class='col-sm-4'>
					<h1><i class="fa fa-credit-card-alt" aria-hidden="true"></i></h1>
				</div>
				<div class='col-sm-8'>
				<p><strong>Overall purchases</strong></p>
				Rp. <?= number_format($total_purchase,2) ?>
				</div>
			</div>
		</div>
	</div>
	
	<h3 style='font-family:bebasneue'>Unpaid invoices</h3>
	<p style='font-family:museo' id='value'></p>
	<a href='payable_view.php?id=<?= $supplier_id ?>'>
		<button type='button' class='button_success_dark' title='View report'><i class='fa fa-eye'></i></button>
	</a>
	<br><br>
	
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Invoice number</th>
			<th>Remaining value</th>
			<th></th>
		</tr>
<?php
	$total_debt				= 0;
	$sql_invoice_detail 	= "SELECT id, date, name, value FROM purchases
								WHERE supplier_id = '$supplier_id' AND isdone = '0' ORDER BY date ASC";
	$result_invoice_detail 	= $conn->query($sql_invoice_detail);
	while($invoice_detail 	= $result_invoice_detail->fetch_assoc()){
		$purchase_id		= $invoice_detail['id'];
		$purchase_value		= $invoice_detail['value'];
		$purchase_name		= $invoice_detail['name'];
		
		$sql_payable		= "SELECT SUM(payable.value) as paid FROM payable WHERE purchase_id = '$purchase_id'";
		$result_payable		= $conn->query($sql_payable);
		$payable			= $result_payable->fetch_assoc();
		
		$paid				= $payable['paid'];
		
		$unpaid				= $purchase_value - $paid;
		$total_debt			+= $unpaid;
?>
			<tr>
				<td><?= date('d M Y',strtotime($invoice_detail['date'])) ?></td>
				<td><?= $invoice_detail['name'] ?></td>
				<td>Rp. <?= number_format($unpaid,2) ?></td>
<?php if($role == 'superadmin' || $role == 'admin'){ ?>
				<td><button type='button' class='button_default_dark' onclick='view_purchase(<?= $purchase_id ?>)' title='Set <?= $purchase_name ?> as done'><i class='fa fa-check'></i></button></td>
<?php } ?>
			</tr>
<?php } ?>
	</table>
</div>
<form action='purchase_set_done_dashboard' method='POST' id='purchase_done_form'>
	<input type='hidden' id='purchase_id' name='id'>
</form>
<script>
	function view_purchase(n){
		$('#purchase_id').val(n);
		$('#purchase_done_form').submit();
	};
	
	$('#value').text('Rp. ' + numeral(<?= $total_debt ?>).format('0,0.00'));
</script>