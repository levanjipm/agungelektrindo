<?php
	$type = $_POST['type'];
	$customer_id = $_POST['customer_id'];
	include('../codes/connect.php');
	
	$sql_bank = "SELECT SUM(value) as swamp FROM code_bank WHERE label = 'CUSTOMER' AND bank_opponent_id = '" . $customer_id . "' AND isdelete = '0' AND isdone = '0'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	$swamp = $bank['swamp'];
?>
<br>
<a href='show_receivable_customer_print.php?customer_id=<?= $customer_id ?>&type=<?= $type ?>' target='_blank'>
	<button type='button' class='btn btn-success'><i class="fa fa-print" aria-hidden="true"></i> Print</button>
</a>
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