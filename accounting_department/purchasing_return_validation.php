<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	$return_id						= $_POST['id'];
	$sql_code_purchase_return		= "SELECT code_purchase_return_sent.document, code_purchase_return_sent.date, code_purchase_return.supplier_id
										FROM code_purchase_return_sent 
										JOIN code_purchase_return ON code_purchase_return_sent.code_purchase_return_id = code_purchase_return.id
										WHERE code_purchase_return_sent.id = '$return_id'";
	$result_code_purchase_return	= $conn->query($sql_code_purchase_return);
	$code_purchase_return			= $result_code_purchase_return->fetch_assoc();
	
	$date							= $code_purchase_return['date'];
	$document						= $code_purchase_return['document'];
	$supplier_id					= $code_purchase_return['supplier_id'];
	
	$sql_supplier					= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier				= $conn->query($sql_supplier);
	$supplier						= $result_supplier->fetch_assoc();
	
	$supplier_name					= $supplier['name'];
	$supplier_address				= $supplier['address'];
	$supplier_city					= $supplier['city'];
	
?>
<head>
	<title>Confirm purchase return document</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase return</h2>
	<p style='font-family:museo'>Confirm purchase return</p>
	<hr>
	<label>Repayment date</label>
	<input type='date' class='form-control' id='date'>
	
	<label>Document</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	<p style='font-family:museo'><?= $document ?></p>
	
	<label>Supplier data</label>
	<p style='font-family:museo'><?= $supplier_name	?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city	?></p>	
	
	<label>Return data</label>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Total</th>
		</tr>
<?php
	$return_value					= 0;
	$sql_return						= "SELECT purchase_return_sent.quantity, purchase_return.reference, itemlist.description, purchase_return.price
										FROM purchase_return_sent
										JOIN purchase_return ON purchase_return_sent.purchase_return_id = purchase_return.id
										JOIN itemlist ON purchase_return.reference = itemlist.reference
										WHERE purchase_return_sent.sent_id = '$return_id'";
	$result_return					= $conn->query($sql_return);
	while($return					= $result_return->fetch_assoc()){
		$reference					= $return['reference'];
		$quantity					= $return['quantity'];
		$description				= $return['description'];
		$price						= $return['price'];
		$total_price				= $price * $quantity;
		$return_value				+= $total_price;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity,0) ?></td>
			<td>Rp. <?= number_format($price,2) ?></td>
			<td>Rp. <?= number_format($total_price,2) ?></td>
		</tr>
<?php
	}
?>
		<tr>
			<td colspan='3'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($return_value,2) ?></td>
		</tr>
	</table>
	
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this return</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#submit_button').click(function(){
		if($('#date').val() == ''){
			alert('Please insert valid date');
			$('#date').focus();
			return false;
		} else {
			var window_height			= $(window).height();
			var notif_height			= $('.full_screen_notif_bar').height();
			var difference				= window_height - notif_height;
			$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
			$('.full_screen_wrapper').fadeIn();
		}
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'purchasing_return_input.php',
			data:{
				id:<?= $return_id ?>,
				date:$('#date').val()
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				// window.location.href='/agungelektrindo/accounting_department/purchasing_return_dashboard';
			}
		});
	});
</script>