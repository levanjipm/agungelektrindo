<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
	
	$purchase_order_id		= $_GET['id'];
	
	$sql				= "SELECT code_purchaseorder.name, code_purchaseorder.date, supplier.name as supplier_name, supplier.address, supplier.city,
								closed_purchaseorder.closed_date
								FROM code_purchaseorder 
								LEFT JOIN closed_purchaseorder ON closed_purchaseorder.purchaseorder_id = code_purchaseorder.id
								JOIN supplier ON supplier.id = code_purchaseorder.supplier_id
								WHERE code_purchaseorder.id = '$purchase_order_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$purchase_order_name	= $row['name'];
	$purchase_order_date	= $row['date'];
	$supplier_name			= $row['supplier_name'];
	$supplier_address		= $row['address'];
	$supplier_city			= $row['city'];
?>
<head>
	<title><?= $purchase_order_name  . ' ' . $supplier_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p style='font-family:museo'>View purchase order detail</p>
	<hr>
	
	<label>Purchase order detail</label>
	<p style='font-family:museo'><?= $purchase_order_name ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($purchase_order_date)) ?></p>
	
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Price list</th>
			<th>Discount</th>
			<th>Unit price</th>
			<th>Total price</th>
		</tr>
<?php
	$purchase_order_value	= 0;
	$sql		= "SELECT purchaseorder.reference, purchaseorder.quantity, purchaseorder.price_list, purchaseorder.unitprice, itemlist.description
					FROM purchaseorder JOIN itemlist ON purchaseorder.reference = itemlist.reference
					WHERE purchaseorder.purchaseorder_id = '$purchase_order_id'";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$description	= $row['description'];
		$price_list		= $row['price_list'];
		$unit_price		= $row['unitprice'];
		$discount		= 100 * (1 - $unit_price / $price_list);
		$total_price	= $unit_price * $quantity;
		
		$purchase_order_value += $total_price;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
			<td>Rp. <?= number_format($price_list,2) ?></td>
			<td><?= number_format($discount,2) ?>%</td>
			<td>Rp. <?= number_format($unit_price,2) ?></td>
			<td>Rp. <?= number_format($total_price,2) ?></td>
		</tr>
<?php
	}
?>
		<tr>
			<td colspan='5'></td>
			<td>Total</td>
			<td>Rp. <?=number_format($purchase_order_value,2) ?></td>
		</tr>
	</table>
	
	<label>Delivery history</label>
<?php
	$sql		= "SELECT code_goodreceipt.document, code_goodreceipt.date, users.name 
					FROM code_goodreceipt 
					JOIN users ON code_goodreceipt.created_by = users.id
					WHERE code_goodreceipt.po_id = '$purchase_order_id'";
	$result		= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There is no history of receiving from this purchase order</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Document</th>
			<th>Received by</th>
		</tr>
<?php
	while($row	= $result->fetch_assoc()){
		$document		= $row['document'];
		$date			= $row['date'];
		$created_by		= $row['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $document ?></td>
			<td><?= $created_by ?></td>
		</tr>
<?php
	}
?>
	</table>
<?php
	}
?>
</div>