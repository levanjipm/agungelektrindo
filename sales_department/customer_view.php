<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$customer_id			= (int)$_GET['id'];
	$sql_customer			= "SELECT * FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer				= $result_customer->fetch_assoc();

	if(mysqli_num_rows($result_customer) == 0){
?>
<head>
	<title>Customer not found!</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>Customer data</p>
	<hr>
	<p style='font-family:museo'>Customer not found!</p>
</div>
<?php
	} else {
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
		$customer_phone		= $customer['phone'];
		$remaining_debt		= 0;
		
		$sql_debt			= "SELECT invoices.id,invoices.value, invoices.ongkir FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id WHERE invoices.isdone = '0' AND code_delivery_order.customer_id = '$customer_id'";
		$result_debt		= $conn->query($sql_debt);
		while($debt			= $result_debt->fetch_assoc()){
			$remaining_debt += $debt['value'] + $debt['ongkir'];
			$invoice_id		= $debt['id'];
			$sql_receive	= "SELECT SUM(value) as paid FROM receivable WHERE invoice_id = '$invoice_id'";
			$result_receive	= $conn->query($sql_receive);
			$receive		= $result_receive->fetch_assoc();
			
			$paid			= $receive['paid'];
			
			$remaining_debt -= $receive['paid'];
		}
		$date_difference		= 0;
		$i						= 0;
		$sql_payment			= "SELECT invoices.date, invoices.date_done FROM invoices
									JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
									WHERE code_delivery_order.customer_id = '$customer_id' and year(invoices.date_done) > '2000'";
		$result_payment			= $conn->query($sql_payment);
		while($payment			= $result_payment->fetch_assoc()){			
			$invoice_date		= strtotime($payment['date']);
			$invoice_done		= strtotime($payment['date_done']);
			$date_difference	+= $invoice_done - $invoice_date;
			$i++;
		}
		
		if($i == 0){
			$average_payment	= 'No history transaction found';
		} else {
			$average				= $date_difference / $i;
			$average_payment	= number_format($average / (60 * 60 * 24));
		}
?>
<head>
	<title>View <?= $customer_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>Customer data</p>
	<hr>
	<div class='row'>
		<div class='col-sm-6 col-xs-12'>
			<label>Name</label>
			<p style='font-family:museo'><?= $customer_name ?></p>
			<p style='font-family:museo'><?= $customer_address ?></p>
			<p style='font-family:museo'><?= $customer_city ?></p>
			<p style='font-family:museo'><?= $customer_phone ?></p>
			
			<label>Payment</label>
			<p style='font-family:museo'><?= $average_payment ?> days</p>

			
			<label>Remaining debt</label>
			<p style='font-family:museo'>Rp. <?= number_format($remaining_debt,2) ?></p>
			
			<label>History of sales</label>
			<div id='sales_chart'></div>
			
			<label>Date start</label>
			<input type='date' class='form-control' id='start_date'>
			
			<label>Date end</label>
			<input type='date' class='form-control' id='end_date'>
			
			<br>
			<button type='button' class='button_default_dark' id='calculate_sales_button'><i class='fa fa-search'></i></button>
			<br><br>
			<div id='sales_report_div' style='font-weight:bold'></div>
			<script>
				$('#calculate_sales_button').click(function(){
					if($('#start_date').val() == ''){
						alert('Please insert date');
						$('#start_date').focus();
						return false;
					} else if($('#end_date').val() == ''){
						alert('Please insert date');
						$('#end_date').focus();
						return false;
					} else {
						$.ajax({
							url:'customer_view_calculate',
							data:{
								customer_id:<?= $customer_id ?>,
								start_date:$('#start_date').val(),
								end_date:$('#end_date').val()
							},
							type:'POST',
							success:function(response){
								$('#sales_report_div').html('Rp. ' + numeral(response).format('0,0.00'));
							}
						});
					}
				});
			</script>
		</div>
		<div class='col-sm-6 col-xs-12'>
			<label>Frequent item</label>
<?php
	$sql		= "SELECT id FROM code_delivery_order WHERE customer_id = '$customer_id' AND project_id IS NULL";
	$result		= $conn->query($sql);
	$check		= mysqli_num_rows($result);
	
	if($check > 0){
?>
			<table class='table table-bordered'>
				<tr>
					<th>Reference</th>
					<th>Description</th>
					<th>Monthly demand</th>
				</tr>
<?php
	$sql_delivery_order		= "SELECT MIN(date) as minimum_date, MAX(date) as maximum_date FROM code_delivery_order WHERE customer_id = '$customer_id'";
	$result_delivery_order	= $conn->query($sql_delivery_order);
	$row_delivery_order		= $result_delivery_order->fetch_assoc();
	
	$min_date				= strtotime($row_delivery_order['minimum_date']);
	$max_date				= strtotime($row_delivery_order['maximum_date']);
	
	$date_difference		= abs(($max_date - $min_date) / (60*60*24*30));
	
	$sql_detail				= "SELECT delivery_order.reference, SUM(delivery_order.quantity) as quantity, itemlist.description FROM code_delivery_order
								INNER JOIN delivery_order ON code_delivery_order.id = delivery_order.do_id
								JOIN itemlist ON delivery_order.reference = itemlist.reference
								WHERE code_delivery_order.customer_id = '$customer_id' GROUP BY delivery_order.reference ORDER BY quantity DESC LIMIT 8";
	$result_detail			= $conn->query($sql_detail);
	while($detail			= $result_detail->fetch_assoc()){
	
		$reference				= $detail['reference'];
		$quantity				= $detail['quantity'];
		$description			= $detail['description'];
		if($date_difference		< 1){
			$average_quantity	= $quantity;
		} else {
			$average_quantity	= $quantity / $date_difference;
		}	
?>
				<tr>
					<td><?= $reference ?></td>
					<td><?= $description ?></td>
					<td><?= number_format($average_quantity,2) ?></td>
				</tr>
<?php
	}
?>
			</table>
			<label>Last transaction</label>
			<table class='table table-bordered'>
				<tr>
					<th>Date</th>
					<th>Name</th>
				</tr>
<?php
	$sql_delivery_order			= "SELECT date, name FROM code_delivery_order WHERE customer_id = '$customer_id' ORDER BY date ASC LIMIT 5";
	$result_delivery_order		= $conn->query($sql_delivery_order);
	while($delivery_order		= $result_delivery_order->fetch_assoc()){
	$do_name					= $delivery_order['name'];
	$do_date					= $delivery_order['date'];
?>
				<tr>
					<td><?= date('d M Y',strtotime($do_date)) ?></td>
					<td><?= $do_name ?></td>
				</tr>
<?php
	}
?>
			</table>
<?php
	} else {
?>
			<p style='font-family:museo'>There is no record</p>
<?php
	}
?>
		</div>
	</div>
</div>
<script>
	$.ajax({
		url:'customer_view_chart.php',
		data:{
			customer_id:<?= $customer_id ?>
		},
		success:function(response){
			$('#sales_chart').html(response);
		}
	});
</script>
<?php
	}
?>