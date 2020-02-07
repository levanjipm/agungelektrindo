<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	$date 				= $_POST['date'];
	
	$check_invoice 	= 1;
	$check_po 		= 1;
	$document_array	= $_POST['document'];
	$po_array		= array();
	
	if(empty($_POST['document'])){
?>
<script>
	window.location.href = '/agungelektrindo/accounting';
</script>
<?php
	}
	
	foreach($document_array as $document){
		$sql 			= "SELECT isinvoiced, po_id FROM code_goodreceipt WHERE id = '$document'";
		$result 		= $conn->query($sql);
		$row 			= $result->fetch_assoc();
		$po_id			= $row['po_id'];
		
		if($row['isinvoiced'] == 1){ $check_invoice++; };
		if(in_array($po_id,$po_array)){} else {array_push($po_array,$po_id);};
		next($document_array);
	}
	
	$po_quantity		= count($po_array);
	if($check_invoice > 1){
?>
<script>
	window.location.href = '/agungelektrindo/accounting';
</script>
<?php
	}
	
	$sql_po 				= "SELECT supplier.id, code_purchaseorder.taxing, supplier.name as supplier_name, supplier.address, supplier.city, code_purchaseorder.name, code_purchaseorder.date
								FROM code_purchaseorder 
								JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
								WHERE code_purchaseorder.id = '$po_id'";
	$result_po 				= $conn->query($sql_po);
	$po 					= $result_po->fetch_assoc();
	$taxing					= $po['taxing'];
	
	$purchase_order_name	= $po['name'];
	$purchase_order_date	= $po['date'];
	
	$supplier_name			= $po['supplier_name'];
	$supplier_address		= $po['address'];
	$supplier_city			= $po['city'];
	$supplier_id			= $po['id'];
?>
<head>
	<title>Validate purchase invoice</title>
</head>
<script>
	$('#purchase_invoice_side').click();
	$('#debt_document_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase invoice</h2>
	<p style='font-family:museo'>Validate purchase invoice</p>
	<hr>
	<form action='debt_document_input' method='POST' id='debt_form'>
	
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<input type='hidden' value='<?= $supplier_id ?>' name='supplier'>
	
	<label>Invoice date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	<input type='hidden' value='<?= $date ?>' name='date'>
	
	<label>Purchase order</label>
	<p style='font-family:museo'><?= date('d M Y', strtotime($purchase_order_date)) ?></p>
	<p style='font-family:museo'><?= $purchase_order_name ?></p>
	
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
				<?= number_format($general['quantity']) ?>
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
	<div class='full_screen_wrapper' style='display:none;' id='confirm_notification'>
		<div class='full_screen_notif_bar' style='max-height:250px'>
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
			var window_height		= $(window).height();
			var notif_height		= $('#confirm_notification .full_screen_notif_bar').height();
			var difference			= window_height - notif_height;
			$('#confirm_notification .full_screen_notif_bar').css('top', 0.7 * difference / 2);
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