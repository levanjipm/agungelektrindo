<?php
	include('accountingheader.php');
	//Confirming invoice//
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Invoice</h2>
	<p>Confirm invoice</p>
	<hr>
	<table class='table' id='confirmation'>
		<tr>
			<th>Date</th>
			<th>Invoice name</th>
			<th>Customer</th>
			<th>Confirm</th>
		</tr>
<?php
	$sql_invoice = "SELECT invoices.id,invoices.date, invoices.name, code_delivery_order.customer_id FROM invoices 
	JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
	WHERE invoices.isconfirm = '0'";
	$result_invoice = $conn->query($sql_invoice);
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
				<button type='button' class='btn btn-default' onclick='confirming(<?= $row_invoice['id'] ?>)'>Confirm</button>
			</td>
			<form id='form<?= $row_invoice['id'] ?>' method='POST' action='confirm_invoice.php'>
				<input type='hidden' value='<?= $row_invoice['id'] ?>' name='id'>
			</form>
		</tr>
<?php
	}
?>
	</table>
</div>
<script>
	function confirming(n){
		var id = n;
		$('#form' + id).submit();
	}
</script>