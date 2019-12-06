<html>
	<head>
		<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
		<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	</head>
	<body>
	<script>
		$(document).ready(function(){
			window.print();
		});
	</script>
	<style>
	body{
		padding:50px;
	}
	@font-face {
		font-family: Bebasneue;
		src: url(../Universal/Font/Bebasneue/BebasNeue.woff);
	}
	</style>
<?php
	$customer_id = $_GET['customer_id'];
	$type = $_GET['type'];
	include('../codes/connect.php');
	$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$sql_bank = "SELECT SUM(value) as swamp FROM code_bank WHERE label = 'CUSTOMER' AND bank_opponent_id = '" . $customer_id . "' AND isdelete = '0' AND isdone = '0'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	$swamp = $bank['swamp'];
?>
<h2 style='font-family:bebasneue'><?= $customer['name'] ?></h2>
<p><?= $customer['address'] ?></p>
<p><?= $customer['city'] ?></p>
<strong>
<?php
	if($type == 1){
		echo ('All receivable');
	} else if($type == 2){
		echo ('< 30 Days');
	} else if($type == 3){
		echo ('30 - 45 days');
	} else if($type == 4){
		echo ('45 - 60 days');
	} else {
		echo ('> 60 days');
	}
?>
</strong>
<hr>
<h3 style='font-family:bebasneue'>Unassigned payment: Rp. <?= number_format($swamp,2) ?></h3>
<table class='table table-hover'>
	<tr>	
		<th>Date</th>
		<th>Invoice name</th>
		<th>Value</th>
		<th>Payment</th>
		<th>Remaining</th>
<?php
	if($type == 1){
		$sql = "SELECT invoices.id, invoices.name, invoices.value, invoices.ongkir, invoices.date
		FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE code_delivery_order.customer_id = '" . $customer_id . "'";
	} else if($type == 2){
		$sql = "SELECT invoices.id, invoices.name, invoices.value, invoices.ongkir, invoices.date
		FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE invoices.isdone = '0' AND invoices.date >= '" . date('Y-m-d',strtotime('-30 days')) . "' AND code_delivery_order.customer_id = '" . $customer_id . "'";
	} else if($type == 3){
		$sql = "SELECT invoices.id, invoices.name, invoices.value, invoices.ongkir, invoices.date
		FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE invoices.isdone = '0' AND invoices.date < '" . date('Y-m-d',strtotime('-30 days')) . "' 
		AND invoices.date > '" . date('Y-m-d',strtotime('-45 days')) . "'
		AND code_delivery_order.customer_id = '" . $customer_id . "'";
	} else if($type == 4){
		$sql = "SELECT invoices.id, invoices.name, invoices.value, invoices.ongkir, invoices.date
		FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE invoices.isdone = '0' AND invoices.date < '" . date('Y-m-d',strtotime('-30 days')) . "' 
		AND invoices.date > '" . date('Y-m-d',strtotime('-45 days')) . "'
		AND code_delivery_order.customer_id = '" . $customer_id . "'";
	} else {
		$sql = "SELECT invoices.id, invoices.name, invoices.value, invoices.ongkir, invoices.date
		FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE  invoices.isdone = '0' AND invoices.date <= '" . date('Y-m-d',strtotime('-60 days')) . "'
		AND code_delivery_order.customer_id = '" . $customer_id . "'";
	}
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_payment = "SELECT SUM(value) as payment FROM receivable WHERE invoice_id = '" . $row['id'] . "'";
		$result_payment = $conn->query($sql_payment);
		$payment = $result_payment->fetch_assoc();
		$paid = ($payment['payment'] == NULL) ? 0: $payment['payment'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td>Rp. <?= number_format($paid,2) ?></td>
			<td>Rp. <?= number_format($row['value'] - $paid,2) ?></td>
		</tr>
<?php
	}
?>