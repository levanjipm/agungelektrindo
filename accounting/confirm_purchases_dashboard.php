<?php
	include('accountingheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Invoice</h2>
	<p>Confirm invoice</p>
	<hr>
	<table class='table table-bordered' id='confirmation'>
		<tr>
			<th>Date</th>
			<th>Invoice name</th>
			<th>Customer</th>
			<th></th>
		</tr>
<?php
	$sql_invoice 			= "SELECT * FROM purchases WHERE isconfirm = '0'";
	$result_invoice 		= $conn->query($sql_invoice);
	while($row_invoice 		= $result_invoice->fetch_assoc()){
		$supplier_id 		= $row_invoice['supplier_id'];
		$sql_supplier		= "SELECT name FROM supplier WHERE id = '" . $supplier_id . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$supplier	 		= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($row_invoice['date'])) ?></td>
			<td><?= $row_invoice['name'] ?></td>
			<td><?= $supplier_name ?></td>
			<td>
				<button type='button' class='button_default_dark' onclick='confirming(<?= $row_invoice['id'] ?>)'>Confirm</button>
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