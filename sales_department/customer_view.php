<?php
	include('salesheader.php');
	$customer_id		= $_POST['customer'];
	
	if(empty($customer_id) || $customer_id == 0){
		header('location:receivable_dashboard.php');
	}
	
	$sql_customer 		= "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	$customer_address	= $customer['address'];
	$customer_city		= $customer['city'];
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-5'>
			<h2><?= $customer_name ?></h2>
			<p><?= $customer_address ?></p>
			<p><?= $customer_city ?></p>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Unpaid invoices</h2>
			<table class='table table-bordered'>
				<tr>
					<th>Date</th>
					<th>Invoice number</th>
					<th>Value</th>
				</tr>
<?php
	$sql_invoice_detail 	= "SELECT invoices.id, invoices.date, invoices.name AS invoice_name, invoices.value, invoices.ongkir FROM invoices
							JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
							WHERE code_delivery_order.customer_id = '" . $customer_id . "' AND invoices.isdone = '0'";
	$result_invoice_detail 	= $conn->query($sql_invoice_detail);
	while($invoice_detail 	= $result_invoice_detail->fetch_assoc()){
?>
				<tr>
					<td><?= date('d M Y',strtotime($invoice_detail['date'])) ?></td>
					<td><?= $invoice_detail['invoice_name'] ?></td>
					<td>Rp. <?= number_format($invoice_detail['value'] + $invoice_detail['ongkir']) ?></td>
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