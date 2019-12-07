<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	if(empty($_POST['invoice_id']) || $role != 'superadmin'){
?>
	<script>
		window.location.href='/agungelektrindo/accounting';
	</script>
<?php
	}
	
	$invoice_id 				= $_POST['invoice_id'];
	$sql_invoice 				= "SELECT ongkir, name,faktur,do_id FROM invoices WHERE id = '" . $invoice_id . "'";
	$result_invoice 			= $conn->query($sql_invoice);
	$invoice					= $result_invoice->fetch_assoc();
	
	$sql_code_delivery_order 	= "SELECT customer_id, so_id FROM code_delivery_order WHERE id = '" . $invoice['do_id'] . "'";
	$result_code_delivery_order = $conn->query($sql_code_delivery_order);
	$code_do 					= $result_code_delivery_order->fetch_assoc();
	
	$so_id 						= $code_do['so_id'];
	$customer_id 				= $code_do['customer_id'];
	
	if($customer_id != 0){
		$sql_customer 			= "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer 		= $conn->query($sql_customer);
		$customer 				= $result_customer->fetch_assoc();
	} else {	
		$sql_customer			= "SELECT retail_name as name FROM code_salesorder WHERE id = '$so_id'";
		$result_customer		= $conn->query($sql_customer);
		$customer				= $result_customer->fetch_assoc();
	}
	
	$faktur 					= $invoice['faktur'];
	$invoice_name 				= $invoice['name'];
	$delivery_fee				= $invoice['ongkir'];
?>
<style>
	.btn-transparent{
		border:none;
		background-color:transparent;
	}
</style>
<head>
	<title>Edit sales invoice <?= $invoice_name ?></title>
</head>
<div class='main'>
	<form method='POST' action='edit_invoice.php' id='myForm'>
	<h2 style='font-family:bebasneue'>Sales Invoice</h2>
	<p>Edit invoice</p>
	<hr>
	<h3 style='font-family:bebasneue'><?= $customer['name'] ?></h3>
	<p style='font-family:museo'><?= $invoice_name ?></p>
<?php if($faktur != ''){ ?>
	<label>Taxing document</label>
	<input type='text' class='form-control' id='piash' name='faktur' value='<?= $faktur ?>'>
	<script>
		$("#piash").inputmask("999.999.99-99999999");
	</script>
<?php } ?>
	<br>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:25%'>Description</th>
			<th style='width:10%'>Quantity</th>
			<th style='width:20%'>Price</th>
			<th style='width:20%'>Total</th>
		</tr>
<?php
	$total 					= 0;
	$quantity_array			= [];
	$sql_do 				= "SELECT id, reference, quantity, billed_price FROM delivery_order WHERE do_id = '" . $invoice['do_id'] . "'";
	$result_do 				= $conn->query($sql_do);
	while($do 				= $result_do->fetch_assoc()){
		$delivery_order_id	= $do['id'];
		$reference			= $do['reference'];
		$quantity			= $do['quantity'];
		$billed_price		= $do['billed_price'];
		$total_price		= $billed_price * $quantity;
		
		$sql_item 			= "SELECT description FROM itemlist WHERE reference = '" . $do['reference'] . "' LIMIT 1";
		$result_item 		= $conn->query($sql_item);
		$item 				= $result_item->fetch_assoc();
		
		$description		= $item['description'];
		
		$quantity_array[$delivery_order_id]	= $quantity;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= $quantity ?></td>
			<td>
				<button type='button' class='btn-transparent' id='edit_price_button-<?= $delivery_order_id ?>' onclick='show_input_price(<?= $delivery_order_id ?>)'>Rp. <?= number_format($billed_price,2) ?></button>
				<input type='number' class='form-control' id='edit_price_input-<?= $delivery_order_id ?>' name='price[<?= $delivery_order_id ?>]' value='<?= $billed_price ?>' style='display:none' onfocusout='hide_input_price(<?= $delivery_order_id ?>)'>
			</td>
			<td id='total_price-<?= $delivery_order_id ?>'><p>Rp. <?= number_format($total_price,2) ?></p></td>
		</tr>
<?php
		$total 				+= $total_price;
	}
	
	print_r($quantity_array);
?>
		<tfoot>
			<tr>
				<td style='background-color:white;border:none' colspan='2'></td>
				<td colspan='2'>Sub total</td>
				<td>Rp. <?= number_format($total,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border:none' colspan='2'></td>
				<td colspan='2'>Delivery fee</td>
				<td>
					<button type='button' class='btn-transparent' id='delivery_fee_button'>Rp. <?= number_format($delivery_fee,2) ?></button>
					<input type='number' class='form-control' id='delivery_fee_input' style='display:none' onblur='hide_delivery_input()'>
				</td>
			</tr>
			<tr>
				<td style='background-color:white;border:none' colspan='2'></td>
				<td colspan='2'>Grand total</td>
				<td id='grand_total_invoice'>Rp. <?= number_format($delivery_fee + $total,2) ?></td>
			</tr>
		</tfoot>
	</table>
	<br>
	<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
	</form>
	<button type='button' class='button_default_dark' id='edit_invoice_button'>Edit Invoice</button>
</div>
<script>
var grand_total_value = 0;
	$('#delivery_fee_button').click(function(){
		$(this).hide();
		$('#delivery_fee_input').show();
		$('#delivery_fee_input').focus();
	});
	
	function hide_delivery_input(){
		$('#delivery_fee_input').hide();
		$('#delivery_fee_button').show();
		var delivery_fee_value = $('#delivery_fee_input').val();
		grand_total_value = parseInt($('#delivery_fee_input').val()) + <?= $total ?>;
		$('#delivery_fee_button').text('Rp. ' + numeral(delivery_fee_value).format('0,0.00'));
		$('#grand_total_invoice').text('Rp. ' + numeral(grand_total_value).format('0,0.00'));
	};
	
	function show_input_price(n){
		$('#edit_price_button-' + n).hide();
		$('#edit_price_input-' + n).show();
		$('#edit_price_input-' + n).focus();
	}
	
	function hide_input_price(n){
		var quantity_array		= <?= json_enconde($quantity_array) ?>;
		var quantity			= 
		var new_price			= $('#edit_price_input-' + n).val();
		var total_price			= quantity * new_price;
		
		$('#edit_price_button-' + n).text('Rp. ' + numeral(new_price).format('0,0.00'));
		$('#total_price-' + n).text('Rp. ' + numeral(total_price).format('0,0.00'));
		
		var new_total_price		= 0;
		
		$('input[id^="edit_price_input-"]').each(function(){
			var uid				= parseInt($(this).attr('id').substring(18,30));
			var quantity_cal	= parseInt($('#quantity-' + uid).text());
			var price			= $('#edit_price_input-' + uid).val();
		});
		
		$('#edit_price_button-' + n).show();
		$('#edit_price_input-' + n).hide();
	}
	
</script>