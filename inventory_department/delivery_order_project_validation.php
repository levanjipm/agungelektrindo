<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$project_id		= $_POST['project_id'];
	$sql 			= "SELECT project_name, taxing, customer_id, description, start_date, end_date FROM code_project WHERE id = '$project_id'";
	$result 		= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
		<script>
			window.history.back();
		</script>
<?php
	} else {
		$row 					= $result->fetch_assoc();
		$taxing 				= $row['taxing'];
		$customer_id 			= $row['customer_id'];
		$project_name			= $row['project_name'];
		$project_description	= $row['description'];
		$start_date				= $row['start_date'];
		$end_date				= $row['end_date'];
			
		$sql_customer 			= "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer 		= $conn->query($sql_customer);
		$customer 				= $result_customer->fetch_assoc();
		
		$customer_name			= $customer['name'];
		$customer_address		= $customer['address'];
		$customer_city			= $customer['city'];
	}
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid = GUID();
?>
<head>
	<title>Create delivery order for <?= $project_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p style='font-family:museo'>Create project delivery order</p>
	<hr>
	
	<label>Delivery order date</label>
	<form id='send_project_form' method='POST' action='delivery_order_project_input'>
		<input type='hidden' value='<?= $guid ?>' name='guid'>
		<input type='hidden' value='<?= $project_id ?>' name='project_id'>
		<input type='date' class='form-control' name='project_send_date' id='project_send_date'>
	</form>
	<br>
	
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>

	<label>Project</label>
	<p style='font-family:museo'><?= $project_name ?></p>
	<p style='font-family:museo'><?= $project_description ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($start_date)) . ' - ' . date('d M Y',strtotime($end_date)) ?></p>
	<br>
	<button type='button' class='button_success_dark' id='send_project_button'>Send</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h2 style='color:red;font-size:2em'><i class='fa fa-exclamation'></i></h2>
		<p style='font-family:museo'>Are you sure to confirm this delivery?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
	
<script>
	$('#send_project_button').click(function(){
		if($('#project_send_date').val() == ''){
			alert('Please insert valid date');
			$('#project_send_date').focus();
			return false;
		} else {
			var window_height		= $(window).height();
			var notif_height		= $('.full_screen_notif_bar').height();
			var difference			= window_height - notif_height;
			
			$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
			$('.full_screen_wrapper').fadeIn();
		}
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$('#send_project_form').submit();
	});
</script>