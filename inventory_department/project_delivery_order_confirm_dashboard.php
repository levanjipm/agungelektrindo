<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Confirm project delivery order</title>
</head>
<div class="main">
	<h2 style='font-family:bebasneue'>Project Delivery Order</h2>
	<p>Confirm project delivery order</p>
	<hr>
	<div class="row">
		<div class='col-sm-8'>
			<div class='row'>
<?php
	$sql = "SELECT * FROM project_delivery_order WHERE isconfirm = '0'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row_do 				= $results->fetch_assoc()){
			$project_id 			= $row_do['project_id'];
			$sql_code_project 		= "SELECT customer_id,project_name FROM code_project WHERE id = '" . $project_id . "'";
			$result_code_project 	= $conn->query($sql_code_project);
			$code_project 			= $result_code_project->fetch_assoc();
			
			$customer_id 			= $code_project['customer_id'];
			$sql_customer 			= "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
			$result_customer 		= $conn->query($sql_customer);
			$row_customer 			= $result_customer->fetch_assoc();
			$customer_name 			= $row_customer['name'];
?>
				<div class='col-sm-3' style='text-align:center'>
					<h1 style='font-size:6em;'><i class='fa fa-file-text-o'></i></h1>
					<p style='font-family:museo'><?= $code_project['project_name'];?></p>
					<p style='font-family:museo'><b><?= $customer_name?></b></p>	
					<button type='button' class='button_default_dark' onclick='confirm_validate(<?= $row_do['id'] ?>)'><i class='fa fa-eye'></i></button>
				</div>
<?php
		}
?>
			</div>
		</div>
		<input type='hidden' value='' name='id'>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	function confirm_validate(n){
		$.ajax({
			url:'project_delivery_order_confirm_view.php',
			data:{
				delivery_order_id:n,
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn();
				
			},
		});
	}
</script>
<?php
	} else {
?>
			<div class="col-sm-6 offset-lg-3" style="text-align:center">
<?php
		echo ('There are no delivery order need to be approved');
?>
			</div>	
<?php
	}
?>
	</div>
</div>