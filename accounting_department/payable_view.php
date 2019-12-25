<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	$supplier_id			= $_GET['id'];
	$sql_supplier			= "SELECT id FROM supplier WHERE id = '$supplier_id'";
	$result_supplier		= $conn->query($sql_supplier);
	$supplier_count			= mysqli_num_rows($result_supplier);
	
	if(empty($_GET['id']) || $supplier_count == 0){
?>
<script>
	window.location.href='/agungelektrindo/accounting';
</script>
<?php 
	}
	
	$sql_supplier			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier		= $conn->query($sql_supplier);
	$supplier				= $result_supplier->fetch_assoc();
	
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
?>
<head>
	<title><?= $supplier_name ?> Receivable report</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Receivable report</h2>
	<hr>
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<button type='button' class='button_success_dark' id='hide_completed_button' style='display:none'><i class='fa fa-eye-slash'></i></button>
	<button type='button' class='button_default_dark' id='show_completed_button'><i class='fa fa-eye'></i></button>
	<br><br>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Date</th>
				<th>Invoice name</th>
				<th>Tax document</th>
				<th>Debit</th>
				<th>Credit</th>
				<th>Balance</th>
			</tr>
		</thead>
		<tbody>
<?php
	$credit					= 0;
	$sql					= "SELECT isdone, id, name, value, date, faktur FROM purchases 
								WHERE supplier_id = '$supplier_id' ORDER BY date ASC ";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$purchase_id		= $row['id'];
		$purchase_date		= $row['date'];
		$purchase_name		= $row['name'];
		$purchase_tax		= $row['faktur'];
		$purchase_value		= $row['value'];
		$purchase_status	= $row['isdone'];
		
		$credit				+= $row['value'];
		if($purchase_status	== 1){
?>
			<tr class='completed_transaction'>
<?php } else { ?>
			<tr class='incomplete_transaction'>
<?php } ?>
				<td><?= date('d M Y',strtotime($purchase_date)) ?></td>
				<td><?= $purchase_name ?> <button class='button_information_transparent' title='View <?= $purchase_name ?>' onclick='view_invoice(<?= $purchase_id ?>)'><i class='fa fa-info'></i></button></td>
				<td><?= $purchase_tax ?></td>
				<td>Rp. <?= number_format($purchase_value,2) ?></td>
				<td></td>
				<td>Rp. <?= number_format($credit,2) ?></td>
			</tr>
<?php	
		$sql_payable				= "SELECT payable.id, payable.date, payable.value, purchases.isdone, payable.bank_id 
										FROM payable JOIN purchases ON purchases.id = payable.purchase_id
										WHERE payable.purchase_id = '$purchase_id'";
		$result_payable				= $conn->query($sql_payable);
		while($payable				= $result_payable->fetch_assoc()){
			$payment_id				= $payable['id'];
			$payment_invoice_status	= $payable['isdone'];
			$payment_date			= $payable['date'];
			$payment_value			= $payable['value'];
			
			$credit					-= $payment_value;
		if($payment_invoice_status	== 1){
?>
			<tr class='completed_transaction'>
<?php } else { ?>
			<tr class='incomplete_transaction'>
<?php } ?>
				<td><?= date('d M Y',strtotime($payment_date)) ?></td>
				<td colspan='3'></td>
				<td>
					Rp. <?= number_format($payment_value,2) ?>
					<?php
						if(empty($payable['bank_id'])){
					?>
					<button type='button' class='button_information_red' style='float:right' onclick='confirm_delete(<?= $payment_id ?>)'>&times</button>
					<?php
						}
					?>
				</td>
				<td>Rp. <?= number_format($credit,2) ?></td>
			</tr>
<?php
		}
	}
	
	$sql_bank				= "SELECT date, value FROM code_bank WHERE label = 'SUPPLIER' AND bank_opponent_id = '$supplier_id' AND isdone = '0' AND isdelete = '0'";
	$result_bank			= $conn->query($sql_bank);
	while($bank				= $result_bank->fetch_assoc()){
		$bank_date			= $bank['date'];
		$bank_value			= $bank['value'];
		$credit				-= $bank_value;
?>
			<tr>
				<td><?= date('d M Y',strtotime($bank_date)) ?></td>
				<td colspan='3'></td>
				<td>Rp. <?= number_format($bank_value,2) ?></td>
				<td>Rp. <?= number_format($credit,2) ?></td>
			</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_success_dark'><i class='fa fa-print'></i></button>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	$('.completed_transaction').hide();
	
	$('#hide_completed_button').click(function(){
		$('#show_completed_button').show();
		$('#hide_completed_button').hide();
		$('.completed_transaction').hide();
	});
	
	$('#show_completed_button').click(function(){
		$('#show_completed_button').hide();
		$('#hide_completed_button').show();
		$('.completed_transaction').show();
	});
	
	function view_invoice(n){
		$.ajax({
			url:'purchase_view.php',
			data:{
				invoice_id:n
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn(300);
			}
		});
	};
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
</script>