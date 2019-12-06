<h3 style='font-family:bebasneue'>Confirm good receipt</h3>
<?php
	include("../codes/connect.php");
	$gr_id 		= $_GET['term'];
	$sql 		= "SELECT document, supplier_id, date FROM code_goodreceipt WHERE id = '" . $gr_id . "'";
	$result 	= $conn->query($sql);
	$code		= $result->fetch_assoc();
	$document 	= $code['document'];
	
	$sql_supplier		= "SELECT name, address, city FROM supplier WHERE id = '" . $code['supplier_id'] . "'";
	$result_supplier	= $conn->query($sql_supplier);
	$supplier			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
?>
<label>Date</label>
<p><?= date('d M Y',strtotime($code['date'])) ?></p>
<label>Supplier</label>
<p><?= $supplier_name ?></p>
<p><?= $supplier_address ?></p>
<p><?= $supplier_city ?></p>
<label>Document name</label>
<p><?= $document ?></p>
<table class='table table-bordered'>
	<tr>
		<th>Reference</th>
		<th>Description</th>
		<th>Quantity</th>
	</tr>
<?php
	$sql_good_receipt		 = "SELECT received_id, quantity FROM goodreceipt WHERE gr_id = '" . $gr_id . "'";
	$result_good_receipt	 = $conn->query($sql_good_receipt);
	while($good_receipt = $result_good_receipt->fetch_assoc()){
		$sql_received 		= "SELECT reference FROM purchaseorder WHERE id = '" . $good_receipt['received_id'] . "'";
		$result_received 	= $conn->query($sql_received);
		$received			= $result_received->fetch_assoc();
		
		$reference			= $received['reference'];
		$quantity			= $good_receipt['quantity'];
		$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$item_description	= $item['description'];
?>
	<tr>
		<td><?= $received['reference'];	?></td>
		<td><?= $item_description	?></td>
		<td><?= $good_receipt['quantity']?></td>
	</tr>
<?php
	}
?>
</table>
<div style='text-align:center'>
	<button type='button' class='button_danger_dark' onclick='delete_good_receipt(<?= $gr_id ?>)'>Delete</button>
	<button type='button' class='button_success_dark' onclick='confirm_goods_receipt(<?= $gr_id ?>)'>Confirm</button>
</div>