<?php	
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$customer_id			= $_POST['customer'];
	
	$sql_customer 			= "SELECT name,address,city FROM customer WHERE id = '$customer_id'";
	$result_customer 		= $conn->query($sql_customer);
	$customer 				= $result_customer->fetch_assoc();
	
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
	
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
	<title>Add sample data</title>
	<link rel='stylesheet' href='css/create_sample.css'></script>
</head>
<script>
	$('#sample_side').click();
	$('#sample_add_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sampling</h2>
	<p style='font-family:museo'>Add sampling</p>
	<hr>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Sample</label>
	<form action='sample_add_input.php' method='POST' id='sample_form'>
	<input type='hidden' value='<?= $_POST['customer'] ?>' name='customer' readonly>
	<input type='hidden' value='<?= $guid ?>' name='guid' readonly>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
		$i					= 1;
		foreach($reference_array as $reference){
			$key			= key($reference_array);
			$quantity		= $quantity_array[$key];
			$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 	= $conn->query($sql_item);
			$item 			= $result_item->fetch_assoc();
			$description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $quantity ?></td>
			</tr>
			<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $i ?>]' readonly'>
			<input type='hidden' value='<?= mysqli_real_escape_string($conn,$reference) ?>' name='reference[<?= $i ?>]' readonly>
<?php
			$i++;
			next($reference_array);
		}
?>
		</table>
	</form>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h2 style='font-size:2em;color:red;'><i class='fa fa-exclamation'></i></h2>
		<p style='font-family:museo'>Are you sure to confirm this sample?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#submit_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$('#sample_form').submit();
	});
</script>