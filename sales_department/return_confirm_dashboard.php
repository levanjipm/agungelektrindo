<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Confirm sales return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales return</h2>
	<p style='font-family:museo'>Confirm sales return</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Delivery order date</th>
			<th>Delivery order number</th>
			<th>Submission date</th>
			<th>Customer</th>
			<th></th>
		</tr>				
<?php
	$sql_return 			= "SELECT * FROM code_sales_return WHERE isconfirm = '0'";
	$result_return 			= $conn->query($sql_return);
	while($row_return 		= $result_return->fetch_assoc()){
		$id					= $row_return['id'];
		$do_id 				= $row_return['do_id'];

		$sql_do 			= "SELECT name,date, customer_id FROM code_delivery_order WHERE id = '$do_id'";
		$result_do 			= $conn->query($sql_do);
		$row_do 			= $result_do->fetch_assoc();
		
		$do_name 			= $row_do['name'];
		$do_date 			= $row_do['date'];
		$customer_id 		= $row_do['customer_id'];
		
		$sql_customer 		= "SELECT name FROM customer WHERE id = '$customer_id'";
		$result_customer 	= $conn->query($sql_customer);
		$row_customer 		= $result_customer->fetch_assoc();
		
		$customer_name		= $row_customer['name'];
?>
		<tr>
			<td><?= (date('d M Y',strtotime($do_date))) ?></td>
			<td><?= $do_name ?></td>
			<td><?= date('d M Y',strtotime($row_return['submission_date'])) ?></td>
			<td><?= $customer_name ?></td>
			<td>
				<button class='button_success_dark' onclick='view_form(<?= $id ?>)'><i class="fa fa-eye" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_form(n){
		$.ajax({
			url:'return_view.php',
			data:{
				id:n
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn(300);
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
		$('.full_screen_box').html('');
	});
</script>
	