<?php
	include('accountingheader.php');
	if(empty($_POST['customer']) || $_POST['customer'] == 0){
		header('location:receivable_dashboard.php');
	}
	$sql_customer = "SELECT * FROM customer WHERE id = '" . $_POST['customer'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$sql_invoice = "SELECT SUM(value) AS jumlah FROM invoices WHERE customer_id = '" . $_POST['customer'] . "'";
	$result_invoice = $conn->query($sql_invoice);
	$invoice = $result_invoice->fetch_assoc();
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
			<h2>Unpaid invoices</h2>
			<table class='table'>
				<tr>
					<th>Date</th>
					<th>PO Number</th>
					<th>Delivery order</th>
					<th>Items</th>
				</tr>
		</div>
	</div>
</div>