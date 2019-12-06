<?php
	include('accountingheader.php');
	$invoices_array = $_POST['invoices'];
	$jumlah = count($invoices_array);
	$customer_id = $_POST['customer'];
	$document = mysqli_real_escape_string($conn,$_POST['counter_bill_name']);
	
	$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$total = 0;
	$ongkir = 0;
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Counter Bill</h2>
	<p>Create counter bill</p>
	<hr>
	<h3 style='font-family:bebasneue'><?= $customer['name'] ?></h3>
	<p><?= $document ?></p>
	<br><br>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Value</th>
			<th>Delivery charge</th>
		</tr>
		<form action='counter_bill_input.php' method='POST' id='counter_bill_form'>
		<input type='hidden' value='<?= $document ?>' name='document'>
<?php
	for($i = 0; $i < $jumlah; $i++){
		$sql = "SELECT * FROM invoices WHERE id = '" . $invoices_array[$i] . "'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$total = $total + $row['value'];
		$ongkir = $ongkir + $row['ongkir'];
?>
		<tr>
			<input type='hidden' value='<?= $row['id'] ?>' name='invoice[<?= $i ?>]'>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td>Rp. <?= number_format($row['ongkir'],2) ?></td>
		</tr>
<?php
	}
?>
		<input type='hidden' value='<?= $customer_id ?>' name='customer'>
		</form>
		<tr>
			<td style='background-color:white'></td>
			<td><strong>Total</strong></td>
			<td>Rp. <?= number_format($total,2) ?></td>
			<td>Rp. <?= number_format($ongkir,2) ?></td>
		</tr>
	</table>
	<br><br>
	<button type='button' class='btn btn-secondary' id='submit_bill'>Submit</button>
</div>
<script>
	$('#submit_bill').click(function(){
		$('#counter_bill_form').submit();
	})
</script>