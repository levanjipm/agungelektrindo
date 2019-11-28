<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
	
	if(empty($_POST['po_id'])){
		header('location:../purchasing');
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
	input[type=number] {
		-webkit-text-security: disc;
	}
	
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none;
		margin: 0;
	}
</style>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar' id='confirm_box'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this Purchase Order?</p>
		<br>
		<button type='button' class='button_danger_dark' id='confirm_back'>Back</button>
		<button type='button' class='button_default_dark' id='show_pin_button'>Confirm</button>
	</div>
	<div class='full_screen_notif_bar' id='pin_box' style='display:none'>
		<h1 style='font-size:2em;color:#def'><i class="fa fa-key" aria-hidden="true"></i></h1>
		<div class='col-md-4 col-md-offset-4'>
			<input type='number' class='form-control' name='pin'>
		</div>
		<br><br>
		<button type='button' class='button_danger_dark' id='pin_back'>Back</button>
		<button type='button' class='button_success_dark'>Confirm</button>
	</div>
</div>
<script>
	function confirm(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
	}
	$('#confirm_back').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#pin_back').click(function(){
		$('#pin_box').fadeOut();
		setTimeout(function(){
			$('#confirm_box').fadeIn();
		},300);
	});
	
	$('#show_pin_button').click(function(){
		$('#confirm_box').fadeOut();
		setTimeout(function(){
			$('#pin_box').fadeIn();
		},300);
	});
	$('.btn-confirm').click(function(){
		$('#closepo').submit();
	});
</script>