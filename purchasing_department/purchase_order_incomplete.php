<?php
	include('../codes/connect.php');
	$purchaseorder_id	= $_POST['purchaseorder_id'];
	
	$sql				= "SELECT code_purchaseorder.name, code_purchaseorder.date, supplier.name as supplier_name, supplier.address, supplier.city FROM code_purchaseorder 
							JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
							WHERE code_purchaseorder.id = '$purchaseorder_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$purchaseorder_date	= $row['date'];
	$purchaseorder_name	= $row['name'];
	$supplier_name		= $row['supplier_name'];
	$supplier_address	= $row['address'];
	$supplier_city		= $row['city'];
?>
<label>Purchase order</label>
<p style='font-family:museo'><?= $purchaseorder_name ?></p>
<p style='font-family:museo'><?= date('d M Y',strtotime($purchaseorder_date)) ?></p>

<label>Supplier</label>
<p style='font-family:museo'><?= $supplier_name ?></p>
<p style='font-family:museo'><?= $supplier_address ?></p>
<p style='font-family:museo'><?= $supplier_city ?></p>

<button type='button' class='button_default_dark' title='View all items' id='view_incomplete_button'><i class='fa fa-eye'></i></button>
<button type='button' class='button_success_dark' title='View incomplete items' id='view_all_button' style='display:none'><i class='fa fa-eye-slash'></i></button>

<br><br>
<table class='table table-bordered'>
	<tr>
		<th>Reference</th>
		<th>Description</th>
		<th>Ordered</th>
		<th>Pending</th>
	</tr>
<?php
	$sql_po				= "SELECT purchaseorder.reference, purchaseorder.quantity, purchaseorder.received_quantity, itemlist.description FROM purchaseorder
							JOIN itemlist ON purchaseorder.reference = itemlist.reference
							WHERE purchaseorder_id = '$purchaseorder_id'";
	$result_po			= $conn->query($sql_po);
	while($po			= $result_po->fetch_assoc()){
		$reference			= $po['reference'];
		$quantity			= $po['quantity'];
		$received_quantity	= $po['received_quantity'];
		$description		= $po['description'];
		
		$pending			= $quantity - $received_quantity;
		
		if($pending > 0){
?>
	<tr class='item_incomplete'>
<?php
		} else {
?>
	<tr class='item_complete'>
<?php
		}
?>
		<td><?= $reference ?></td>
		<td><?= $description ?></td>
		<td><?= $quantity ?></td>
		<td><?= $pending ?></td>
	</tr>
<?php
	}
?>
</table>
<script>
	$('.item_complete').hide();
	
	$('#view_incomplete_button').click(function(){
		$('.item_complete').show();
		$('#view_all_button').show();
		$('#view_incomplete_button').hide();
	});
	
	$('#view_all_button').click(function(){
		$('.item_complete').hide();
		$('#view_all_button').hide();
		$('#view_incomplete_button').show();
	});
</script>