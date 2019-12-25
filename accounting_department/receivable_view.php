<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	$customer_id			= $_GET['id'];
	$sql_customer			= "SELECT id FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer_count			= mysqli_num_rows($result_customer);
	
	$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer				= $result_customer->fetch_assoc();
	
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
?>
<head>
	<title><?= $customer_name ?> Receivable report</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Receivable report</h2>
	<hr>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	<button type='button' class='button_success_dark' id='hide_completed_button' style='display:none'><i class='fa fa-eye-slash'></i></button>
	<button type='button' class='button_default_dark' id='show_completed_button'><i class='fa fa-eye'></i></button>
	<a href='customer_view.php?id=<?= $customer_id ?>' style='text-decoration:none'><button type='button' class='button_danger_dark'><i class='fa fa-long-arrow-left'></i></button></a>
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
	$sql					= "SELECT invoices.isdone, invoices.id, invoices.name, invoices.value, invoices.ongkir, invoices.date, invoices.faktur FROM invoices 
								JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
								WHERE code_delivery_order.customer_id = '$customer_id'
								ORDER BY invoices.date ASC, code_delivery_order.number ASC";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$invoice_id			= $row['id'];
		$invoice_date		= $row['date'];
		$invoice_name		= $row['name'];
		$invoice_tax		= $row['faktur'];
		$invoice_value		= $row['value'];
		$invoice_delivery	= $row['ongkir'];
		$invoice_status		= $row['isdone'];
		
		$credit				+= $row['value'] + $row['ongkir'];
		if($invoice_status	== 1){
?>
			<tr class='completed_transaction'>
<?php } else { ?>
			<tr class='incomplete_transaction'>
<?php } ?>
				<td><?= date('d M Y',strtotime($invoice_date)) ?></td>
				<td><?= $invoice_name ?> <button class='button_information_transparent' title='View <?= $invoice_name ?>' onclick='view_invoice(<?= $invoice_id ?>)'><i class='fa fa-info'></i></button></td>
				<td><?= $invoice_tax ?></td>
				<td>Rp. <?= number_format($invoice_value + $invoice_delivery,2) ?></td>
				<td></td>
				<td>Rp. <?= number_format($credit,2) ?></td>
			</tr>
<?php	
		$sql_receivable				= "SELECT receivable.id as receivable_id, receivable.date, receivable.value, invoices.isdone, receivable.bank_id 
										FROM receivable JOIN invoices ON invoices.id = receivable.invoice_id
										WHERE receivable.invoice_id = '$invoice_id'";
		$result_receivable			= $conn->query($sql_receivable);
		while($receivable			= $result_receivable->fetch_assoc()){
			$receivable_id			= $receivable['receivable_id'];
			$payment_invoice_status	= $receivable['isdone'];
			$payment_date			= $receivable['date'];
			$payment_value			= $receivable['value'];
			
			$credit					-= $payment_value;
		if($payment_invoice_status	== 1){
?>
			<tr class='completed_transaction' id='tr_receivable_<?= $receivable_id ?>'>
<?php } else { ?>
			<tr class='incomplete_transaction' id='tr_receivable_<?= $receivable_id ?>'>
<?php } ?>
				<td><?= date('d M Y',strtotime($payment_date)) ?></td>
				<td colspan='3'></td>
				<td>
					Rp. <?= number_format($payment_value,2) ?>
					<?php
						if(empty($receivable['bank_id'])){
					?>
					<button type='button' class='button_information_red' style='float:right' onclick='confirm_delete(<?= $receivable_id ?>)'>&times</button>
					<?php
						}
					?>
				</td>
				<td>Rp. <?= number_format($credit,2) ?></td>
			</tr>
<?php
		}
	}
	
	$sql_bank				= "SELECT date, value FROM code_bank WHERE label = 'CUSTOMER' AND bank_opponent_id = '$customer_id' AND isdone = '0' AND isdelete = '0'";
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
<div class='full_screen_wrapper' id='view_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<div class='full_screen_wrapper' id='notification_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to delete this receivable data?</p>
		<button type='button' class='button_danger_dark' id='close_notification_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_notification_button'>Confirm</button>
	</div>
</div>
<input type='hidden' id='delete_id'>
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
			url:'invoice_view.php',
			data:{
				invoice_id:n
			},
			type:'POST',
			success:function(response){
				$('#view_wrapper .full_screen_box').html(response);
				$('#view_wrapper').fadeIn(300);
			}
		});
	};
	
	function confirm_delete(n){
		$('#delete_id').val(n);
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('#notification_wrapper').fadeIn(300);
	}
	
	$('#confirm_notification_button').click(function(){
		$.ajax({
			url:'receivable_delete.php',
			data:{
				receivable_id:$('#delete_id').val()
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled', true);
			},
			success:function(){
				location.reload();
			}
		})
	});
	
	$('#close_notification_button').click(function(){
		$('#notification_wrapper').fadeOut(300);
	});
	
	$('.full_screen_close_button').click(function(){
		$('#view_wrapper').fadeOut(300);
	});
</script>