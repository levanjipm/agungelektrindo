<?php
	include('accountingheader.php');
	$supplier_id 	= $_POST['supplier'];
	$date 			= $_POST['date'];
	//Checking the document//
	$check_invoice 	= 1;
	$check_po 		= 1;
	$document_array	= $_POST['document'];
	$po_array		= array();
	
	foreach($document_array as $document){
		$sql 		= "SELECT isinvoiced,po_id FROM code_goodreceipt WHERE id = '" . $document . "'";
		$result 	= $conn->query($sql);
		$row 		= $result->fetch_assoc();
		$po_id		= $row['po_id'];
		
		if($row['isinvoiced'] == 1){ $check_invoice++; };
		if(in_array($po_id,$po_array)){} else {array_push($po_array,$po_id); };
	}
	
	$po_quantity	= count($po_array);
	if($check_invoice > 1 || $po_quantity > 1){
?>
<script>
	window.location.href = 'accounting.php';
</script>
<?php
	}
	$sql_po = "SELECT taxing FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_po = $conn->query($sql_po);
	$po = $result_po->fetch_assoc();
	$taxing=  $po['taxing'];
	//if it exist, then show the items//
?>
<script src='../universal/Numeral-js-master/numeral.js'></script>
<script src='../universal/jquery/jquery.inputmask.bundle.js'></script>
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
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
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
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase invoice</h2>
	<p>Validate purchase invoice</p>
	<form action='debt_document_input.php' method='POST' id='debt_form'>
	<input type='hidden' value='<?= $supplier_id ?>' name='supplier'>
	<input type='hidden' value='<?= $date ?>' name='date'>
	<label>Input invoice number</label>
	<input type='text' class='form-control' name='invoice_doc' id='inv'>
<?php
	if($taxing == 1){
?>
	<label>Input tax document number</label>
	<input type='text' class='form-control' name='tax_doc' id='fp'>
<?php
	}
	
	$i = 1;
?>
	<table class='table'>
		<tr>
			<th style='width:40%'>Item name</th>
			<th style='width:10%'>Quantity</th>
			<th style='width:30%'>Price</th>
			<th style='width:20%'></th>
		</tr>
<?php
	foreach($document_array as $document){
		$sql_upper 		= "SELECT id FROM code_goodreceipt WHERE id = '" . $document . "'";
		$result_upper 	= $conn->query($sql_upper);
		$upper 			= $result_upper->fetch_assoc();
?>
		<input type='hidden' value='<?= $document ?>' name='code_gr[<?= $i ?>]'>
<?php
		$sql_general 		= "SELECT purchaseorder.id AS po_detail_id, purchaseorder.reference, purchaseorder.unitprice, goodreceipt.id, goodreceipt.quantity 
							FROM goodreceipt 
							JOIN purchaseorder 
							ON purchaseorder.id = goodreceipt.received_id 
							WHERE goodreceipt.gr_id = '" . $upper['id'] . "'";
		$result_general 	= $conn->query($sql_general);
		while($general 		= $result_general->fetch_assoc()){
			$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . $general['reference'] . "'";
			$result_item 	= $conn->query($sql_item);
			$item 			= $result_item->fetch_assoc();
			$id_po_detail	= $general['po_detail_id'];
?>
		<tr>
			<td><?= $general['reference'] . " - " . $item['description'] ?></td>
			<td>
				<?= $general['quantity'] ?>
				<input type='hidden' value='<?= $general['id'] ?>' name='po_gr[<?= $general['po_detail_id'] ?>]'>
			</td>
			<td>
				<button type='button' style='background-color:transparent;border:none' onclick='show(<?= $id_po_detail ?>)' id='button-<?= $id_po_detail ?>'>Rp. <?= number_format($general['unitprice'],2) ?></button>
				<input type='number' value='<?= $general['unitprice'] ?>' id='input<?= $id_po_detail ?>' style='display:none' onfocusout='hide(<?= $id_po_detail ?>)' class='form-control' name='input[<?= $id_po_detail ?>]'>
			</td>
			<td>
				<input type="checkbox" class='checkbox'>
			</td>
		</tr>
<?php
		}
	 next($document_array);
	}
?>
	</table>
	</form>
	<button type='button' class='btn btn-default' onclick='hitungin()'>Calculate</button>
	<div class='notification_large' style='display:none' id='confirm_notification'>
		<div class='notification_box'>
			<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
			<h2 style='font-family:bebasneue'>Are you sure to confirm this purchase?</h2>
			<p>Nomor faktur pajak : <span id='faktur_pajak_display'></span>
			<p>Total : <span id='total_display'></span>
			<br><br>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
		</div>
	</div>
	
<script>
	var total;
	$("#fp").inputmask("999.999.99-99999999");
	function show(n){
		$('#input' + n).show();
		$('#input' + n).focus();
		$('#button-' + n).hide();
	}
	function hide(n){
		$('#input' + n).hide();
		$('#button-' + n).text('Rp. ' + numeral($('#input' + n).val()).format('0,0.00'));
		$('#button-' + n).show();
	}
	function hitungin(){
		total = 0;
		if($('#inv').val() == ''){
			alert('Insert correct document number!');
			return false;
		} else if(<?= $taxing ?> == 1 && $('#fp').val() == ''){
			alert('Please insert correct tax document number');
			return false;
		} else if($('.checkbox:checked').length != $('.checkbox').length){
			alert('Please check all input!');
			return false;
		} else {
			$('#faktur_pajak_display').html($('#fp').val());
			$('input[id^="input"]').each(function(){
				var price = $(this).val();
				var parent = $(this).parent();
				var parent_sibling = parent.siblings();
				var quantity = parent_sibling.find($('input[id^="quantity"]'));
				var quantity_val = quantity.val();
				total = total + (quantity_val * price);
			});
			$('#total_display').html('Rp. ' + numeral(total).format('0,0.00'));
			$('#confirm_notification').fadeIn();
		}
	}
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	$('#confirm_button').click(function(){
		$('#debt_form').submit();
	});
</script>			