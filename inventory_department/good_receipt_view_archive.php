<?php
	include('../codes/connect.php');
	$code_goodreceipt_id 		= $_GET['id'];
	$sql_first 					= "SELECT * FROM code_goodreceipt WHERE id = '$code_goodreceipt_id'";
	$result_first 				= $conn->query($sql_first);
	$first_row 					= $result_first->fetch_assoc();
				
	$date 						= $first_row['date'];
	$supplier_id 				= $first_row['supplier_id'];
	$document 					= $first_row['document'];
	$po_id 						= $first_row['po_id'];
	
	$sql_code_purchase_order 	= "SELECT name FROM code_purchaseorder WHERE id = '$po_id'";
	$result_code_purchase_order = $conn->query($sql_code_purchase_order);
	$code_purchase_order 		= $result_code_purchase_order->fetch_assoc();
	$po_name 					= $code_purchase_order['name'];
	
	$sql_supplier 				= "SELECT name, address, city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier 			= $conn->query($sql_supplier);
	$supplier 					= $result_supplier->fetch_assoc();
	
	$supplier_name 				= $supplier['name'];
	$supplier_address 			= $supplier['address'];
	$supplier_city 				= $supplier['city'];
?>
<label>Good receipt name</label>
<p style='font-family:museo'><?= $document ?></p>

<label>Good receipt date</label>
<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>

<label>Purchase order</label>
<p style='font-family:museo'><?= $po_name ?></p>

<table class='table table-bordered' style="text-align:center">
	<thead>
		<tr>
			<th style="text-align:center">Referensi</th>
			<th style="text-align:center">Deskripsi</th>
			<th style="text-align:center">Quantity</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$sql 				= "SELECT goodreceipt.quantity, purchaseorder.reference, itemlist.description
								FROM goodreceipt 
								JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
								JOIN itemlist ON purchaseorder.reference = itemlist.reference
								WHERE goodreceipt.gr_id = '$code_goodreceipt_id'";
		$result 			= $conn->query($sql);
		while($row 			= $result->fetch_assoc()){
			$reference		= $row['reference'];
			$quantity		= $row['quantity'];
			$description	= $row['description'];
	?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity,0) ?></td>
		</tr>
	<?php
		}
	?>
	</tbody>
</table>
