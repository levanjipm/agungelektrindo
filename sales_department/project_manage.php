<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$project_id				= $_POST['id'];
	$sql_code_project		= "SELECT * FROM code_project WHERE id = '$project_id'";
	$result_code_project	= $conn->query($sql_code_project);
	$code_project			= $result_code_project->fetch_assoc();
	
	$project_name			= $code_project['project_name'];
	$project_description	= $code_project['description'];
	$customer_id			= $code_project['customer_id'];
	
	$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer				= $result_customer->fetch_assoc();
	
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
	
	$sql_child_project		= "SELECT id FROM code_project WHERE major_id = '$project_id'";
	$result_child_project	= $conn->query($sql_child_project);

	$child					= mysqli_num_rows($result_child_project);
?>
<head>
	<title>Manage <?= $project_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p style='font-family:museo'>Manage project</p>
	<hr>
	<label>Project data</label>
	<p style='font-family:museo'><?= $project_name ?></p>
	<p style='font-family:museo'><?= $project_description ?></p>
	<p style='font-family:museo'>This project has <?= $child ?> child(s) project</p>
	
	<label>Customer data</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
<?php
	$sql					= "SELECT * FROM project_delivery_order WHERE project_id = '$project_id'";
	$result					= $conn->query($sql);
	$number_of_delivery_order	= mysqli_num_rows($result);
	
	if($number_of_delivery_order > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Delivery order name</th>
		</tr>
<?php
		while($row			= $result->fetch_assoc()){
			$do_id			= $row['id'];
			$date			= $row['date'];
			$do_name		= $row['name'];
			$isconfirm		= $row['isconfirm'];
			if($isconfirm	== 1){
?>
		<tr>
<?php
			} else {
?>
		<tr class='danger'>
<?php 
			}
?>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $do_name ?></td>
			<td><button type='button' class='button_success_dark' onclick='view_delivery_order(<?= $do_id ?>)'><i class='fa fa-eye'></i></button>
		</tr>
<?php 
		}
?>
	</table>
	<button type='button' class='button_default_dark' id='set_done_button'>Set done</button>
</div>
<div class='full_screen_wrapper'>
	<button type='button' class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_delivery_order(n){
		$.ajax({
			url:'delvery_order_project_view.php',
			type:'POST',
			data:{
				delivery_order_id:n
			},
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn();
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
</script>
<?php 
	}
?>
	