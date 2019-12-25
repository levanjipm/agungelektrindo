<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Receivable report</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Receivable</h2>
	<p style='font-family:museo'>Create report</p>
	<hr>
	<label>Search customer</label>
	<input type='text' class='form-control' id='search_customer_bar'>
	<br>
	<table class='table table-bordered'>
		<tr>
			<th>Customer</th>
			<th>Total receivable</th>
			<th>< 30 days</th>
			<th>30 - 45 days</th>
			<th>45 - 60 days</th>
			<th>More than 60 days</th>
			<th></th>
		</tr>
	
<?php
	$customer_array			= [];
	$sql					= "SELECT id FROM customer";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		array_push($customer_array, $row['id']);
	};
	
	foreach($customer_array as $customer){
		$customer_text		= strval($customer);
		$sql_invoice		= "SELECT code_delivery_order.customer_id, invoices.id FROM invoices 
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								WHERE invoices.isdone = '0' AND code_delivery_order.customer_id = '$customer'";
		$result_invoice		= $conn->query($sql_invoice);
		while($invoice		= $result_invoice->fetch_assoc()){
			$customer_array[$customer_text][] = $invoice['id'];
		}
		
		next($customer_array);
	}
	
	print_r($customer_array);
?>
</div>
<tr>
	<td><?= $row['name'] ?></td>
	<td>Rp. <?= number_format($total,2) ?></td>
	<td>Rp. <?= number_format($row_30['less_than_30'],2) ?></td>
	<td>Rp. <?= number_format($row_45['less_than_45'],2) ?></td>
	<td>Rp. <?= number_format($row_60['less_than_60'],2) ?></td>
	<td>Rp. <?= number_format($nunggak['nunggak'],2) ?></td>
	<td>
		<a href='receivable_report_customer_report.php?customer_id=<?= $row['customer_id'] ?>' style='text-decoration:none'>
			<button type='button' class='button_default_dark' title='Report <?= $row['name'] ?>' id='receivable_report(<?= $row['customer_id'] ?>)'>
				<i class="fa fa-flag-o" aria-hidden="true"></i>
			</button>
		</a>
	</td>
</tr>