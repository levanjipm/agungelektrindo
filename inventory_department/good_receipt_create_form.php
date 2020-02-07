<?php
	include('../codes/connect.php');
	
	$purchase_order		= $_POST['purchase_order'];
	$date				= $_POST['date'];
	
	$sql				= "SELECT code_purchaseorder.name, code_purchaseorder.date, supplier.name as supplier_name, supplier.address, supplier.city
							FROM code_purchaseorder
							JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
							WHERE code_purchaseorder.id = '$purchase_order'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$po_name			= $row['name'];
	$po_date			= $row['date'];
	
	$supplier_name		= $row['supplier_name'];
	$supplier_address	= $row['address'];
	$supplier_city		= $row['city'];
?>
	<h2 style='font-family:bebasneue'>Good Receipt</h2>
	<p style='font-family:museo'>Input good receipt</p>
	<hr>
	
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	
	<label>Purchase order</label>
	<p style='font-family:museo'><?= $po_name ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($po_date)) ?></p>
	<form action='good_receipt_create_input' method='POST'>
	<input type='hidden' value='<?= $purchase_order ?>' name='purchase_order_id'>
	
	<label>Received date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	
	<input type='hidden' name='date' value='<?= $date ?>'>
	
	<label>Document number</label>
	<input type='text' class='form-control' name='document' required>
	<br><br>
	
	<table class='table table-bordered'>
		<tr>
			<th style='width:30%'>Reference</th>
			<th style='width:30%'>Description</th>
			<th style='width:10%'>Ordered</th>
			<th style='width:10%'>Received</th>
			<th style='width:20%'>Item Received</th>
		</tr>
<?php
	$sql 					= "SELECT purchaseorder.id, purchaseorder.reference, purchaseorder.quantity, purchaseorder.received_quantity, purchaseorder.status, itemlist.description
								FROM purchaseorder
								JOIN itemlist ON purchaseorder.reference = itemlist.reference
								WHERE purchaseorder.status = '0' AND purchaseorder.purchaseorder_id = '$purchase_order'";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()) {
		$id					= $row['id'];
		$reference			= $row['reference'];
		$quantity			= $row['quantity'];
		$received			= $row['received_quantity'];
		$item_description	= $row['description'];		
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $item_description ?></td>
			<td><?= $quantity ?></td>
			<td><?= $received ?></td>
			<td>
				<input class='form-control' name='qty_receive[<?= $id?>]' max='<?= $quantity - $received?>' min='0' value='0' required>
			</td>
		</tr>
<?php
	}
?>	
	</table>
	<button type='submit' class='button_success_dark'>Submit</button>
	</form>