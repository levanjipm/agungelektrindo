<?php
	include('../codes/connect.php');
?>
<style>
	.btn-confirm{
		background-color:#008080;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		padding:5px 10px;
		outline:none;
		border:none;
	}
</style>
<div class='notification_wrapper'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to <strong>whitelist</strong> this customer?</h2>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-confirm' id='confirm_button'>Confirm</button>
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
	$sql_customer			= "SELECT * FROM customer WHERE is_blacklist = '1'";
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
		$('.notification_wrapper').fadeIn();
		$('#customer_id').val(n);
	}
	
	$('.btn-back').click(function(){
		$('.notification_wrapper').fadeOut();
	});
	
	$('.btn-confirm').click(function(){
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
				$('.btn-confirm').attr('disabled',false);
				$('.btn-back').click();
				$('#whitelist_button').click();
			}
		});
	});
</script>