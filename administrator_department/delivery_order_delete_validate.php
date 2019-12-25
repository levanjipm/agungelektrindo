<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
	$delivery_order_id			= $_POST['id'];
	
	
	$sql_delivery_order			= "SELECT * FROM code_delivery_order WHERE id = '$delivery_order_id'";
	$result_delivery_order		= $conn->query($sql_delivery_order);
	$delivery_order				= $result_delivery_order->fetch_assoc();
	
	$do_name					= $delivery_order['name'];
	$do_date					= $delivery_order['date'];
	$customer_id				= $delivery_order['customer_id'];
	
	$sql_status					= "SELECT id FROM stock_value_out WHERE customer_id = '$customer_id' AND document = '$do_name'";
	$result_status				= $conn->query($sql_status);
	$status						= mysqli_num_rows($result_status);
	
	if(empty($_POST['id']) || $status == 0){
?>
	<script>
		window.location.href='delivery_order_delete_dashboard';
	</script>
<?php
	}
?>
<head>
	<title>Delete <?= $do_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Delivery order</h2>
	<p style='font-family:museo'>Delete delivery order</p>
	<hr>
	<label>Delivery order date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($do_date)) ?></p>
	
	<label>Delivery order name</label>
	<p style='font-family:museo'><?= $do_name ?></p>
	
	<label>Detail</label>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql			= "SELECT delivery_order.reference, delivery_order.quantity, itemlist.description FROM delivery_order 
						JOIN itemlist ON delivery_order.reference = itemlist.reference	
						WHERE delivery_order.do_id = '$delivery_order_id'";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$description	= $row['description'];
		$quantity		= $row['quantity'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to delete this delivery order?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Submit</button>
	</div>
</div>
<form action='delivery_order_delete_input' method='POST' id='delivery_order_delete_form'>
	<input type='hidden' value='<?= $delivery_order_id ?>' name='id'>
</form>
<script>
	$('#submit_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		
		$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn(300);
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
	
	$('#confirm_button').click(function(){
		$('#delivery_order_delete_form').submit();
	});
</script>