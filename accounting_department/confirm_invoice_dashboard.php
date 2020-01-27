<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Confirm sales invoice</title>
</head>
<script>
	$('#sales_invoice_side').click();
	$('#confirm_invoice_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Invoice</h2>
	<p style='font-family:museo'>Confirm invoice</p>
	<hr>
<?php
	$sql_invoice = "SELECT invoices.id,invoices.date, invoices.name, code_delivery_order.customer_id FROM invoices 
					JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
					WHERE invoices.isconfirm = '0' AND code_delivery_order.company = 'AE'";
	$result_invoice = $conn->query($sql_invoice);
	if(mysqli_num_rows($result_invoice) > 0){
?>
	<table class='table' id='confirmation'>
		<tr>
			<th>Date</th>
			<th>Invoice name</th>
			<th>Customer</th>
			<th></th>
		</tr>
<?php
	
	while($row_invoice = $result_invoice->fetch_assoc()){
		$customer_id = $row_invoice['customer_id'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($row_invoice['date'])); ?></td>
			<td><?= $row_invoice['name'] ?></td>
			<td>
			<?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
				$result_customer = $conn->query($sql_customer);
				$row_customer = $result_customer->fetch_assoc();
				echo ($row_customer['name']);
			?>
			</td>
			<td>
				<button type='button' class='button_default_dark' onclick='confirming(<?= $row_invoice['id'] ?>)'>Confirm</button>
			</td>
		</tr>
<?php
	}
?>
	</table>
<form action='confirm_invoice' id='confirm_invoice_form' method='POST'>
	<input type='hidden' id='invoice_id' name='id'>
</form>
<script>
	function confirming(n){
		$('#invoice_id').val(n);
		$('#confirm_invoice_form').submit();
	}
</script>
<?php
	} else {
?>
	<p style='font-family:museo'>There is no invoice to be confirmed</p>
<?php
	}
?>
</div>