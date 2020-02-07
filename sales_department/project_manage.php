<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$project_id				= $_POST['id'];
	$sql_code_project		= "SELECT * FROM code_project WHERE id = '$project_id'";
	$result_code_project	= $conn->query($sql_code_project);
	$code_project			= $result_code_project->fetch_assoc();
	
	$project_name			= $code_project['project_name'];
	$project_description	= $code_project['description'];
	$customer_id			= $code_project['customer_id'];
	$isdone					= $code_project['isdone'];
	$issent					= $code_project['issent'];
	
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
<script>
	$('#project_side').click();
	$('#project_manage_dashboard').find('button').addClass('activated');
</script>
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
<?php 
	}
?>
<div class='full_screen_wrapper' id='view_delivery_order_wrapper'>
	<button type='button' class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<?php
	if($isdone == 0 && $issent == 0){
?>
	<label>Set project as done</label>
	<input type='date' class='form-control' id='date_done'>
	<br>
	<button type='button' class='button_default_dark' id='set_done_button'>Set done</button>
	
	<div class='full_screen_wrapper' id='done_wrapper'>
		<div class='full_screen_notif_bar'>
			<h2 style='color:red;font-size:2em;'><i class='fa fa-exclamation'></i></h2>
			<p style='font-family:museo'>Are you sure to set this project as done?</p>
			<button type='button' class='button_danger_dark' id='close_notif_bar'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_done_button'>Submit</button>
		</div>
	</div>
	<script>
		$('#set_done_button').click(function(){
			if($('#date_done').val() == ''){
				alert('Please insert date value');
				$('#date_done').focus();
				return false;
			} else {
				var window_height		= $(window).height();
				var notif_height		= $('#done_wrapper .full_screen_notif_bar').height();
				var difference			= window_height - notif_height;
				
				$('#done_wrapper .full_screen_notif_bar').css('top', 0.7 * difference / 2);
				$('#done_wrapper').fadeIn();
			};
		});
		
		$('#confirm_done_button').click(function(){
			$.ajax({
				url:'project_set_done.php',
				data:{
					project_id: <?= $project_id ?>,
					date: $('#date_done').val()
				},
				type:'POST',
				beforeSend:function(){
					$('button').attr('disabled',true);
				},
				success:function(){
					window.location.href='/agungelektrindo/sales_department/project_manage_dashboard';
				}
			});
		});
	</script>
<?php
	} else if($isdone == 1 && $issent == 0 && $role == 'superadmin'){
?>
	<label>Set project as sent</label>
	<input type='date' class='form-control' id='date_sent'>
	<br>
	<button type='button' class='button_default_dark' id='set_sent_button'>Set sent</button>
	
	<div class='full_screen_wrapper' id='done_wrapper'>
		<div class='full_screen_notif_bar'>
			<h2 style='color:red;font-size:2em;'><i class='fa fa-exclamation'></i></h2>
			<p style='font-family:museo'>Are you sure to set this project as sent?</p>
			<button type='button' class='button_danger_dark' id='close_notif_bar'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_sent_button'>Submit</button>
		</div>
	</div>
	<script>
		$('#set_sent_button').click(function(){
			if($('#date_sent').val() == ''){
				alert('Please insert date value');
				$('#date_sent').focus();
				return false;
			} else {
				var window_height		= $(window).height();
				var notif_height		= $('#done_wrapper .full_screen_notif_bar').height();
				var difference			= window_height - notif_height;
				
				$('#done_wrapper .full_screen_notif_bar').css('top', 0.7 * difference / 2);
				$('#done_wrapper').fadeIn();
			};
		});
		
		$('#confirm_sent_button').click(function(){
			$.ajax({
				url:'project_set_sent.php',
				data:{
					project_id: <?= $project_id ?>,
				},
				type:'POST',
				beforeSend:function(){
					$('button').attr('disabled',true);
				},
				success:function(){
					window.location.href='/agungelektrindo/sales_department/project_manage_dashboard';
				}
			});
		});
	</script>	
<?php
	}
?>
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