<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	if(empty($_GET['id'])){
		$sql_invoice		= "SELECT SUM(invoices.value) AS jumlah
								FROM invoices
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								WHERE code_delivery_order.customer_id IS NULL";
	} else {
		$customer_id			= $_GET['id'];
		$sql_customer 			= "SELECT name,address,city FROM customer WHERE id = '$customer_id'";
		$result_customer 		= $conn->query($sql_customer);
		$customer 				= $result_customer->fetch_assoc();
			
		$customer_name			= $customer['name'];
		$customer_address		= $customer['address'];
		$customer_city			= $customer['city'];
			
		$sql_invoice 			= "SELECT SUM(invoices.value) AS jumlah
									FROM invoices
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE code_delivery_order.customer_id = '$customer_id'";
	}
	
	$result_invoice 			= $conn->query($sql_invoice);
	$invoice 					= $result_invoice->fetch_assoc();
?>
<head>
<?php
	if(empty($_GET['id'])){
?>
	<title>View retail</title>
<?php
	} else {
?>
	<title>View <?= $customer_name ?></title>
<?php
	}
?>
</head>
<div class='main'>
	<div class='row'>
		<div class='col-sm-5'>
<?php
	if(empty($_GET['id'])){
?>
			<h2 style='font-family:bebasneue'>Retail</h2>
<?php
	} else {
?>
			<h2 style='font-family:bebasneue'><?= $customer_name ?></h2>
			<p><?= $customer_address ?></p>
			<p><?= $customer_city ?></p>
<?php
	}
?>
		</div>
		<div class='col-sm-3 col-sm-offset-3' style='background-color:#ddd;box-shadow: 10px 10px 8px #888888;padding:20px'>
			<div class='row'>
				<div class='col-sm-4'>
					<h1><i class="fa fa-credit-card-alt" aria-hidden="true"></i></h1>
				</div>
				<div class='col-sm-8'>
				<p><strong>Overall purchases</strong></p>
				<p>Rp. <?= number_format($invoice['jumlah'],2) ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<h3 style='font-family:bebasneue'>Unpaid invoices</h2>
			<p id='unpaid_invoice_total'></p>
<?php
	if(!empty($_GET['id'])){
?>
			<a href='receivable_view.php?id=<?= $customer_id ?>'>
<?php
	} else {
?>
			<a href='receivable_view'>
<?php
	}
?>
				<button type='button' class='button_success_dark' id='view_receivable_table_button' title='View report'><i class='fa fa-eye'></i></button>
			</a>
			<br><br>
<?php
	if(!empty($_GET['id'])){
		$sql_invoice_detail 	= "SELECT invoices.id, invoices.date, invoices.name, invoices.value, invoices.ongkir 
									FROM invoices
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.isdone = '0'";
	} else {
		$sql_invoice_detail 	= "SELECT invoices.id, invoices.date, invoices.name, invoices.value, invoices.ongkir 
									FROM invoices
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE code_delivery_order.customer_id IS NULL AND invoices.isdone = '0'";
	}
	
	$result_invoice_detail 	= $conn->query($sql_invoice_detail);
	if(mysqli_num_rows($result_invoice_detail) == 0){
?>
			<p style='font-family:museo'>There is no unpaid invoice</p>
<?php
	} else {
?>
			<table class='table table-bordered'>
				<tr>
					<th>Date</th>
					<th>Invoice number</th>
					<th>Value</th>
<?php
	if($role == 'superadmin' || $role == 'admin'){
?>
					<th></th>
<?php
	}
?>
				</tr>
<?php
	$total_unpaid			= 0;
	while($invoice_detail 	= $result_invoice_detail->fetch_assoc()){
		$invoice_id			= $invoice_detail['id'];
		$invoice_name		= $invoice_detail['name'];
		$invoice_date		= $invoice_detail['date'];
		$invoice_value		= $invoice_detail['value'];
		$invoice_delivery	= $invoice_detail['ongkir'];
		
		$invoice_total		= $invoice_value - $invoice_delivery;
		
		 $sql_receivable	= "SELECT SUM(value) AS paid FROM receivable WHERE invoice_id = '$invoice_id'";
		 $result_receivable	= $conn->query($sql_receivable);
		 $receivable		= $result_receivable->fetch_assoc();
		 $paid				= $receivable['paid'];
?>
				<tr>
					<td><?= date('d M Y',strtotime($invoice_date)) ?></td>
					<td><?= $invoice_name ?></td>
					<td>Rp. <?= number_format($invoice_total - $paid,2) ?></td>
<?php
	if($role == 'superadmin' || $role == 'admin'){
?>
					<td><button type='button' class='button_default_dark' onclick='open_set_done_wrapper(<?= $invoice_id ?>)' title='set <?= $invoice_name ?> as done'><i class='fa fa-check'></i></button></td>
<?php
	}
?>
				</tr>
<?php
		$total_unpaid		+= $invoice_total - $paid;
	}
?>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#unpaid_invoice_total').html('Rp. ' + numeral(<?= $total_unpaid ?>).format('0,0.00'));
	});
</script>

<?php
	if($role == 'superadmin' || $role == 'admin'){
?>
<div class='full_screen_wrapper' id='set_done_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function open_set_done_wrapper(n){
		$.ajax({
			url:'invoice_set_done_form',
			data:{
				id:n
			},
			type:'POST',
			success:function(response){
				$('#set_done_wrapper .full_screen_box').html(response);
				$('#set_done_wrapper').fadeIn();
			}
		});
	};
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
</script>
<?php
	}
	}
?>