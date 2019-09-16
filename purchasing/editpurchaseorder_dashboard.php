<?php
	include('purchasingheader.php');
?>
<div class="main">
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p>Editing purchase order</p>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Supplier</th>
				<th>Purchase Order</th>
				<th>Properties</th>
			</tr>
		</thead>
		<tbody>
<?php
		$sql_po 	= "SELECT DISTINCT(purchaseorder_id) AS po_id FROM purchaseorder WHERE status = '0'";
		$result_po	= $conn->query($sql_po);
		while($purchase_order = $result_po->fetch_assoc()){
			$purchase_order_id	= $purchase_order['po_id'];
			
			$sql	= "SELECT id,date,name,supplier_id FROM code_purchaseorder WHERE id = '$purchase_order_id'";
			$result	= $conn->query($sql);
			$row	= $result->fetch_assoc();
?>
			<tr>
				<td><?= date('d M Y',strtotime($row['date'])) ?></td>
				<td><?= $row['name'] ?></td>
				<td>
				<?php
					$sql_supplier 		= "SELECT name,city FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
					$result_supplier 	= $conn->query($sql_supplier);
					$supplier			= $result_supplier->fetch_assoc();
					echo ($supplier['name'] . ' - ' . $supplier['city']);
				?>
				</td>			
				<td>
					<button type="button" class="button_default_dark" onclick='edit(<?= $purchase_order_id ?>)'>Edit</button>
					<form method='POST' id='form<?= $purchase_order_id ?>' action='editpurchaseorder_do'>
						<input type='hidden' value='<?= $purchase_order_id ?>' name='id'>
					</form>
				</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
</div>
<script>
	function edit(n){
		$('#form' + n).submit();
	}
</script>