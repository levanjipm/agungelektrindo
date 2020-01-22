<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	if (empty($_POST['po'])){
		header('location:/agungelektrindo/inventory');
	}
	
	$date = $_POST['date'];
	
	//If there was no purchase from the purchasing department, redirect to initial//
	$po_id = $_POST['po'];
	
	//Get supplier name//
	$sql_supplier 		= "SELECT name, address, city FROM supplier WHERE id = '" . $_POST['supplier'] . "'";
	$result_supplier 	= $conn->query($sql_supplier);
	$row_supplier 		= $result_supplier->fetch_assoc();
	$supplier_name 		= $row_supplier['name'];
	$supplier_address	= $row_supplier['address'];
	$supplier_city		= $row_supplier['city'];
	
	//Get purchaseorder unique name from database//
	$sql_po 			= "SELECT name, date FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_po 			= $conn->query($sql_po);
	$row_po 			= $result_po->fetch_assoc();
	$po_name 			= $row_po['name'];
	$po_date			= $row_po['date'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Good Receipt</h2>
	<p style='font-family:museo'>Input good receipt</p>
	<hr>
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	
	<label>Purchase order</label>
	<p style='font-family:museo'><?= $po_name ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($po_date)) ?></p>
	
	<label>Received date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	<form action="good_receipt_create_input" method="POST" id="goodreceipt_form">
		<label>Document number</label>
		<input type="text" name="document" class="form-control" id="document">
		<input type="hidden" name="date" value="<?= $date ?>">
		<br><br>
		<table class="table table-bordered">
			<thead>
				<th style='width:30%'>Reference</th>
				<th style='width:30%'>Description</th>
				<th style='width:10%'>Ordered</th>
				<th style='width:10%'>Received</th>
				<th style='width:20%'>Item Received</th>
			</thead>
<?php
	$sql 		= "SELECT id, reference, quantity, received_quantity, status
				FROM purchaseorder
				WHERE status = '0' AND purchaseorder_id = '" . $po_id . "'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()) {
		$id		= $row['id'];
		$reference	= $row['reference'];
		$quantity	= $row['quantity'];
		$received	= $row['received_quantity'];
		
		$sql_item	= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$item_description	= $item['description'];
?>
			<tr>
				<td><?= $reference	?></td>
				<td><?= $item_description	?></td>
				<td><?= $quantity	?></td>
				<td><?= $received	?></td>
				<td>
					<input class="form-control" type="number" name="qty_receive[<?= $id?>]" id="qty_receive<?= $id?>" max="<?= $quantity - $received?>" min='0' value='0'>
				</td>
			</tr>
<?php
	}
?>	
		</table>
		<div class="row">
			<div class='col-12'>
				<input type="hidden" value="<?= $_POST['po'] ?>" name="po">
				<button type="button" class="button_default_dark" onclick='calculate()'>Calculate</button>
			</div>
		</div>
	</form>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-exclamation" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this good receipt?</p>
		<button type='button' class='button_danger_dark' id='close_notif_bar_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
function calculate(){
	var res = 'true';
	var total_receive = 0;
	$('input[id^="qty_receive"]').each(function(){
		var maximum = parseInt($(this).attr('max'));
		var receive = parseInt($(this).val());
		total_receive = parseInt(total_receive + receive);
		if(maximum - receive < 0){
			res = 'false';
			return false;
		} else if(receive < 0){
			res = 'false';
			alert('Cannot insert minus values!');
			return false;
		} else if($.isNumeric(receive) == false){
			res = 'false';
			alert('Insert correct value!');
			return false;
		} else{
			return true;
		}
	});
	
	if($('#document').val() == ''){
		alert('Cannot proceed, please check document number');
	} else if($.isNumeric(total_receive) == true && total_receive == 0){
		alert('Cannot insert blank document!');
		return false;
	} else if($.isNumeric(total_receive) == false){
		return false;
	} else if(res == 'false'){
		alert('Check your input');
	} else {
		var window_height = $(window).height();
		var notif_height	= $('.full_screen_notif_bar').height();
		var difference		= window_height - notif_height;
		$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
	}
};

$('#close_notif_bar_button').click(function(){
	$('.full_screen_wrapper').fadeOut();
});

$('#confirm_button').click(function(){
	$('#goodreceipt_form').submit();
});		
</script>