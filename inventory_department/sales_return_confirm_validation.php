<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$sales_return_id		= $_POST['id'];
	$sql					= "SELECT id,document,code_sales_return_id FROM code_sales_return_received WHERE id='$sales_return_id'";
	$result					= $conn->query($sql);
	$return					= $result->fetch_assoc();
	
	$document				= $return['document'];
	$code_sales_return_id	= $return['code_sales_return_id'];
	$return_id				= $return['id'];
	$sql_code_return		= "SELECT do_id, reason, other FROM code_sales_return WHERE id = '$code_sales_return_id'";
	$result_code_return		= $conn->query($sql_code_return);
	$row_return				= $result_code_return->fetch_assoc();
		
	$do_id					= $row_return['do_id'];
	$reason_id				= $row_return['reason'];
	$other_reason			= $row_return['other'];
	
	if($reason_id		!= 5){
		$sql_reason			= "SELECT * FROM reason WHERE id = '$reason_id'";
		$result_reason		= $conn->query($sql_reason);
		$row_reason			= $result_reason->fetch_assoc();
		
		$reason				= $row_reason['name'];
	} else {
		$reason				= $other_reason;
	}			
	
	$sql_do				= "SELECT customer_id, name, date FROM code_delivery_order WHERE id = '$do_id'";
	$result_do			= $conn->query($sql_do);
	$do					= $result_do->fetch_assoc();
	
	$do_name			= $do['name'];
	$do_date			= $do['date'];
	
	$customer_id		= $do['customer_id'];
	
	$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
	$result_customer	= $conn->query($sql_customer);
	$customer			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	$customer_address	= $customer['address'];
	$customer_city		= $customer['city'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales return</h2>
	<p style='font-family:museo'>Confirm sales return</p>
	<hr>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name	?></p>
	<p style='font-family:museo'><?= $customer_address	?></p>
	<p style='font-family:museo'><?= $customer_city	?></p>

	<label>Delivery order</label>
	<p style='font-family:museo'><?= $do_name	?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($do_date)) ?></p>
	
	<label>Return reason</label>
	<p style='font-family:museo'><?= $reason ?></p>
	
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
<?php
	$sql				= "SELECT sales_return_received.quantity, delivery_order.reference, itemlist.description FROM sales_return_received 
							JOIN sales_return ON sales_return_received.sales_return_id = sales_return.id
							JOIN delivery_order ON sales_return.delivery_order_id = delivery_order.id
							JOIN itemlist ON delivery_order.reference = itemlist.reference
							WHERE sales_return_received.received_id = '$sales_return_id'";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$description	= $row['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $quantity ?></td>
				<td><?= $description ?></td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
	<button class='button_danger_dark' id='cancel_return_button'>Cancel</button>
	<button class='button_success_dark' id='submit_return_button'>Submit</button>
</div>
<div class='full_screen_wrapper' id='delete_notification'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this sales return?</p>
		<button class='button_danger_dark' id='close_notif_bar_button_cancel'>Check again</button>
		<button class='button_success_dark' id='submit_close'>Confirm</button>
	</div>
</div>
<div class='full_screen_wrapper' id='confirm_notification'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:green'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this sales return?</p>
		<button class='button_danger_dark' id='close_notif_bar_button_confirm'>Check again</button>
		<button class='button_success_dark' id='submit_confirm'>Confirm</button>
	</div>
</div>
<script>
	$('#cancel_return_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#delete_notification .full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('#delete_notification').fadeIn(300);
	});
	
	$('#close_notif_bar_button_cancel').click(function(){
		$('#delete_notification').fadeOut(300);
	});
	
	$('#submit_return_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#confirm_notification .full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('#confirm_notification').fadeIn(300);
	});
	
	$('#close_notif_bar_button_confirm').click(function(){
		$('#confirm_notification').fadeOut(300);
	});
	
	$('#submit_close').click(function(){
		$.ajax({
			url:'sales_return_delete.php',
			data:{
				return_id:<?= $sales_return_id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('#submit_close').attr('disabled',true);
				$('#submit_confirm').attr('disabled',true);
				$('#cancel_return_button').attr('disabled',true);
				$('#submit_return_button').attr('disabled',true);
			},
			success:function(){
				window.location.href = 'return_confirm_dashboard';
			}
		})
	});
	
	$('#submit_confirm').click(function(){
		$.ajax({
			url:'sales_return_confirm_input.php',
			data:{
				return_id:<?= $sales_return_id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('#submit_close').attr('disabled',true);
				$('#submit_confirm').attr('disabled',true);
				$('#cancel_return_button').attr('disabled',true);
				$('#submit_return_button').attr('disabled',true);
			},
			success:function(){
				window.location.href = 'return_confirm_dashboard';
			}
		})
	});
</script>