<?php
	include('../codes/connect.php');
	$id						= $_POST['code_gr'];
		
	$sql					= "SELECT code_goodreceipt.document, code_goodreceipt.date, code_purchaseorder.name, supplier.name as supplier_name,
								supplier.address, supplier.city, code_purchaseorder.taxing, code_purchaseorder.date as po_date
								FROM code_goodreceipt 
								JOIN code_purchaseorder ON code_goodreceipt.po_id = code_purchaseorder.id
								JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
								WHERE code_goodreceipt.id = '$id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
			
	$document_name			= $row['document'];
	$po_name				= $row['name'];
	$taxing					= $row['taxing'];
	$date					= $row['date'];
	$purchase_order_name	= $row['name'];
	$purchase_order_date	= $row['po_date'];
	$supplier_name			= $row['supplier_name'];
	$supplier_address		= $row['address'];
	$supplier_city			= $row['city'];
?>
	<label>Good receipt</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	<p style='font-family:museo'><?= $document_name ?></p>

	<label>Purchase order</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($purchase_order_date)) ?></p>
	<p style='font-family:museo'><?= $po_name ?></p>
	
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<hr>
	
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit price</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
<?php
	$total_receipt			= 0;
	$sql_gr					= "SELECT purchaseorder.reference, purchaseorder.unitprice, goodreceipt.quantity, itemlist.description
								FROM goodreceipt 
								JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
								JOIN itemlist ON itemlist.reference = purchaseorder.reference
								WHERE gr_id = '$id'";
	$result_gr				= $conn->query($sql_gr);
	while($gr				= $result_gr->fetch_assoc()){
		$reference			= $gr['reference'];
		$quantity			= $gr['quantity'];
		$unit_price			= $gr['unitprice'];
		$item_description	= $gr['description'];
		
		if($taxing 			== 1){
			$unit_price		= $unit_price * 10 / 11;
		}
		
		$total_price		= $unit_price * $quantity;
			
		$total_receipt		+= $total_price;
		
	
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $item_description ?></td>
				<td><?= number_format($quantity) ?></td>
				<td>Rp. <?= number_format($unit_price,2) ?></td>
				<td >Rp. <?= number_format($total_price,2) ?></td>
			</tr>
<?php
	}
?>
		</tbody>
		<tr>
			<td colspan='3'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($total_receipt,2) ?></td>
		</tr>
<?php
	if($taxing		== 1){
?>
		<tr>
			<td colspan='3'></td>
			<td>Tax</td>
			<td>Rp. <?= number_format($total_receipt * 10 / 100,2) ?></td>
		</tr>
		<tr>
			<td colspan='3'></td>
			<td>Grand Total</td>
			<td>Rp. <?= number_format($total_receipt * 11 / 10,2) ?></td>
		</tr>
<?php
	}
?>
	</table>
	