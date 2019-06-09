<?php	
	include('financialheader.php');
	print_r($_POST);
	$bank_id = $_POST['bank_id'];
?>
<div class='main'>
	<h2>Reset transaction</h2>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Invoice</th>
			<th>Value</th>
		</tr>
<?php
	$sql_bank = "SELECT * FROM code_bank WHERE id = '" . $bank_id . "'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	echo ('Rp. ' . number_format($bank['value'],2));
	echo '<br>';
	echo ($bank['name']);
	$sql_detail = "SELECT * FROM receivable WHERE bank_id = '" . $bank_id . "'";
	$result_detail = $conn->query($sql_detail);
	while($detail = $result_detail->fetch_assoc()){
?>
		<tr>
			<td><?php
				$sql_invoice = "SELECT * FROM invoices WHERE id = '" . $detail['invoice_id'] . "'";
				$result_invoice = $conn->query($sql_invoice);
				$invoice = $result_invoice->fetch_assoc();
				echo $invoice['name'];
			?></td>
			<td><?= 'Rp. ' . number_format($detail['value'],2) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<form action='reset_transaction_input.php' method='POST'>
		<input type='hidden' value='<?= $bank_id ?>' name='bank_id'>
		<button type='submit' class='btn btn-default'>Reset</button>
	</form>
</div>