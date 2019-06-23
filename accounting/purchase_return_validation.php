<?php
	include('accountingheader.php');
	if(empty($_POST['id'])){
		header('location:accounting.php');
		die();
	}
	$return_id = $_POST['id'];
	$sql_initial = "SELECT do_id,customer_id,method,isassign FROM code_sales_return WHERE id = '" . $return_id . "'";
	$result_initial = $conn->query($sql_initial);
	$initial = $result_initial->fetch_assoc();
	
	if($initial['isassign'] == 1){
?>
		<script>
			window.location.replace("accounting.php");
		</script>
<?php
	}
	else {
	
	$sql_customer = "SELECT name,city FROM supplier WHERE id = '" . $initial['customer_id'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
?>
	<div class='main'>
	<p><strong><?= $customer['name'] ?></strong></p>
	<p><?= $customer['city'] ?></p>
	<hr>
<?php
	$harga_total = 0;
	$sql_return = "SELECT * FROM purchase_return WHERE code_id = '" . $return_id . "'";
	$result_return = $conn->query($sql_return);
	while($return = $result_return->fetch_assoc()){
		$harga_total = $harga_total + ($return['price'] * $return['quantity']);
	}
?>
	Rp. <?= number_format($harga_total,2) ?>
	<br>
	<form action='sales_return_input.php' method='POST'>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Invoice name</th>
			<th>Value</th>
			<th></th>
		</tr>
<?php
	$i = 1;
	$sql = "SELECT * FROM purchases WHERE isdone = '0' AND supplier_id = '" . $initial['customer_id'] . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$invoice_id = $row['id'];
		$sql_return = "SELECT SUM(value) AS jumlah_retur FROM return_invoice_sales WHERE invoice_id = '" . $invoice_id . "'";
		$result_return = $conn->query($sql_return);
		$return = $result_return->fetch_assoc();
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format(($row['value'] - $return['jumlah_retur']),2) ?></td>
			<td>
				<input type='hidden' value='<?= $row['value'] ?>' name='value<?= $i ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='invoice<?= $i ?>'>
				<input type='checkbox' name='check_<?= $i ?>'>
			</td>
		</tr>
<?php
	$i++;
	}
?>
	<table>
	<input type='hidden' value='<?= $harga_total ?>' name='harga_total'>
	<input type='hidden' value='<?= $return_id ?>' name='return_id'>
	<input type='hidden' value='<?= $i ?>' name='i'>
	<button type='submit'>Next</button>
</div>
</div>
<?php
	}
?>