<?php
	include('../codes/connect.php');
?>
<h2 style='font-family:bebasneue'>Items need to be bought</h2>
<hr>
<table class='table table-bordered'>
	<tr>
		<th>Reference</th>
		<th>Description</th>
		<th>Quantity needs to be ordered</th>
	</tr>
<?php
$sql_pending_so 		= "SELECT reference, quantity, sent_quantity
							FROM sales_order 
							WHERE status = '0'";
$result_pending_so 		= $conn->query($sql_pending_so);
while($pending_so 		= $result_pending_so->fetch_assoc()){
	$reference	 		= $pending_so['reference'];
	$quantity			= $pending_so['quantity'];
	$quantity_sent 		= $pending_so['sent_quantity'];
	$pending_so			= $quantity - $quantity_sent;
	
	$sql_po	 			= "SELECT SUM(quantity) as quantity, SUM(received_quantity) as received_quantity FROM purchaseorder WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND status = '0' GROUP BY reference";
	$result_po 			= $conn->query($sql_po);
	$row_po 			= $result_po->fetch_assoc();
	
	$quantity_ordered	= $row_po['quantity'];
	$quantity_received	= $row_po['received_quantity'];
	
	$pending_purchase_order	= $quantity_ordered - $quantity_received;
	
	$sql_stock 			= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY ID DESC LIMIT 1";
	$result_stock 		= $conn->query($sql_stock);
	$row_stock 			= $result_stock->fetch_assoc();

	$stock 				= $row_stock['stock'];
	
	if($pending_so > $pending_purchase_order + $stock){
		$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
?>
	<tr>
		<td><?= $reference ?>
			<input type='hidden' value='<?= $reference ?>' name='reference[<?= $x ?>]'>
		</td>
		<td><?= $description ?></td>
		<td><?= $pending_so ?>
			<input type='hidden' value='<?= $pending_so ?>' name='quantity[<?= $x ?>]'>
		</td>
	</tr>
<?php
	}
}
?>
</table>
