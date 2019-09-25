<?php
	include('purchasingheader.php');
	//showing all the items that are going to be closed//
	if(empty($_POST['po_id'])){
		header('location:purchasing.php');
	} else {
		$po_id 			= $_POST['po_id'];
	}	
	$sql_initial 		= "SELECT name,supplier_id FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_initial 	= $conn->query($sql_initial);
	$initial 			= $result_initial->fetch_assoc();
	
	$supplier_id		= $initial['supplier_id'];
	$purchaseorder_name	= $initial['name'];
		
	$sql_supplier 		= "SELECT name FROM supplier WHERE id = '$supplier_id'";
	$result_supplier 	= $conn->query($sql_supplier);
	$supplier 			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p>Close purchase order</p>
	<hr>
	<p><strong>Supplier :</strong> <?= $supplier_name ?></p>
	<p><strong>PO number:</strong> <?= $purchaseorder_name?></p>
	<button type='button' class='button_success_dark' id='print_purchase_order_button'>View PO</button>
	<br>
	<br>
	<form id='purchaseorder_print_form' action='purchase_order_create_print' method='POST' target='_blank'>
		<input type='hidden' value='<?= $po_id ?>' name='id'>
	</form>
	<script>
		$('#print_purchase_order_button').click(function(){
			$('#purchaseorder_print_form').submit();
		})
	</script>
	<table class='table'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Pending quantity</th>
		</tr>
<?php
	$sql = "SELECT * FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "' AND status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$reference		= $row['reference'];
		$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "' LIMIT 1";
		$result_item 	= $conn->query($sql_item);
		$item 			= $result_item->fetch_assoc();
		
		$description 	= $item['description'];
		
		$remainder		= $row['quantity'] - $row['received_quantity'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= $remainder ?></td>
		</tr>
<?php
	}
?>
	</table>
	<form action='close_purchaseorder' method='POST' id='closepo'>
		<input type='hidden' value='<?= $po_id ?>' name='po_id'>
		<br>
		<button type='button' class='button_default_dark' onclick='confirm()'>Close Purchase Order</button>
	</form>
</div>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-confirm{
		background-color:green;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	input[type=number] {
		-webkit-text-security: disc;
	}
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none;
		margin: 0;
	}
</style>
<div class='notification_large' style='display:none'>
	<div class='notification_box' id='confirm_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this Purchase Order?</h2>
		<br>
		<button type='button' class='btn btn-back' id='confirm_back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
	</div>
	<div class='notification_box' id='pin_box' style='display:none'>
		<h1 style='font-size:3em;color:#def'><i class="fa fa-key" aria-hidden="true"></i></h1>
		<div class='col-md-4 col-md-offset-4'>
			<input type='number' class='form-control' name='pin'>
		</div>
		<br><br>
		<button type='button' class='btn btn-back' id='pin_back'>Back</button>
		<button type='button' class='btn btn-confirm'>Confirm</button>
	</div>
</div>
<script>
	function confirm(){
		$('.notification_large').fadeIn();
	}
	$('#confirm_back').click(function(){
		$('.notification_large').fadeOut();
	});
	$('#pin_back').click(function(){
		$('#pin_box').fadeOut();
		setTimeout(function(){
			$('#confirm_box').fadeIn();
		},300);
	});
	$('.btn-delete').click(function(){
		$('#confirm_box').fadeOut();
		setTimeout(function(){
			$('#pin_box').fadeIn();
		},300);
	});
	$('.btn-confirm').click(function(){
		$('#closepo').submit();
	});
</script>