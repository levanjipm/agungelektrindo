<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	$supplier_id 		= $_POST['supplier'];
	$date 				= $_POST['date'];
	
	$sql_supplier		= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier	= $conn->query($sql_supplier);
	$supplier			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
	
	$check_invoice 	= 1;
	$check_po 		= 1;
	$document_array	= $_POST['document'];
	$po_array		= array();
	
	if(empty($_POST['document'])){
?>
<script>
	window.location.href = 'accounting';
</script>
<?php
	}
	
	foreach($document_array as $document){
		$sql 		= "SELECT isinvoiced,po_id FROM code_goodreceipt WHERE id = '" . $document . "'";
		$result 	= $conn->query($sql);
		$row 		= $result->fetch_assoc();
		$po_id		= $row['po_id'];
		
		if($row['isinvoiced'] == 1){ $check_invoice++; };
		if(in_array($po_id,$po_array)){} else {array_push($po_array,$po_id); };
		next($document_array);
	}
	
	$po_quantity	= count($po_array);
	if($check_invoice > 1){
?>
<script>
	window.location.href = 'accounting';
</script>
<?php
	}
	$sql_po 		= "SELECT taxing FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_po 		= $conn->query($sql_po);
	$po 			= $result_po->fetch_assoc();
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
		padding:20px;
		width:100%;
		top:30%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase invoice</h2>
	<p>Validate purchase invoice</p>
	<hr>
	<form action='debt_document_input' method='POST' id='debt_form'>
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<input type='hidden' value='<?= $supplier_id ?>' name='supplier'>
	
	<label>Purhase date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
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
	$j = 1;
	$total_invoice			= 0;
?>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%;text-align:center'>Reference</th>
			<th style='width:30%;text-align:center'>Description</th>
			<th style='width:10%;text-align:center'>Quantity</th>
			<th style='width:30%;text-align:center'>Price</th>
			<th style='width:10%;text-align:center'></th>
		</tr>
<?php
	foreach($document_array as $document){
?>
		<input type='hidden' value='<?= $document ?>' name='code_gr[<?= $i ?>]'>
		<br>
<?php
		$sql_general 		= "SELECT purchaseorder.id AS po_detail_id, purchaseorder.reference, purchaseorder.unitprice, goodreceipt.id, goodreceipt.quantity 
								FROM goodreceipt 
								JOIN purchaseorder 
								ON purchaseorder.id = goodreceipt.received_id 
								WHERE goodreceipt.gr_id = '" . $document . "'";
		$result_general 	= $conn->query($sql_general);
		while($general 		= $result_general->fetch_assoc()){
			$reference		= $general['reference'];
			
			$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 	= $conn->query($sql_item);
			$item 			= $result_item->fetch_assoc();
			
			$description	= $item['description'];
			
			$id				= $general['id'];
			$id_po_detail	= $general['po_detail_id'];
			
			$total_invoice	+= $general['unitprice'] * $general['quantity'];
?>
		<tr>
			<td style='text-align:center'><?= $reference ?></td>
			<td style='text-align:center'><?= $description ?></td>
			<td style='text-align:center'>
				<?= $general['quantity'] ?>
				<input type='hidden' value='<?= $general['quantity'] ?>' id='quantity<?= $j ?>'>
				<input type='hidden' value='<?= $id_po_detail ?>' name='po_gr[<?= $id ?>]'>
			</td>
			<td style='text-align:center'>
				<button type='button' style='background-color:transparent;border:none' onclick='show(<?= $j ?>)' id='button-<?= $j ?>'>Rp. <?= number_format($general['unitprice'],2) ?></button>
				<input type='number' value='<?= $general['unitprice'] ?>' id='input<?= $j ?>' style='display:none' onfocusout='hide(<?= $j ?>)' class='form-control' name='input[<?= $id ?>]'>
			</td>
			<td style='text-align:center'>
				<input type="checkbox" class='checkbox'>
			</td>
		</tr>
<?php
			$j++;
		}
		$i++;
		next($document_array);
	}
?>
		<tr>
			<td colspan='2'></td>
			<td>Initial Value</td>
			<td>Rp. <?= number_format($total_invoice,2) ?></td>
		</tr>
	</table>
	</form>
	<button type='button' class='button_default_dark' onclick='hitungin()'>Calculate</button>
	<div class='notification_large' style='display:none' id='confirm_notification'>
		<div class='notification_box'>
			<h1 style='font-size:2em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
			<p style='font-family:museo'>Are you sure to confirm this purchase?</p>
			<p>Nomor faktur pajak : <span id='faktur_pajak_display'></span>
			<p>Total : <span id='total_display'></span>
			<br><br>
			<button type='button' class='button_danger_dark' id='back_button'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
		</div>
	</div>
	
<script>
	var total;
	$("#fp").inputmask("999.999-99.99999999");
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
				var input_id	= $(this).attr('id');
				var uid			= parseInt(input_id.substring(5,8));
				var price 		= parseFloat($('#' + input_id).val());
				var quantity	= parseInt($('#quantity' + uid).val());
				total 			= total + (quantity * price);
			});
			$('#total_display').html('Rp. ' + numeral(total).format('0,0.00'));
			$('#confirm_notification').fadeIn();
		}
	}
	$('#back_button').click(function(){
		$('#confirm_notification').fadeOut();
	});
	$('#confirm_button').click(function(){
		$('#debt_form').submit();
	});
</script>			