<?php
	include('../codes/connect.php');
	$purchaseorder_id	= $_POST['purchaseorder_id'];
	$next_po			= $_POST['next_view'];
	$prev_po			= $_POST['prev_view'];
	
	$sql				= "SELECT name, supplier_id FROM code_purchaseorder WHERE id = '$purchaseorder_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$purchaseorder_name	= $row['name'];
	$supplier_id		= $row['supplier_id'];
	
	$sql_supplier		= "SELECT name FROM supplier WHERE id = '$supplier_id'";
	$result_supplier	= $conn->query($sql_supplier);
	$supplier			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
?>
<h2 style='font-family:bebasneue'><?= $purchaseorder_name ?></h2>
<h4 style='font-family:bebasneue'><?= $supplier_name ?></h4>
<table class='table table-bordered'>
	<tr>
		<th>Reference</th>
		<th>Description</th>
		<th>Ordered</th>
		<th>Pending</th>
	</tr>
<?php
	$sql_po					= "SELECT reference,quantity,received_quantity FROM purchaseorder WHERE purchaseorder_id = '$purchaseorder_id'";
	$result_po				= $conn->query($sql_po);
	while($po				= $result_po->fetch_assoc()){
		$reference			= $po['reference'];
		$quantity			= $po['quantity'];
		$received_quantity	= $po['received_quantity'];
		
		$pending			= $quantity - $received_quantity;
		
		$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$description		= $item['description'];
?>
	<tr>
		<td><?= $reference ?></td>
		<td><?= $description ?></td>
		<td><?= $quantity ?></td>
		<td><?= $pending ?></td>
	</tr>
<?php
	}
?>
</table>
<br>
<button type='button' class='button_default_dark' onclick='change_slide(<?= $prev_po ?>)'>Previous</button>
<button type='button' class='button_success_dark' onclick='change_slide(<?= $next_po ?>)'>Next</button>