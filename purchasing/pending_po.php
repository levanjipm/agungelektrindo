<?php
	include('purchasingheader.php');	
?>
<div class="main">
	<h2>Pending purchase order</h2>
	<hr>
	<table class="table">
		<tr>
			<th style="width:20%;font-size:1.2em">Date</th>
			<th style="width:30%;font-size:1.2em">PO Number</th>
			<th style="width:30%;font-size:1.2em">Supplier</th>
			<th></th>
		</tr>
<?php
	$sql = "SELECT DISTINCT(purchaseorder_id) FROM purchaseorder_received WHERE status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$po_id = $row['purchaseorder_id'];
		$sql_po = "SELECT name,supplier_id,date FROM code_purchaseorder WHERE id = '" . $po_id . "'";
		$result_po = $conn->query($sql_po);
		while($row_po = $result_po->fetch_assoc()){
			$supplier_id = $row_po['supplier_id'];
			$name = $row_po['name'];
			$date = $row_po['date'];
		}	
?>
		<tr>
			<td><?= $date ?></td>
			<td><?= $name?></td>
			<td>
			<?php
				$sql_supplier = "SELECT name,city FROM supplier WHERE id = '" . $supplier_id . "'";
				$result_supplier = $conn->query($sql_supplier);
				while($row_supplier = $result_supplier->fetch_assoc()){
					echo ($row_supplier['name'] . ' - ' . $row_supplier['city']);
				}
			?>
			</td>
			<td style="width:50%">
				<button type='button' class="btn btn-default" onclick='showdetail(<?= $po_id ?>)' id="more_detail<?= $po_id ?>">+</button>
				<button type='button' class="btn btn-warning" onclick='lessdetail(<?= $po_id ?>)' id="less_detail<?= $po_id ?>" style="display:none" >-</button>			
			</td style="width:50%">
		</tr>
		<tbody style="display:none" id="<?= $po_id ?>">
<?php
		$sql_detail = "SELECT purchaseorder.reference, purchaseorder.quantity AS ordered, purchaseorder_received.id, purchaseorder.id, 
		purchaseorder_received.quantity, purchaseorder_received.status, purchaseorder_received.purchaseorder_id 
		FROM purchaseorder_received	INNER JOIN purchaseorder ON purchaseorder_received.id = purchaseorder.id 
		WHERE purchaseorder_received.status = '0' AND purchaseorder_received.purchaseorder_id = '" . $po_id . "'";
		$result_detail = $conn->query($sql_detail);
		while($row_detail = $result_detail->fetch_assoc()){
			$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row_detail['reference'] . "'";
			$result_item = $conn->query($sql_item);
			while($row_item = $result_item->fetch_assoc()){
				$description = $row_item['description'];
			}	
?>
		<tr>
			<td><?= $row_detail['reference'] ?></td>
			<td><?=  $description ?></td>
			<td><?= $row_detail['ordered'] - $row_detail['quantity'] . ' out of ' . $row_detail['ordered'] . ' uncompleted' ?></td>
		</tr>
<?php
		}
?>
		</tbody>
<?php
	}
?>
	</table>
</div>
<script>
	function showdetail(n){
		$("#" + n).show();
		$("#less_detail" + n).show();
		$("#more_detail" + n).hide();
	}
	function lessdetail(n){
		$("#" + n).hide();
		$("#less_detail" + n).hide();
		$("#more_detail" + n).show();
	}
</script>
	