<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Confirm sample</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Confirm or cancel sampling</p>
	<hr>
	<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	</script>
	<table class='table table-bordered'>
		<tr>
			<th>Date submited</th>
			<th>Customer name</th>
			<th></th>
		</tr>
<?php
	$sql_code 				= "SELECT * FROM code_sample WHERE issent = '0'";
	$result_code 			= $conn->query($sql_code);
	while($code 			= $result_code->fetch_assoc()){
		$sample_id			= $code['id'];
		$creator_id			= $code['created_by'];
		$customer_id		= $code['customer_id'];
		$sql_created 		= "SELECT name FROM users WHERE id = '$creator_id'";
		$result_created 	= $conn->query($sql_created);
		$created 			= $result_created->fetch_assoc();
		
		$sql_customer 		= "SELECT name FROM customer WHERE id = '$customer_id'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$creator			= $created['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['date'])) ?></td>
			<td><?= $customer_name ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='view_sample_detail(<?= $sample_id ?>)'><i class="fa fa-eye" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<div class='full_screen_wrapper'>
	<button type='button' class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_sample_detail(n){
		$.ajax({
			url:'sample_confirm_view.php',
			data:{
				id:n
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn(300);
			}
		})
	};
	
	function confirm(n){
		$.ajax({
			url:"sample_confirm_input.php",
			data:{
				id: n,
				type : 1,
			},
			type: 'POST',
			success:function(response){
				// location.reload();
			},
		})
	};
	
	function cancel(n){
		$.ajax({
			url:"sample_confirm_input.php",
			data:{
				id: n,
				type : 2,
			},
			type: 'POST',
			success:function(response){
				// location.reload();
			},
		})
	};
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
</script>