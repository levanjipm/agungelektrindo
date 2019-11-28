<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
?>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-times" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to <strong>blacklist</strong> this customer?</p>
		<br>
		<button type='button' class='button_danger_dark' id='close_notification_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Delete</button>
		<input type='hidden' id='customer_id'>
	</div>
</div>
<table class='table table-bordered'>
	<thead>
		<tr>
			<th>Customer name</th>
			<th>Address</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php
	$sql_customer			= "SELECT * FROM customer WHERE is_blacklist = '0'";
	$result_customer		= $conn->query($sql_customer);
	while($customer			= $result_customer->fetch_assoc()){
		$customer_id		= $customer['id'];
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
?>	
		<tr>
			<td><?= $customer_name ?></td>
			<td><?= $customer_address . " " . $customer_city ?></td>
			<td>
				<button type='button' class='button_danger_dark' onclick='black_list_customer(<?= $customer_id ?>)'>
					<i class="fa fa-ban" aria-hidden="true"></i>
				</button>
			</td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
<script>
	function black_list_customer(n){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
		$('#customer_id').val(n);
	}
	
	$('#close_notification_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'customer_black_list_input.php',
			data:{
				customer_id	: $('#customer_id').val()
			},
			type:'POST',
			beforeSend:function(){
				$('.btn-delete').attr('disabled',true);
			},
			success:function(){
				$('.btn-delete').attr('disabled',false);
				$('.btn-back').click();
				$('#blacklist_button').click();
			}
		});
	});
</script>