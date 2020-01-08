<?php
	include('../codes/connect.php');
	$invoice_id				= $_POST['invoice_id'];
	$sql_code				= "SELECT * FROM purchases WHERE id = '$invoice_id'";
	$result_code			= $conn->query($sql_code);
	$code					= $result_code->fetch_assoc();
	
	$invoice_date			= $code['date'];
	$faktur					= $code['faktur'];
	$document_name			= $code['name'];
	$document_description	= $code['keterangan'];
	$document_value			= $code['value'];
	
	$supplier_id			= $code['supplier_id'];
	$sql_supplier			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier		= $conn->query($sql_supplier);
	$supplier				= $result_supplier->fetch_assoc();
	
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
	
	$name					= $code['name'];
	$faktur					= $code['faktur'];
	
	$sql_good_receipt		= "SELECT id FROM code_goodreceipt WHERE isinvoiced = '1' AND invoice_id = '$invoice_id'";
	$result_good_receipt	= $conn->query($sql_good_receipt);
	if(mysqli_num_rows($result_good_receipt) == 0){
		$invoice_type		= "EMPTY";
	} else {
		$invoice_type		= "NORMAL";
	}
	
	if($invoice_type		== "NORMAL"){
		$good_receipt		= mysqli_num_rows($result_good_receipt);
?>
	<label>Date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($invoice_date)) ?></p>
	
	<label>Document name</label>
	<p style='font-family:museo'><?= $document_name ?></p>
	
<?php
	if($faktur				!= ''){
?>
	<label>Tax document</label>
	<p style='font-family:museo'><?= $faktur ?></p>
<?php
	}
?>

	<label>Supplier data</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	
	<label>Good receipt</label>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Document</th>
		</tr>
<?php
		$sql_good_receipt		= "SELECT id, date, document FROM code_goodreceipt WHERE invoice_id = '$invoice_id'";
		$result_good_receipt	= $conn->query($sql_good_receipt);
		while($good_receipt		= $result_good_receipt->fetch_assoc()){
			$gr_date			= $good_receipt['date'];
			$gr_id				= $good_receipt['id'];
			$gr_document		= $good_receipt['document'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($gr_date)) ?></td>
			<td><?= $gr_document ?></td>
		</tr>
<?php
		}
?>
	</table>
	
	<label>Items</label>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Total price</th>
		</tr>
<?php
		$invoice_value			= 0;
		$sql_good_receipt		= "SELECT id, date, document FROM code_goodreceipt WHERE invoice_id = '$invoice_id'";
		$result_good_receipt	= $conn->query($sql_good_receipt);
		while($good_receipt		= $result_good_receipt->fetch_assoc()){
			$gr_id				= $good_receipt['id'];
			$sql				= "SELECT goodreceipt.id, purchaseorder.reference, goodreceipt.quantity, itemlist.description, goodreceipt.billed_price FROM goodreceipt 
									JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
									JOIN itemlist ON purchaseorder.reference = itemlist.reference
									WHERE goodreceipt.gr_id = '$gr_id'";
			$result				= $conn->query($sql);
			while($row			= $result->fetch_assoc()){
				$detail_id		= $row['id'];
				$reference		= $row['reference'];
				$description	= $row['description'];
				$quantity		= $row['quantity'];
				$price			= $row['billed_price'];
				$gr_price		= $price * $quantity;
				
				$invoice_value	+= $gr_price;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
			<td>Rp. <?= number_format($price,2) ?></td>
			<td>Rp. <?= number_format($gr_price,2) ?></td>
		</tr>
<?php
			}
		}
?>
		<tr>
			<td colspan='3'></td>
			<td>Grand total</td>
			<td>Rp. <?= number_format($invoice_value,2) ?></td>
		</tr>
	</table>
</div>
<?php
	} else {
?>
	<label>Date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($invoice_date)) ?></p>
	
	<label>Document name</label>
	<p style='font-family:museo'><?= $document_name ?></p>
	
<?php
		if($faktur				!= ''){
?>
	<label>Tax document</label>
	<p style='font-family:museo'><?= $faktur ?></p>
<?php
		}
?>
	<label>Description</label>
	<p style='font-family:museo'><?= $document_description ?></p>
	
	<label>Value</label>
	<p style='font-family:museo'>Rp. <?= number_format($document_value,2) ?></p>
<?php
	}
?>
