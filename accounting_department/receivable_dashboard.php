<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Receivable</title>
</head>
<style>
	.garis_wrapper{
		transition:0.3s all ease;
		margin-top:10px;
	}
	
	.garis_wrapper:hover{
		background-color:#afdfe6;
		transition:0.3s all ease;
	}

	.garis{
		height:20px;
		box-shadow: 2px 2px 4px 2px rgba(20,20,20,0.4);
	}
</style>
<?php
	$maximum 	= 0;
	$total 		= 0;
	$sql_invoice	 		= "SELECT SUM(invoices.value + invoices.ongkir) AS maximum, code_delivery_order.customer_id
								FROM invoices
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								WHERE invoices.isdone = '0'
								GROUP by code_delivery_order.customer_id";
	$result_invoice 		= $conn->query($sql_invoice);
	
	$number					= mysqli_num_rows($result_invoice);
	
	while($invoice 			= $result_invoice->fetch_assoc()){
		$customer_id		= $invoice['customer_id'];
		$sql_receivable		= "SELECT SUM(receivable.value) as paid FROM receivable 
								JOIN invoices ON receivable.invoice_id = invoices.id
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.isdone = '0'";
		$result_receivable	= $conn->query($sql_receivable);
		$receivable			= $result_receivable->fetch_assoc();
		$paid				= $receivable['paid'];
		
		$invoice_value		= $invoice['maximum'] - $paid;
		
		if($invoice_value > $maximum){
			$maximum = $invoice_value;
		}
		$total = $total + $invoice_value;
	}
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-4'>
			<h2 style='font-family:bebasneue'>Account of receivable</h2>
			<p>Rp. <?= number_format($total,2) ?></p>
		</div>
		<div class='col-sm-4 col-sm-offset-4'>
			<label>Customer</label><br>
			<select class='form-control' id='customer_id' style='width:80%;display:inline-block'>
<?php
	$sql			= "SELECT id,name FROM customer ORDER BY name ASC";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$id			= $row['id'];
		$name		= $row['name'];
?>
				<option value='<?= $id ?>'><?= $name ?></option>
<?php
	}
?>
			</select>
			<button type='button' class='button_default_dark' id='view_receivable'><i class='fa fa-search'></i></button>
		</div>
	</div>			
	<hr>
	<script>
		$('#view_receivable').click(function(){
			var customer_id		= $('#customer_id').val();
			var link			= "customer_view.php?id=" + customer_id;
			window.location.href=link;
		});
		
		function change_customer(){
			$('#customer_to_view').val($('#seleksi').val());
		}
		function submiting(){
			if($('#customer_to_view').val() == 0){
				alert('Please insert a customer!');
				return false;
			} else {
				$('#customer_form').submit();
			}
		}
	</script>
<?php
	$timeout = 0;
	$i = 1;
	$receivable_array			= array();
	$sql_invoice 				= "SELECT SUM(invoices.value + invoices.ongkir) AS jumlah, code_delivery_order.customer_id, invoices.id 
									FROM invoices 
									JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
									WHERE invoices.isdone = '0'
									GROUP BY code_delivery_order.customer_id ORDER BY jumlah DESC";
	$result_invoice 			= $conn->query($sql_invoice);
	while($invoice 				= $result_invoice->fetch_assoc()){
		$customer_id			= $invoice['customer_id'];
		$invoice_value			= $invoice['jumlah'];
		$sql_receive 			= "SELECT SUM(receivable.value) AS bayar_total FROM receivable 
									JOIN invoices ON receivable.invoice_id = invoices.id 
									JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
									WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.isdone = '0'";
		$result_receive 		= $conn->query($sql_receive);
		$receive		 		= $result_receive->fetch_assoc();
		$payment_received		= $receive['bayar_total'];
		$invoice_payment		= $invoice_value - $payment_received;
		$width 					= $invoice_payment;
		$receivable_array[$customer_id]		= $width;
	};
	
	arsort($receivable_array);
	foreach($receivable_array as $bar){
		$r		= ($i * 161 / $number) + 14;
		$g		= ($i * 160 / $number) + 63;
		$b		= ($i * 128 / $number) + 102;
		$rgb	= $r . ',' . $g . ',' . $b;
		$customer_id				= key($receivable_array);
		$sql_customer			 	= "SELECT name FROM customer WHERE id = '$customer_id'";
		$result_customer 			= $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		if($customer_id == 0){
			$customer_name			= 'Retail';
		} else {
			$customer_name			= $customer['name'];
		}
		
		if($customer_id != 0){
?>
	<div class='row garis_wrapper' onclick='view_receivable(<?= $customer_id ?>)' style='cursor:pointer'>
<?php
		} else {
?>
	<a href='customer_view.php' style='color:black;text-decoration:none'>
		<div class='row garis_wrapper'>
<?php
		}
?>
		<div class='col-sm-3'><?= $customer_name ?></div>
		<div class='col-sm-6'><div class='row garis' style='width:0%;background-color:rgb(<?= $rgb ?>)' id='garis<?= $customer_id ?>'></div>
		</div>
		<div class='col-sm-2'>Rp. <?= number_format($bar,2) ?></div>
	</div>
<?php
	if($customer_id == 0){
?>
	</a>
<?php
	}
?>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$("#garis<?= $customer_id ?>").animate({
					width: '<?= $bar * 100 / $maximum ?>%'
				})
			},<?= $timeout ?>)
		});
	</script>
<?php
		$timeout = $timeout + 10;
		next($receivable_array);
		$i++;
	}
?>
</div>

<div class='full_screen_wrapper' id='view_receivable_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_receivable(n){
		$.ajax({
			url:'receivable_dashboard_view',
			data:{
				id:n,
			},
			type:"GET",
			success:function(response){
				$('#view_receivable_wrapper .full_screen_box').html(response);
				$('#view_receivable_wrapper').fadeIn();
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
</script>