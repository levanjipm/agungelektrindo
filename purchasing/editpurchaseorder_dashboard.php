<?php
	include('purchasingheader.php');
?>
<div class="main">
	<div class="container" style="right:50px">
		<h2>Purchase order</h2>
		<h4 style="color:#444">Editing purchase order</h4>
		<hr>
		<br>
	</div>
	<table class="table">
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
		//Showing only purchaseorder made 7 days back//
		//Remember, you cannot edit purchaseorder that has exceed 7 days//
		$sql_po = "SELECT * FROM code_purchaseorder WHERE date > DATE_SUB(NOW(), INTERVAL 7 DAY)";
		$result_po = $conn->query($sql_po);		
		while($row_po = $result_po->fetch_assoc()){
?>
		<tr>
			<td><?= $row_po['date'] ?></td>
			<td><?= $row_po['name'] ?></td>
			<td>
			<?php
				$sql_supplier = "SELECT name,city FROM supplier WHERE id = '" . $row_po['supplier_id'] . "'";
				$result_supplier = $conn->query($sql_supplier);
				while($row_supplier = $result_supplier->fetch_assoc()){
					echo ($row_supplier['name'] . ' - ' . $row_supplier['city']);
				}
			?>
			</td>			
			<td>
				<button type="button" class="btn btn-default" onclick='edit(<?= $row_po['id'] ?>)'>Edit</button>
				<form method='POST' id='form<?= $row_po['id'] ?>' action='editpurchaseorder_do.php'>
					<input type='hidden' value='<?= $row_po['id'] ?>' name='id'>
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