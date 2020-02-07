<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
	
	if(empty($_POST['po_id'])){
		header('location:../purchasing');
	} else {
		$po_id 			= $_POST['po_id'];
	}	
	$sql_initial 		= "SELECT code_purchaseorder.date, code_purchaseorder.name, supplier.name as supplier_name, supplier.address, supplier.city,
							users.name as creator FROM code_purchaseorder
							JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
							JOIN users ON code_purchaseorder.created_by = users.id
							WHERE code_purchaseorder.id = '" . $po_id . "'";
	$result_initial 	= $conn->query($sql_initial);
	$initial 			= $result_initial->fetch_assoc();
	
	$po_name			= $initial['name'];
	$po_date			= $initial['date'];
	$creator			= $initial['creator'];
	
	$supplier_name		= $initial['supplier_name'];
	$supplier_address	= $initial['address'];
	$supplier_city		= $initial['city'];
?>
<head>
	<title>Close <?= $po_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p style='font-family:museo'>Close purchase order</p>
	<hr>
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	
	<label>Purchase order</label>
	<p style='font-family:museo'><?= $po_name?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($po_date)) ?></p>
	<p style='font-family:museo'>Created by <?= $creator ?></p>
	<br>
	
	<button type='button' class='button_success_dark' id='print_purchase_order_button'><i class='fa fa-eye'></i></button>
	<br><br>
	<form id='purchaseorder_print_form' action='/agungelektrindo/purchasing_department/purchase_order_create_print' method='POST' target='_blank'>
		<input type='hidden' value='<?= $po_id ?>' name='id'>
	</form>
	<script>
		$('#print_purchase_order_button').click(function(){
			$('#purchaseorder_print_form').submit();
		})
	</script>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Pending quantity</th>
		</tr>
<?php
	$sql = "SELECT purchaseorder.reference, purchaseorder.quantity, purchaseorder.received_quantity, itemlist.description
			FROM purchaseorder 
			JOIN itemlist ON purchaseorder.reference = itemlist.reference
			WHERE purchaseorder.purchaseorder_id = '" . $po_id . "' AND status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$reference		= $row['reference'];		
		$description 	= $row['description'];
		
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
	<form action='/agungelektrindo/administrator_department/purchase_order_close' method='POST' id='close_purchase_order_form'>
		<input type='hidden' value='<?= $po_id ?>' name='po_id'>
		<br>
		<button type='button' class='button_danger_dark' id='close_purchase_order_button'><i class='fa fa-ban'></i></button>
	</form>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar' id='confirm_box'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this Purchase Order?</p>
		<button type='button' class='button_danger_dark' id='confirm_back'>Back</button>
		<button type='button' class='button_default_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#close_purchase_order_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
	});
	
	$('#confirm_back').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});

	$('#confirm_button').click(function(){
		$('#close_purchase_order_form').submit();
	});
</script>