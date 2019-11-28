<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');

	$supplier_id		= $_POST['supplier_id'];
	$sql_supplier		= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier	= $conn->query($sql_supplier);
	$supplier			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
?>
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #printable * {
    visibility: visible;
  }
  
  #printable {
    position: absolute;
    left: 0;
    top: 0;
	width:100%;
  }
}
</style>
<div class='main'>
	<button type='button' class='button_success_dark' onclick='window.print();'><i class="fa fa-print" aria-hidden="true"></i></button>
	<a href='purchase_order_incomplete_dashboard' style='text-decoration:none'>
		<button type='button' class='button_default_dark'><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
	</a>
	<div id='printable'>
		<h2 style='font-family:bebasneue'><?= $supplier_name ?></h2>
		<p><?= $supplier_address ?></p>
		<p><?= $supplier_city ?></p>
		<hr>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>Purchase order name</th>
					<th>Reference</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Pending</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql_po				= "SELECT purchaseorder.reference, purchaseorder.quantity, purchaseorder.received_quantity, code_purchaseorder.name
						FROM purchaseorder JOIN code_purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id
						WHERE purchaseorder.status = '0' AND code_purchaseorder.supplier_id = '$supplier_id'";
	$result_po			= $conn->query($sql_po);
	while($po			= $result_po->fetch_assoc()){
		$po_name		= $po['name'];
		$reference		= $po['reference'];
		$ordered		= $po['quantity'];
		$received		= $po['received_quantity'];
		$pending		= $ordered - $received;
		
		$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
?>
				<tr>
					<td><?= $po_name ?></td>
					<td><?= $reference ?></td>
					<td><?= $description ?></td>
					<td><?= number_format($ordered,0); ?></td>
					<td><?= number_format($pending,0); ?></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
	</div>
	<button type='button' class='button_success_dark' onclick='window.print();'><i class="fa fa-print" aria-hidden="true"></i></button>
	<a href='purchase_order_incomplete_dashboard' style='text-decoration:none'>
		<button type='button' class='button_default_dark'><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
	</a>
</div>