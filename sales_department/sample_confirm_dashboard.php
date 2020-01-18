<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$sql_code 				= "SELECT DISTINCT(sample.code_id) as id
								FROM code_sample JOIN sample ON sample.code_id = code_sample.id
								WHERE sample.status = '0' AND code_sample.isconfirm = '0'";
	$result_code 			= $conn->query($sql_code);
?>
<head>
	<title>Confirm sample</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Confirm or cancel sampling</p>
	<hr>
<?php
	if(mysqli_num_rows($result_code) > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Customer name</th>
			<th></th>
		</tr>
<?php
	$sql_code 				= "SELECT DISTINCT(sample.code_id) as id, customer.name
								FROM code_sample JOIN sample ON sample.code_id = code_sample.id
								JOIN customer ON code_sample.customer_id = customer.id
								WHERE sample.status = '0' AND code_sample.isconfirm = '0'";
	$result_code 			= $conn->query($sql_code);
	while($code 			= $result_code->fetch_assoc()){
		$customer_name		= $code['name'];
		$sample_id			= $code['id'];
?>
		<tr>
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
	<div class='full_screen_box_loader_wrapper'><div class='full_screen_box_loader'></div></div>
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
			beforeSend:function(){
				$('.full_screen_box_loader_wrapper').show();
			},
			success:function(response){
				location.reload();
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
			beforeSend:function(){
				$('.full_screen_box_loader_wrapper').show();
			},
			success:function(response){
				location.reload();
			},
		})
	};
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
</script>
<?php
	} else {
?>
	<p style='font-family:museo'>There is no sample to be confirm</p>
<?php
	}
?>
</div>