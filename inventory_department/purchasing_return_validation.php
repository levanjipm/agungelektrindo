<?php	
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$id				= $_POST['id'];
	$sql_code 				= "SELECT users.name as creator, code_purchase_return.id, code_purchase_return.submission_date, supplier.name 
								FROM code_purchase_return 
								JOIN supplier ON supplier.id = code_purchase_return.supplier_id
								JOIN users ON code_purchase_return.created_by  = users.id
								WHERE code_purchase_return.id = '$id'";
	$result_code 			= $conn->query($sql_code);
	$code 					= $result_code->fetch_assoc();
	$return_id				= $code['id'];
	$submission_date		= $code['submission_date'];
	$supplier_name			= $code['name'];
	$creator_name			= $code['creator'];
	
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
	<title>Purchasing return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Purchasing return</p>
	<hr>
	<label>General data</label>
	<p style='font-family:museo'>Submited on <?= date('d M Y',strtotime($submission_date)) ?></p>
	<p style='font-family:museo'>Created by <?= $creator_name ?></p>
	
	<label>Return data</label>
	<form action='purchasing_return_input' method='POST' id='purchasing_return_form'>
		<input type='date' class='form-control' id='return_date' name='return_date'>
		<input type='hidden' class='form-control' name='return_id' value='<?= $id ?>'>
		<input type='hidden' value='<?= $guid ?>' name='guid'>
		<br>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>Reference</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Return</th>
				</tr>
			</thead>
<?php
	$sql					= "SELECT purchase_return.sent_quantity, purchase_return.id, purchase_return.reference, itemlist.description, purchase_return.quantity
								FROM purchase_return 
								JOIN itemlist ON itemlist.reference = purchase_return.reference	
								WHERE purchase_return.code_id = '$return_id' AND isdone = '0'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$purchase_return_id	= $row['id'];
		$reference			= $row['reference'];
		$description		= $row['description'];
		$quantity			= $row['quantity'];
		$sent				= $row['sent_quantity'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= number_format($quantity,0) ?></td>
				<td><input type='number' class='form-control' name='quantity[<?= $purchase_return_id ?>]' max='<?= $sent ?>' min='0'></td>
			</tr>
<?php
	}
?>
		</table>
		<button type='button' class='button_success_dark' id='check_return_data'>Submit</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:green'><i class='fa fa-check'></i></h1>
		<p style='font-familY:museo'>Are your sure to confirm this purchasing return</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_return_button'>Confirm</button>
	</div>
</div>
<script>
	$('#check_return_data').click(function(){
		var quantity_total			= 0;
		$('input[type="number"]').each(function(){
			quantity_total			= quantity_total + 0 + $(this).val();
		});
		
		if($('#return_date').val() == ''){
			alert('Please insert valid date!');
			$('#return_date').focus();
			return false;
		} else if(quantity_total		== 0){
			alert('Please insert valid quantity!');
			return false;
		} else {
			var window_height			= $(window).height();
			var notif_height			= $('.full_screen_notif_bar').height();
			var difference				= window_height - notif_height;
			$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
			$('.full_screen_wrapper').fadeIn(300);
		}
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
	
	$('#confirm_return_button').click(function(){
		$('#purchasing_return_form').submit();
	});
</script>