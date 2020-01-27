<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$id		= $_GET['id'];
	$sql	= "SELECT id FROM code_project WHERE id = '$id'";
	$result	= $conn->query($sql);
	
	if(empty($_GET['id']) || mysqli_num_rows($result) == 0){
?>
<script>
	window.location.href='/agungelektrindo/project_archives_view';
</script>
<?php
	} else {
		$sql		= "SELECT project_name, customer_id, description FROM code_project WHERE id = '$id'";
		$result		= $conn->query($sql);
		$row		= $result->fetch_assoc();
		
		$project_name	= $row['project_name'];
		$project_desc	= $row['description'];
		$customer_id	= $row['customer_id'];
		
		$sql_customer	= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p style='font-family:museo'>View project</p>
	<hr>
	
	<label>Project</label>
	<p style='font-family:museo'><?= $project_name ?></p>
	<p style='font-family:museo'><?= $project_desc ?></p>
	
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
<?php
	$sql		= "SELECT * FROM code_project WHERE major_id = '$id'";
	$result		= $conn->query($sql);
	$count		= mysqli_num_rows($result);
	
	if($count == 0){
?>
	<p style='font-family:museo'>This project has no child project</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>Project name</th>
			<th>Process</th>
			<th>Sent date</th>
			<th>Document</th>
			<th>Value</th>
		</tr>
<?php
		while($row	= $result->fetch_assoc()){
			$project_id			= $row['id'];
			$project_name_child	= $row['project_name'];
			$project_desc_child	= $row['description'];
			$date_start			= $row['start_date'];
			$date_end			= $row['end_date'];
			
			$sql_invoice		= "SELECT code_delivery_order.name, code_delivery_order.date, invoices.value FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
									WHERE code_delivery_order.project_id = '$project_id'";
			$result_invoice		= $conn->query($sql_invoice);
			$invoice			= $result_invoice->fetch_assoc();
			
			$value				= $invoice['value'];
			$date				= $invoice['date'];
			$document			= $invoice['name'];
			
			if($project_desc_child == '' || empty($row['description'])){
				$project_desc_child	= '<i>No description available</i>';
			}
?>
		<tr>
			<td><?= $project_name_child . ' - ' . $project_desc_child ?></td>
			<td><?= date('d M Y',strtotime($date_start)) . ' - ' . date('d M Y',strtotime($date_end)) ?></td>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $document ?></td>
			<td>Rp. <?= number_format($value,2) ?></td>
		</tr>
<?php
		}
?>
	</table>
<?php
	}
	
	$sql					= "SELECT * FROM project_delivery_order WHERE project_id = '$id'";
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
<?php 
	}
?>
<div class='full_screen_wrapper' id='view_delivery_order_wrapper'>
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
				$('#view_delivery_order_wrapper .full_screen_box').html(response);
				$('#view_delivery_order_wrapper').fadeIn();
			}
		});
	}
	
	$('#view_delivery_order_wrapper .full_screen_close_button').click(function(){
		$('#view_delivery_order_wrapper').fadeOut();
	});
	
	
	$('#close_notif_bar').click(function(){
		$('#done_wrapper').fadeOut();
	});
</script>	
<?php
	}
?>