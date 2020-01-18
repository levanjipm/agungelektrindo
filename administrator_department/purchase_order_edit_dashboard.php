<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
?>
<head>
	<title>Edit Purchase Order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p style='font-family:museo'>Editing purchase order</p>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Supplier</th>
				<th>Purchase Order</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
		$sql_po 				= "SELECT DISTINCT(purchaseorder_id) AS po_id FROM purchaseorder WHERE status = '0'";
		$result_po				= $conn->query($sql_po);
		while($purchase_order 	= $result_po->fetch_assoc()){
			$purchase_order_id	= $purchase_order['po_id'];
			
			$sql				= "SELECT id,date,name,supplier_id FROM code_purchaseorder WHERE id = '$purchase_order_id'";
			$result				= $conn->query($sql);
			$row				= $result->fetch_assoc();
			
			$sql_supplier 		= "SELECT name FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
			$result_supplier 	= $conn->query($sql_supplier);
			$supplier			= $result_supplier->fetch_assoc();
			
			$supplier_name		= $supplier['name'];
?>
			<tr>
				<td><?= date('d M Y',strtotime($row['date'])) ?></td>
				<td><?= $row['name'] ?></td>
				<td><?= $supplier_name ?></td>			
				<td>
					<button type="button" class='button_success_dark' onclick='edit_purchase_order(<?= $purchase_order_id ?>)'>
						<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
				</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
</div>
<form method='POST' id='purchase_order_edit_form' action='purchase_order_edit_validation'>
	<input type='hidden' id='purchase_order_id' name='id'>
</form>
<script>
	function edit_purchase_order(n){
		$('#purchase_order_id').val(n);
		$('#purchase_order_edit_form').submit();
	}
</script>