<?php
	include('accountingheader.php');
	//Confirming invoice//
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Invoice</h2>
	<p>Confirm invoice</p>
	<hr>
	<table class='table' id='confirmation'>
		<tr>
			<th>Date</th>
			<th>Invoice name</th>
			<th>Customer</th>
			<th></th>
		</tr>
<?php
	$sql_invoice = "SELECT * FROM purchases WHERE isconfirm = '0'";
	$result_invoice = $conn->query($sql_invoice);
	while($row_invoice = $result_invoice->fetch_assoc()){
		$supplier_id = $row_invoice['supplier_id'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($row_invoice['date'])) ?></td>
			<td><?= $row_invoice['name'] ?></td>
			<td>
			<?php
				$sql_customer = "SELECT name FROM supplier WHERE id = '" . $supplier_id . "'";
				$result_customer = $conn->query($sql_customer);
				$row_customer = $result_customer->fetch_assoc();
				echo ($row_customer['name']);
			?>
			</td>
			<td>
				<button type='button' class='btn btn-default' onclick='confirming(<?= $row_invoice['id'] ?>)'>Confirm</button>
			</td>
			<form id='form<?= $row_invoice['id'] ?>' method='POST' action='confirm_purchases.php'>
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