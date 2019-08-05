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
	$sql_do = "SELECT name,so_id FROM code_delivery_order WHERE id = '" . $initial['do_id'] . "'";
	$result_do = $conn->query($sql_do);
	$do = $result_do->fetch_assoc();
	
	$sql_customer = "SELECT name,city FROM customer WHERE id = '" . $initial['customer_id'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
?>
	<div class='main'>
	<h2><?= $do['name'] ?></h2>
	<p><strong><?= $customer['name'] ?></strong></p>
	<p><?= $customer['city'] ?></p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Item name</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$harga_total = 0;
	$sql_return = "SELECT * FROM sales_return WHERE return_code = '" . $return_id . "'";
	$result_return = $conn->query($sql_return);
	while($return = $result_return->fetch_assoc()){
		$sql_so = "SELECT price,quantity FROM sales_order WHERE so_id = '" . $do['so_id'] . "' AND reference = '" . $return['reference'] . "'";
		$result_so = $conn->query($sql_so);
		$so = $result_so->fetch_assoc();
		$harga_total = $harga_total + ($so['price'] * $return['quantity']);
?>
		<tr>
			<td><?= $return['reference'] ?></td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $return['reference'] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td><?= $return['quantity'] ?></td>
<?php
	}
?>
	</table>
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
	$sql = "SELECT invoices.id, invoices.date, invoices.name, invoices.value FROM invoices
	JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
	WHERE invoices.isdone = '0' 
	AND code_delivery_order.customer_id = '" . $initial['customer_id'] . "'";
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
	</table>
	<input type='hidden' value='<?= $harga_total ?>' name='harga_total'>
	<input type='hidden' value='<?= $return_id ?>' name='return_id'>
	<input type='hidden' value='<?= $i ?>' name='i'>
	<button type='submit' class='btn btn-default'>Next</button>
	</form>
</div>
<?php
	}
?>