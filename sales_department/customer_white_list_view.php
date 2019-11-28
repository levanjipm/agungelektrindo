<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	$sql_customer			= "SELECT * FROM customer WHERE is_blacklist = '1'";
	$result_customer		= $conn->query($sql_customer);
?>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to <strong>whitelist</strong> this customer?</p>
		<br>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
		<input type='hidden' id='customer_id'>
	</div>
</div>
<?php
	if(mysqli_num_rows($result_customer) == 0){
?>
	<p style='font-family:museo'>There is no customer to white list</p>
<?php
	} else {
?>
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
				<button type='button' class='button_success_dark' onclick='whitelist_customer(<?= $customer_id ?>)'>
					<i class="fa fa-check" aria-hidden="true"></i>
				</button>
			</td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
<script>
	function whitelist_customer(n){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
		$('#customer_id').val(n);
	}
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'customer_white_list_input.php',
			data:{
				customer_id	: $('#customer_id').val()
			},
			type:'POST',
			beforeSend:function(){
				$('.btn-confirm').attr('disabled',true);
			},
			success:function(){
				$('#confirm_button').attr('disabled',false);
				$('#close_notif_button').click();
				$('#whitelist_button').click();
			}
		});
	});
</script>
<?php
	}
?>