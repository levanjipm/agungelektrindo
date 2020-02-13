<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	$purchase_id				= $_POST['id'];
	$sql_purchase			= "SELECT * FROM purchases WHERE id = '$purchase_id'";
	$result_purchase		= $conn->query($sql_purchase);
	$purchase				= $result_purchase->fetch_assoc();
	
	$purchase_name			= $purchase['name'];
	$purchase_faktur		= $purchase['faktur'];
	$purchase_value			= $purchase['value'];
	
	$supplier_id			= $purchase['supplier_id'];
	
	$sql_supplier			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier		= $conn->query($sql_supplier);
	$supplier				= $result_supplier->fetch_assoc();
	
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
?>
<head>
	<title>Set <?= $purchase_name ?> as done</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p style='font-family:museo'>Set purchase as done</p>
	<hr>
	<label>Date</label>
	<input type='date' class='form-control' id='date'>
	<label>Invoice data</label>
	<table class='table table-bordered'>
		<tr>
			<td>Debt document name</td>
			<td><?= $purchase_name ?></td>
		</tr>
		<tr>
			<td>Tax document</td>
			<td><?= $purchase_faktur ?></td>
		</tr>
		<tr>
			<td>Value</td>
			<td>Rp. <?= number_format($purchase_value,2) ?></td>
		</tr>
	</table>
	<label>Payment</label>
	<table class='table table-bordered'>
<?php
	$sql_payable			= "SELECT * FROM payable WHERE purchase_id = '$purchase_id'";
	$result_payable			= $conn->query($sql_payable);
	while($payable			= $result_payable->fetch_assoc()){
		$pay_date				= $payable['date'];
		$pay_value				= $payable['value'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($pay_date)) ?></td>
			<td>Rp. <?= number_format($pay_value,2) ?></td>
		</tr>
<?php 
	}
?>
	</table>
	<button type='button' class='button_success_dark' id='set_done_button'>Set done</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to set this debt document as done?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<form action='supplier_view' method='GET' id='redirect_form'>
	<input type='hidden' value='<?= $supplier_id ?>' name='id'>
</form>
<script>
	$('#date').focus();
	
	$('#set_done_button').click(function(){
		if($('#date').val() == ''){
			alert('Please insert date');
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
		if($('#date').val() == ''){
			$('#close_notif_button').click();
		} else {
			$.ajax({
				url:'purchase_set_done.php',
				data:{
					purchase_id:<?= $purchase_id ?>,
					date:$('#date').val(),
				},
				type:'POST',
				beforeSend:function(){
					$('button').attr('disabled',true);
				}, success:function(){
					$('#redirect_form').submit();
				}
			});
		}
	});
</script>
	